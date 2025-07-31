<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Products;

class LowStockNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $lowStockProducts;

    public function __construct($lowStockProducts)
    {
        $this->lowStockProducts = $lowStockProducts;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

// Di LowStockNotification.php
public function toMail($notifiable)
{
    $message = (new MailMessage)
                ->subject('Notifikasi Stok Rendah')
                ->line('Berikut produk dengan stok kurang dari 10:');
    
    foreach ($this->lowStockProducts as $product) {
        $message->line(
            "{$product->name} - Rp " . number_format($product->price, 2, ',', '.') . 
            " - Stok: {$product->stocks} - Vendor: {$product->vendor->name}"
        );
    }
    
    $message->action('Lihat Produk', url('/products'))
            ->line('Terima kasih');
    
    return $message;
}

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}