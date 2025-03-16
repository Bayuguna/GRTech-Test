<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::truncate();
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@grtech.com',
                'password' => bcrypt('password'),
                'created_by' => 'system'
            ],
            [
                'name' => 'User',
                'email' => 'user@grtech.com',
                'password' => bcrypt('password'),
                'created_by' => 'system'
            ]
        ];

        // Loop through the users array and create a new user with the User model:
        foreach ($users as $key => $user) {
            // Save the user to the database
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
                'created_by' => $user['created_by']
            ]);
        }
    }
}