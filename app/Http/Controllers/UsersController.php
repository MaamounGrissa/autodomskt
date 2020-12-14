<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UsersController extends Controller
{
    use RegistersUsers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::All();
        return view('admin.usersManager.usersIndex', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.usersManager.usersAdd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'phone'      => 'required|numeric|unique:users',
            'isVerified' => 'required',
            'password'   => 'required|string|min:8',
            'userType'   => 'required',
        ]);

        $user = User::create([
            'name'       => $request->get('name'),
            'email'      => $request->get('email'),
            'phone'      => $request->get('phone'),
            'isVerified' => filter_var($request->get('isVerified'), FILTER_VALIDATE_BOOLEAN),
            'password'   => Hash::make($request->get('password')),
        ]);

        $role = Role::where('name', '=', $request->get('userType'))->first();
        $user->attachRole($role); 

        return redirect()->route('users.index')->with('success', 'User Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $isverified = $user->isVerified ? 'true' : 'false';
        if ($user->hasRole('admin')) {
            $usertype = 'admin';
        } else {
            $usertype = 'user';
        }

        return view('admin.usersManager.usersEdit', compact('user', 'isverified', 'usertype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255',
            'phone'      => 'required|numeric',
            'isVerified' => 'required',
            'userType'   => 'required',
        ]);

        $user = user::find($id);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->phone = $request->get('phone');
        $user->isVerified = filter_var($request->get('isVerified'), FILTER_VALIDATE_BOOLEAN);

        $user->save();

        $role = Role::where('name', '=', $request->get('userType'))->first();
        $user->syncRoles([$role]);

        return redirect()->route('users.index')->with('success', 'User Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        
        if($user->hasRole('admin')) {
            $role = Role::where('name', '=', 'admin')->first();
        } else {
            $role = Role::where('name', '=', 'user')->first();
        }

        $user->detachRole($role); 
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User Deleted !');
    }

    public function resetPassword(Request $request) {

        $data = $request->all();

        $user = user::find($data['id']);
        $user->password = Hash::make($data['password']);
        $user->save();

        return response()->json(['success'=> 'Password Modified']);

    }
}
