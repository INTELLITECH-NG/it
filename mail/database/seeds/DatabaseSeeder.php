<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Stuff Role
        $role = ['name' => 'stuff', 'display_name' => 'Stuff', 'description' => 'Fixed Permission'];
        $role = Role::create($role);

        // Create Admin Role
        $role = ['name' => 'admin', 'display_name' => 'Admin', 'description' => 'Full Permission'];
        $role = Role::create($role);

        // Create Admin User
        $user = ['name' => 'Admin', 'email' => 'admin@mail.com', 'password' => Hash::make('123456')];
        $user = User::create($user);
        // Set User Role
        $user->attachRole($role);
    }
}
