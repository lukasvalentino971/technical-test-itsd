<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

// Root
Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

// Routes that require authentication
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Update user details
    Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

    // Vendors
    Route::resource('vendors', App\Http\Controllers\VendorController::class);

    // Products
    Route::resource('products', App\Http\Controllers\ProductsController::class);

    // Procurements (only for admin)
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('procurements', App\Http\Controllers\ProcurementsController::class);
        Route::get('/procurement-report', [App\Http\Controllers\ProcurementsController::class, 'report'])->name('procurements.report');
    });
});

// Catch-all fallback (optional, accessible without auth)
Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
