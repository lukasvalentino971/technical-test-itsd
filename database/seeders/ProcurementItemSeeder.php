<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcurementItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('procurement_items')->insert([
            // Items for Procurement 1
            [
                'procurement_id' => 1,
                'product_id' => 1,
                'qty' => 5,
                'price' => 8500000.00,
                'subtotal' => 42500000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'procurement_id' => 1,
                'product_id' => 2,
                'qty' => 2,
                'price' => 2500000.00,
                'subtotal' => 5000000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'procurement_id' => 1,
                'product_id' => 3,
                'qty' => 5,
                'price' => 1800000.00,
                'subtotal' => 9000000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Items for Procurement 2
            [
                'procurement_id' => 2,
                'product_id' => 4,
                'qty' => 10,
                'price' => 350000.00,
                'subtotal' => 3500000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'procurement_id' => 2,
                'product_id' => 5,
                'qty' => 10,
                'price' => 150000.00,
                'subtotal' => 1500000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Update the total_price in procurements table
        DB::table('procurements')
            ->where('id', 1)
            ->update(['total_price' => 42500000.00 + 5000000.00 + 9000000.00]);
            
        DB::table('procurements')
            ->where('id', 2)
            ->update(['total_price' => 3500000.00 + 1500000.00]);
    }
}