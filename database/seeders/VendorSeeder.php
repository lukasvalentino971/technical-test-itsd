<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vendors')->insert([
            [
                'name' => 'Admin Vendor',
                'email' => 'admin@vendor.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567890',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Regular Vendor 1',
                'email' => 'vendor1@example.com',
                'password' => Hash::make('password123'),
                'phone' => '082345678901',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Regular Vendor 2',
                'email' => 'vendor2@example.com',
                'password' => Hash::make('password123'),
                'phone' => '083456789012',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}