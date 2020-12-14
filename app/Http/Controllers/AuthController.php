<?php

namespace App\Http\Controllers;

require __DIR__ . '/vendor/autoload.php';

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");

        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($data['phone'], "sms");

        $user = User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

        $role = Role::where('name', '=', 'user')->first();
        $user->attachRole($role);

        return redirect()->route('verify')->with(['phone' => $data['phone']]);
    }

    protected function verify(Request $request)
    {
        $data = $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone' => ['required', 'string'],
        ]);

        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");

        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($data['verification_code'], array('to' => $data['phone']));

        if ($verification->valid) {
            $user = tap(User::where('phone', $data['phone']))->update(['isVerified' => true]);
            /* Authenticate user */
            Auth::login($user->first());
            return redirect()->route('home')->with(['message' => 'Phone number verified']);
        }
        return back()->with(['phone' => $data['phone'], 'error' => 'Invalid verification code entered!']);
    }
}
