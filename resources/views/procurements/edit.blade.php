@extends('layouts.master')
@section('title', 'Edit Procurement')

@section('content')
@component('components.breadcrumb')
@slot('li_1') Procurement @endslot
@slot('title') Edit Procurement @endslot
@endcomponent

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Procurement: {{ $procurement->title }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('procurements.update', $procurement->id) }}" method="POST" id="procurementForm">
                        @csrf
                        @method('PUT')

                        {{-- Judul Procurement --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Procurement</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $procurement->title) }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Daftar Produk --}}
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Daftar Produk</h5>
                                <button type="button" class="btn btn-sm btn-primary" id="addProductRow">
                                    <i class="fas fa-plus"></i> Tambah Produk
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="productsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="40%">Produk</th>
                                            <th width="15%">Harga</th>
                                            <th width="15%">Qty</th>
                                            <th width="15%">Subtotal</th>
                                            <th width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productRows">
                                        <!-- Baris produk yang sudah ada -->
                                        @foreach($procurement->items as $index => $item)
                                        <tr class="product-row">
                                            <td>
                                                <select class="form-select product-select" name="items[{{ $index }}][product_id]" required>
                                                    <option value="">Pilih Produk</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}" 
                                                            data-price="{{ $product->price }}"
                                                            {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                            {{ $product->name }} (Rp {{ number_format($product->price, 2) }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control price" 
                                                       name="items[{{ $index }}][price]" 
                                                       value="{{ number_format($item->price, 2) }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control qty" 
                                                       name="items[{{ $index }}][qty]" 
                                                       min="1" value="{{ $item->qty }}" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control subtotal" 
                                                       name="items[{{ $index }}][subtotal]" 
                                                       value="{{ number_format($item->subtotal, 2) }}" readonly>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger remove-row">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Total Harga</strong></td>
                                            <td colspan="2">
                                                <input type="text" class="form-control fw-bold" 
                                                       id="total_price" name="total_price" 
                                                       value="{{ number_format($procurement->total_price, 2) }}" readonly>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Update Procurement</button>
                            <a href="{{ route('procurements.index') }}" class="btn btn-secondary">Batal</a>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        let rowCount = {{ count($procurement->items) }};

        // Tambah baris produk
        $('#addProductRow').click(function() {
            const newRow = `
                <tr class="product-row">
                    <td>
                        <select class="form-select product-select" name="items[${rowCount}][product_id]" required>
                            <option value="">Pilih Produk</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                    {{ $product->name }} (Rp {{ number_format($product->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control price" name="items[${rowCount}][price]">
                    </td>
                    <td>
                        <input type="number" class="form-control qty" name="items[${rowCount}][qty]" min="1" value="1" required>
                    </td>
                    <td>
                        <input type="text" class="form-control subtotal" name="items[${rowCount}][subtotal]" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove-row">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#productRows').append(newRow);
            rowCount++;
        });

        // Hapus baris produk - fixed event delegation
        $(document).on('click', '.remove-row', function(e) {
            e.preventDefault();
            const row = $(this).closest('tr');
            
            // Show confirmation dialog
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Produk ini akan dihapus dari procurement",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Only remove if there's more than one row
                    if ($('#productRows tr').length > 1) {
                        row.remove();
                        calculateTotal();
                        // Reindex the remaining rows
                        reindexRows();
                    } else {
                        Swal.fire(
                            'Tidak bisa dihapus',
                            'Setidaknya harus ada satu produk dalam procurement',
                            'error'
                        );
                    }
                }
            });
        });

        // Reindex rows after deletion
        function reindexRows() {
            $('#productRows tr').each(function(index) {
                $(this).find('select, input').each(function() {
                    const name = $(this).attr('name');
                    if (name) {
                        $(this).attr('name', name.replace(/\[\d+\]/, `[${index}]`));
                    }
                });
            });
            rowCount = $('#productRows tr').length;
        }

        // Ketika produk dipilih
        $(document).on('change', '.product-select', function() {
            const row = $(this).closest('tr');
            const selectedOption = $(this).find('option:selected');
            const price = selectedOption.data('price');
            
            row.find('.price').val(formatRupiah(price));
            calculateSubtotal(row);
        });

        // Ketika qty diubah
        $(document).on('input', '.qty', function() {
            const row = $(this).closest('tr');
            calculateSubtotal(row);
        });

        // Hitung subtotal per baris
        function calculateSubtotal(row) {
            const price = parseFloat(row.find('.price').val().replace(/[^0-9.-]+/g,"")) || 0;
            const qty = parseInt(row.find('.qty').val()) || 0;
            const subtotal = price * qty;
            
            row.find('.subtotal').val(formatRupiah(subtotal));
            calculateTotal();
        }

        // Hitung total semua subtotal
        function calculateTotal() {
            let total = 0;
            
            $('.subtotal').each(function() {
                const value = parseFloat($(this).val().replace(/[^0-9.-]+/g,"")) || 0;
                total += value;
            });
            
            $('#total_price').val(formatRupiah(total));
        }

        // Format angka ke Rupiah
        function formatRupiah(angka) {
            return 'Rp ' + angka.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        // Inisialisasi pertama kali untuk setiap baris yang sudah ada
        $('.product-row').each(function() {
            const row = $(this);
            if (row.find('.product-select').val()) {
                calculateSubtotal(row);
            }
        });

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Procurement berhasil diupdate',
                text: '{{ session('success') }}',
            });
        @endif
    });
</script>
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>
<script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/dashboard-ecommerce.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection