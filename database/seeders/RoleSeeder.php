<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::truncate();
        $roles = [
            [
                'name' => 'Admin',
            ],
            [
                'name' => 'User',
            ]
        ];

        // Loop through the roles array and create a new role with the Role model:
        foreach ($roles as $key => $role) {
            // Save the role to the database
            Role::create([
                'name' => $role['name'],
            ]);
        }
    }
}