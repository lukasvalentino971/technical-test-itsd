@extends('layouts.master')
@section('title', 'Buat Produk Baru')

@section('content')
@component('components.breadcrumb')
@slot('li_1') Produk @endslot
@slot('title') Buat Produk Baru @endslot
@endcomponent

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Buat Produk Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf

                        {{-- Vendor --}}
                        <div class="mb-3">
                            <label for="vendor_id" class="form-label">Vendor</label>
                            <select class="form-select @error('vendor_id') is-invalid @enderror" 
                                    id="vendor_id" name="vendor_id" required>
                                <option value="">Pilih Vendor</option>
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                        {{ $vendor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vendor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama Produk --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Harga --}}
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price') }}" min="0" step="0.01" required>
                                @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- stocks --}}
                        <div class="mb-3">
                            <label for="stocks" class="form-label">Stok</label>
                            <input type="number" class="form-control @error('stocks') is-invalid @enderror" 
                                   id="stocks" name="stocks" value="{{ old('stocks') }}" min="0" required>
                            @error('stocks')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Simpan Produk</button>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Produk berhasil dibuat',
            text: '{{ session('success') }}',
        });
    @endif

    // Format input harga
    document.addEventListener('DOMContentLoaded', function() {
        const priceInput = document.getElementById('price');
        
        priceInput.addEventListener('change', function() {
            if(this.value) {
                this.value = parseFloat(this.value).toFixed(2);
            }
        });
    });
</script>
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>
<script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/dashboard-ecommerce.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection