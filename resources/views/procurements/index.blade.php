@extends('layouts.master')

@section('title') Procurement @endsection

@section('css')
<!-- Additional CSS for procurements -->
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Procurement @endslot
        @slot('title') Data Procurement @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Data Procurement</h4>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: '{{ session('success') }}',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        </script>
                    @endif

                    <div class="listjs-table" id="procurementList">
                        <div class="row g-4 mb-3">
                            <div class="col-sm-auto">
                                <button type="button" class="btn btn-success add-btn" id="create-btn" onclick="location.href='{{ route('procurements.create') }}'" title="Tambah procurement baru">
                                    <i class="ri-add-line align-bottom me-1"></i> Tambah Procurement
                                </button>
                            </div>
                            <div class="col-sm">
                                <div class="d-flex justify-content-sm-end">
                                    <div class="search-box ms-2">
                                        <input type="text" class="form-control search" placeholder="Cari..." id="searchInput">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive table-card mt-3 mb-1">
                            <table class="table align-middle table-nowrap mb-0" id="procurementTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Procurement</th>
                                        <th>Total Harga</th>
                                        <th>Jumlah Item</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @forelse ($procurements as $procurement)
                                    <tr>
                                        <td class="no">{{ ($procurements->currentPage() - 1) * $procurements->perPage() + $loop->iteration }}</td>
                                        <td class="title">{{ $procurement->title }}</td>
                                        <td class="price">Rp {{ number_format($procurement->total_price, 2, ',', '.') }}</td>
                                        <td>{{ $procurement->items->count() }} item</td>
                                        <td>{{ $procurement->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('procurements.edit', $procurement->id) }}" class="btn btn-sm btn-success edit-item-btn" title="Edit">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <a href="{{ route('procurements.show', $procurement->id) }}" class="btn btn-sm btn-primary show-item-btn" title="Lihat Detail">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger remove-item-btn" title="Hapus" onclick="confirmDelete('{{ route('procurements.destroy', $procurement->id) }}')">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Tidak ada procurement ditemukan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-end mt-3">
                                {{ $procurements->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>
    </div>
@endsection

@section('script')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Check for session success message and show SweetAlert
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif

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

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#procurementTable tbody tr');
            
            rows.forEach(row => {
                const title = row.querySelector('.title').textContent.toLowerCase();
                const price = row.querySelector('.price').textContent.toLowerCase();
                
                if (title.includes(searchValue) || price.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
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