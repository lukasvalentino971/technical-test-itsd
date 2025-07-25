{{-- resources/views/procurements/report.blade.php --}}

@extends('layouts.master')

@section('title') Laporan Procurement @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Procurement @endslot
        @slot('title') Laporan Procurement @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Laporan Lengkap Procurement</h4>
                        <button onclick="window.print()" class="btn btn-primary btn-sm">
                            <i class="ri-printer-line align-bottom me-1"></i> Cetak Laporan
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    @forelse ($procurements as $procurement)
                        <div class="mb-4">
                            {{-- Informasi Utama Procurement --}}
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Judul: {{ $procurement->title }}</h5>
                                    <p class="text-muted mb-0">
                                        Tanggal: {{ $procurement->created_at->format('d F Y') }} | 
                                        Total: <strong>Rp {{ number_format($procurement->total_price, 2, ',', '.') }}</strong>
                                    </p>
                                </div>
                                <div class="card-body">
                                    <h6 class="mb-3">Detail Item Pembelian:</h6>
                                    
                                    {{-- Tabel Item Produk --}}
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-striped">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 50px;">No</th>
                                                    <th>Nama Produk</th>
                                                    <th>Vendor</th>
                                                    <th>Jumlah</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($procurement->items as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        {{-- Menampilkan nama produk, dengan fallback jika produk terhapus --}}
                                                        <td>{{ $item->product->name ?? 'N/A' }}</td>
                                                        {{-- Menampilkan nama vendor, dengan fallback jika relasi tidak ditemukan --}}
                                                        <td>{{ $item->product->vendor->name ?? 'N/A' }}</td>
                                                        <td>{{ $item->qty }}</td>
                                                        <td>Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                                                        <td>Rp {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted">
                                                            Tidak ada item dalam procurement ini.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-warning text-center">
                            Tidak ada data procurement untuk ditampilkan dalam laporan.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- Tambahkan script khusus jika diperlukan --}}
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .card, .card *, .main-content, .main-content * {
                visibility: visible;
            }
            .main-content {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .btn {
                display: none;
            }
        }
    </style>
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/dashboard-ecommerce.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection