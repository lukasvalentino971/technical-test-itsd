@component('vendor.mail.message')
# Notifikasi Stok Rendah

Berikut daftar produk dengan stok kurang dari 10:

@component('vendor.mail.table')
| Nama Produk | Harga | Stok | Vendor |
|-------------|-------|------|--------|
@foreach($products as $product)
| {{ $product->name }} | Rp {{ number_format($product->price, 2, ',', '.') }} | {{ $product->stocks }} | {{ $product->vendor->name }} |
@endforeach
@endcomponent

<div style="margin-top: 20px;">
    <a href="{{ url('/products') }}" class="button" style="background-color: #405189; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
        Lihat Produk di Sistem
    </a>
</div>

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent