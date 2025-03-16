<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::truncate();

        $employees = [
            [
                'first_name' => 'Putu Denanta',
                'last_name' => 'Bayuguna',
                'company_uuid' => Company::all()->first()->uuid,
                'email' => 'putubayuguna@gmail.com',
                'phone' => '085931270707',
                'status' => 'ACTIVE',
                'created_by' => 'system'
            ],
        ];

        // Loop through the employees array and create a new employee with the Employee model:
        foreach ($employees as $key => $employee) {
            // Save the employee to the database
            Employee::create([
                'company_uuid' => $employee['company_uuid'],
                'first_name' => $employee['first_name'],
                'last_name' => $employee['last_name'],
                'email' => $employee['email'],
                'phone' => $employee['phone'],
                'status' => $employee['status'],
                'created_by' => $employee['created_by']
            ]);
        }


    }
}