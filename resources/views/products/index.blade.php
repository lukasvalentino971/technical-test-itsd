@extends('layouts.master')

@section('title') Produk @endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Produk @endslot
        @slot('title') Data Produk @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Data Produk</h4>
                </div>

                <div class="card-body">

                    {{-- MODIFICATION START --}}
                    @if ($lowStockCount > 0)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Peringatan Stok Rendah!</strong> Ada <strong>{{ $lowStockCount }}</strong> produk dengan stok kritis (&lt;10). Segera lakukan restock!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    {{-- MODIFICATION END --}}

                    <div class="listjs-table" id="productList">
                        <div class="row g-4 mb-3">
                            <div class="col-sm-auto">
                                <button type="button" class="btn btn-success add-btn" id="create-btn" onclick="location.href='{{ route('products.create') }}'" title="Tambah produk baru">
                                    <i class="ri-add-line align-bottom me-1"></i> Tambah Produk
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
                            <table class="table align-middle table-nowrap mb-0" id="productTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Vendor</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @forelse ($products as $product)
                                    <tr>
                                        <td class="no">{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                                        <td class="name">{{ $product->name }}</td>
                                        <td class="price">Rp {{ number_format($product->price, 2, ',', '.') }}</td>
                                        <td class="stock">
                                            @if ($product->stocks < 10)
                                                <span class="badge bg-danger-subtle text-danger" title="Stok menipis!">
                                                    {{ $product->stocks }}
                                                </span>
                                            @else
                                                {{ $product->stocks }}
                                            @endif
                                        </td>
                                        <td class="vendor">{{ $product->vendor->name ?? '-' }}</td>
                                        <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-success edit-item-btn" title="Edit">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-primary show-item-btn" title="Lihat">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger remove-item-btn" title="Hapus" onclick="confirmDelete('{{ route('products.destroy', $product->id) }}')">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Tidak ada produk ditemukan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-end mt-3">
                                {{ $products->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div></div></div>
    </div>
@endsection

@section('script')
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
                text: "Produk yang dihapus tidak dapat dikembalikan!",
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
            const rows = document.querySelectorAll('#productTable tbody tr');
            
            rows.forEach(row => {
                const name = row.querySelector('.name').textContent.toLowerCase();
                const price = row.querySelector('.price').textContent.toLowerCase();
                const stock = row.querySelector('.stock').textContent.toLowerCase().trim();
                const vendor = row.querySelector('.vendor').textContent.toLowerCase();
                
                if (name.includes(searchValue) || price.includes(searchValue) || stock.includes(searchValue) || vendor.includes(searchValue)) {
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