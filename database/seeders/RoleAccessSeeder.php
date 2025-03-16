<?php

namespace Database\Seeders;

use App\Models\Access;
use App\Models\Role;
use App\Models\RoleAccess;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::where('name', '=', 'Admin')->first();
        $accesses = Access::all();

        foreach ($accesses as $access) {
            RoleAccess::create([
                'role_uuid' => $role->uuid,
                'access_uuid' => $access->uuid
            ]);
        }
    }
}