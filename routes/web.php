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
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// vendors
Route::resource('vendors', App\Http\Controllers\VendorController::class);

// products
Route::resource('products', App\Http\Controllers\ProductsController::class);

//procurements
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('procurements', App\Http\Controllers\ProcurementsController::class);
});

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
