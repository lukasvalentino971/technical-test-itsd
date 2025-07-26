<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Laptop',
                'price' => 8500000.00,
                'stocks' => 50,
                'vendor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Printer',
                'price' => 2500000.00,
                'stocks' => 30,
                'vendor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Monitor',
                'price' => 1800000.00,
                'stocks' => 75,
                'vendor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Keyboard',
                'price' => 350000.00,
                'stocks' => 120,
                'vendor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mouse',
                'price' => 150000.00,
                'stocks' => 200,
                'vendor_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}