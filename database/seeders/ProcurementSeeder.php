<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('procurements')->insert([
            [
                'title' => 'Office Equipment Q1 2023',
                'total_price' => 0, // Will be calculated by procurement items
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'IT Equipment for New Employees',
                'total_price' => 0, // Will be calculated by procurement items
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}