<?php

namespace Database\Seeders;

use App\Models\Access;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Access::truncate();
        $accesses = [
            [
                'name' => 'dashboard',
            ],
            [
                'name' => 'employee:view',
            ],
            [
                'name' => 'employee:create',
            ],
            [
                'name' => 'employee:update',
            ],
            [
                'name' => 'employee:delete',
            ],
            [
                'name' => 'company:view',
            ],
            [
                'name' => 'company:create',
            ],
            [
                'name' => 'company:update',
            ],
            [
                'name' => 'company:delete',
            ],
            [
                'name' => 'role:view',
            ],
            [
                'name' => 'role:create',
            ],
            [
                'name' => 'role:update',
            ],
            [
                'name' => 'role:delete',
            ],
            [
                'name' => 'access:view',
            ],
            [
                'name' => 'access:create',
            ],
            [
                'name' => 'access:update',
            ],
            [
                'name' => 'access:delete',
            ],
            [
                'name' => 'user:view',
            ],
            [
                'name' => 'user:create',
            ],
            [
                'name' => 'user:update',
            ],
            [
                'name' => 'user:delete',
            ],
        ];

        // Loop through the accesses array and create a new access with the Access model:
        foreach ($accesses as $key => $access) {
            // Save the access to the database
            Access::create([
                'name' => $access['name'],
            ]);
        }
    }
}
