<?php

namespace App\Http\Controllers;
    
use App\Models\Products;
    use App\Models\Procurements;
    use App\Models\Vendor; // Pastikan nama model Vendor sudah benar
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    
    class DashboardController extends Controller
    {
        /**
         * Menampilkan halaman dashboard dengan data ringkasan.
         *
         * @return \Illuminate\View\View
         */
        public function index()
        {
            // Mengambil data ringkasan dari database
            $totalProcurementSpending = Procurements::sum('total_price');
            $totalProducts = Products::count();
            $totalVendors = Vendor::count();
            $totalProcurementTransactions = Procurements::count();
    
            // Mengambil 5 data procurement terbaru untuk ditampilkan di tabel aktivitas
            // Eager load relasi 'items' untuk efisiensi query
            $recentProcurements = Procurements::with('items')
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get();
    
            // Mengambil nama user yang sedang login
            $user = Auth::user();
    
            // Mengirim semua data yang diperlukan ke view 'dashboard'
            return view('index', compact(
                'user',
                'totalProcurementSpending',
                'totalProducts',
                'totalVendors',
                'totalProcurementTransactions',
                'recentProcurements'
            ));
        }
    }

