@extends('layouts.master')
@section('title', 'Detail Procurement')

@section('content')
@component('components.breadcrumb')
@slot('li_1') Procurement @endslot
@slot('title') Detail Procurement @endslot
@endcomponent

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Detail Procurement</h4>
                        <a href="{{ route('procurements.index') }}" class="btn btn-secondary btn-sm">
                            <i class="ri-arrow-left-line align-bottom me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="25%" class="bg-light">Judul Procurement</th>
                                    <td>{{ $procurement->title }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Total Harga</th>
                                    <td class="fw-bold">Rp {{ number_format($procurement->total_price, 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Dibuat</th>
                                    <td>{{ $procurement->created_at->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Terakhir Diupdate</th>
                                    <td>{{ $procurement->updated_at->format('d F Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h5 class="mb-3">Daftar Produk</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="40%">Nama Produk</th>
                                    <th width="15%" class="text-end">Harga Satuan</th>
                                    <th width="10%" class="text-end">Qty</th>
                                    <th width="15%" class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($procurement->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product->name }}</td>
                                    <td class="text-end">Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                                    <td class="text-end">{{ $item->qty }}</td>
                                    <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                                </tr>
                                @endforeach
                                <tr class="table-active">
                                    <td colspan="4" class="text-end fw-bold">Total</td>
                                    <td class="text-end fw-bold">Rp {{ number_format($procurement->total_price, 2, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex justify-content-start gap-2">
                            <a href="{{ route('procurements.edit', $procurement->id) }}" class="btn btn-success">
                                <i class="ri-edit-line align-bottom me-1"></i> Edit
                            </a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('procurements.destroy', $procurement->id) }}')">
                                <i class="ri-delete-bin-line align-bottom me-1"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Function to show confirmation alert before delete
    function confirmDelete(url) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Procurement yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create a form dynamically and submit it
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                let csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                let methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    @endif
</script>
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>
<script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/dashboard-ecommerce.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection