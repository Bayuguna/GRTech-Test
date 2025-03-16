<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', '=', 'admin@grtech.com')->first();
        $role = Role::where('name', '=', 'Admin')->first();

        UserRole::create([
            'user_uuid' => $user->uuid,
            'role_uuid' => $role->uuid
        ]);
    }
}