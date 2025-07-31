<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vendor;
use App\Models\Products;
use App\Notifications\LowStockNotification;

class SendLowStockNotification extends Command
{
    protected $signature = 'notify:low-stock';
    protected $description = 'Send email notification to admin vendors about low stock products';

    public function handle()
    {
        // Ambil produk dengan stok kurang dari 10
        $lowStockProducts = Products::with('vendor')
            ->where('stocks', '<', 10)
            ->get();

        // Jika ada produk stok rendah
        if ($lowStockProducts->count() > 0) {
            // Ambil semua vendor dengan role admin
            $adminVendors = Vendor::where('role', 'admin')->get();

            // Kirim notifikasi ke setiap admin vendor
            foreach ($adminVendors as $vendor) {
                $vendor->notify(new LowStockNotification($lowStockProducts));
            }

            $this->info('Low stock notifications sent successfully to ' . $adminVendors->count() . ' admin vendors.');
        } else {
            $this->info('No low stock products found. No notifications sent.');
        }
    }
}