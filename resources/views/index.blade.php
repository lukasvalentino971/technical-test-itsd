@extends('layouts.master')
@section('title') @lang('translation.dashboards') @endsection
@section('css')
{{-- CSS bawaan template bisa dibiarkan --}}
<link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('translation.dashboards') @endslot
@slot('title') Dashboard @endslot
@endcomponent

<div class="row">
    <div class="col">
        <div class="h-100">
            <div class="row mb-3 pb-1">
                <div class="col-12">
                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                        <div class="flex-grow-1">
                            {{-- Sapaan dinamis berdasarkan waktu dan nama user --}}
                            @php
                                $hour = date('G');
                                $greeting = "";
                                if ($hour >= 5 && $hour < 12) {
                                    $greeting = "Selamat Pagi";
                                } elseif ($hour >= 12 && $hour < 18) {
                                    $greeting = "Selamat Siang";
                                } else {
                                    $greeting = "Selamat Malam";
                                }
                            @endphp
                            <h4 class="fs-16 mb-1">{{ $greeting }}, {{ $user->name ?? 'Guest' }}!</h4>
                            <p class="text-muted mb-0">Berikut adalah ringkasan data dari sistem Anda.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Baris untuk Kartu Ringkasan (Summary Cards) --}}
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Pengeluaran</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">Rp {{ number_format($totalProcurementSpending, 0, ',', '.') }}</h4>
                                    <a href="{{ route('procurements.report') }}" class="text-decoration-underline">Lihat Laporan</a>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-success-subtle rounded fs-3">
                                        <i class="ri-wallet-2-line text-success"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Jumlah Produk</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ number_format($totalProducts) }}</h4>
                                    <a href="{{ route('products.index') }}" class="text-decoration-underline">Lihat Produk</a>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-info-subtle rounded fs-3">
                                        <i class="ri-archive-line text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Jumlah Vendor</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ number_format($totalVendors) }}</h4>
                                    <a href="{{ route('vendors.index') }}" class="text-decoration-underline">Lihat Vendor</a>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-warning-subtle rounded fs-3">
                                        <i class="ri-store-2-line text-warning"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total TransAction</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ number_format($totalProcurementTransactions) }}</h4>
                                    <a href="{{ route('procurements.index') }}" class="text-decoration-underline">Lihat TransAction</a>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary-subtle rounded fs-3">
                                        <i class="ri-shopping-cart-2-line text-primary"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end row -->

            {{-- Baris untuk Tabel Aktivitas Terbaru --}}
            <div class="row">
                <!-- Aktivitas Procurement Terbaru -->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Aktivitas Procurement Terbaru</h4>
                            <div class="flex-shrink-0">
                                <a href="{{ route('procurements.index') }}" class="btn btn-soft-info btn-sm">Lihat Semua</a>
                            </div>
                        </div><!-- end card header -->
            
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-hover table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Judul Procurement</th>
                                            <th>Total Harga</th>
                                            <th>Jumlah Item</th>
                                            <th>Tanggal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentProcurements as $procurement)
                                        <tr>
                                            <td>{{ $procurement->title }}</td>
                                            <td>Rp {{ number_format($procurement->total_price, 0, ',', '.') }}</td>
                                            <td>{{ $procurement->items->count() }} item</td>
                                            <td>{{ $procurement->created_at->format('d M Y, H:i') }}</td>
                                            <td>
                                                <a href="{{ route('procurements.show', $procurement->id) }}" class="btn btn-sm btn-soft-primary">Detail</a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Belum ada aktivitas procurement.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Kartu Produk Stok Rendah --}}
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Stok Produk Terendah</h4>
                            <div class="flex-shrink-0">
                                <a href="{{ route('products.index') }}" class="btn btn-soft-info btn-sm">Lihat Semua</a>
                            </div>
                        </div>
                        
                        
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-hover table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nama Produk</th>
                                            <th>Vendor</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($lowStockProducts as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->vendor->name }}</td>
                                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                            <td>{{ $product->stocks }}</td>
                                            <td>
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-soft-primary">Detail</a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Tidak ada produk dengan stok kritis (<10).</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                            </div>
                        </div>
                    </div>
                </div>

@endsection
@section('script')
{{-- Script bawaan template bisa dibiarkan --}}
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>
<script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/dashboard-ecommerce.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
