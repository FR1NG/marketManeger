<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ownerRole = Role::create([
            'name' => 'owner',
            'display_name' => 'Project Owner', // optional
            'description' => 'User is the owner of a given project', // optional
        ]);

        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'User Administrator', // optional
            'description' => 'User is allowed to manage and edit other users', // optional
        ]);

        $userRole = Role::create([
            'name' => 'user',
            'display_name' => 'user', // optional
            'description' => 'manage market', // optional
        ]);

        $owner =  User::create([
            "name" => "owner",
            "email" => "owner@meediaty.com",
            "password" => Hash::make("password")
        ]);

        $admin =  User::create([
            "name" => "admin",
            "email" => "admin@meediaty.com",
            "password" => Hash::make("password")
        ]);

        $user =  User::create([
            "name" => "user",
            "email" => "user@meediaty.com",
            "password" => Hash::make("password")
        ]);

        $owner->attachRole($ownerRole);
        $admin->attachRole($adminRole);
        $user->attachRole($userRole);
    }
}
