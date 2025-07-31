<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Product;
use App\Models\Products;
use App\Notifications\LowStockNotification;

class SendLowStockNotification extends Command
{
    protected $signature = 'notify:low-stock';
    protected $description = 'Send email notification to admin users about low stock products';

    public function handle()
    {
        // Ambil produk dengan stok kurang dari 10
        $lowStockProducts = Products::where('stocks', '<', 10)->get();

        // Jika ada produk stok rendah
        if ($lowStockProducts->count() > 0) {
            // Ambil semua user dengan role admin
            $adminUsers = User::where('role', 'user')->get();

            // Kirim notifikasi ke setiap admin
            foreach ($adminUsers as $user) {
                $user->notify(new LowStockNotification($lowStockProducts));
            }

            $this->info('Low stock notifications sent successfully to ' . $adminUsers->count() . ' users.');
        } else {
            $this->info('No low stock products found. No notifications sent.');
        }
    }
}