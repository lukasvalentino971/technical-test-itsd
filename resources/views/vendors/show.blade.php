@extends('layouts.master')
@section('title', 'Detail Vendor')

@section('content')
@component('components.breadcrumb')
@slot('li_1') Vendor @endslot
@slot('title') Detail Vendor @endslot
@endcomponent

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Detail Vendor</h4>
                        <a href="{{ route('vendors.index') }}" class="btn btn-secondary btn-sm">
                            <i class="ri-arrow-left-line align-bottom me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="30%" class="bg-light">Nama Vendor</th>
                                    <td>{{ $vendor->name }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Email</th>
                                    <td>{{ $vendor->email }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Daftar</th>
                                    <td>{{ $vendor->created_at->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Terakhir Diupdate</th>
                                    <td>{{ $vendor->updated_at->format('d F Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex justify-content-start gap-2">
                            <a href="{{ route('vendors.edit', $vendor->id) }}" class="btn btn-success">
                                <i class="ri-edit-line align-bottom me-1"></i> Edit
                            </a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('vendors.destroy', $vendor->id) }}')">
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
            text: "Vendor yang dihapus tidak dapat dikembalikan!",
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
@endsection