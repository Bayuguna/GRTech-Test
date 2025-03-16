<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::truncate();
        $companies = [
            [
                'name' => 'GR Tech',
                'email' => 'company@grtech.com',
                'phone' => '1234567890',
                'address' => '123 Main St, New York, NY 10001',
                'logo' => 'google.png',
                'website' => 'https://grtech.com',
                'status' => 'ACTIVE',
            ],
        ];

        // Loop through the companies array and create a new company with the Company model:
        foreach ($companies as $key => $company) {
            // Save the company to the database
            Company::create([
                'name' => $company['name'],
                'email' => $company['email'],
                'phone' => $company['phone'],
                'address' => $company['address'],
                'logo' => $company['logo'],
                'website' => $company['website'],
                'status' => $company['status'],
            ]);
        }
    }
}