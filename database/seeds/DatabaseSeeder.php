<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaratrustSeeder::class);
        // $this->call(UserSeeder::class);

        DB::table('users')->insert([
            'name'       => 'Maamoun',
            'email'      => 'grissa.maamoun@gmail.com',
            'phone'      => '+21650870256',
            'isVerified' => true,
            'password'   => Hash::make('Grissa1906'),
        ]);

        DB::table('users')->insert([
            'name'        => 'user',
            'email'       => 'user@user.com',
            'phone'       => '+21650870255',
            'isVerified'  => true,
            'password'    => Hash::make('Grissa1906'),
        ]);

         //first user as admin
         $user1 = User::find('1');   //get user where id is 1
         $role = Role::where('name', '=', 'admin')->first();
         $user1->attachRole($role); 

         //second user as editor
         $user2 = User::find('2'); //get user where id is 2
         $role = Role::where('name', '=', 'user')->first();
         $user2->attachRole($role);
    }
}
