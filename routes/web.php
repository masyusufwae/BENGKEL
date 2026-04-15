<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
//crud admin
use App\Http\Controllers\Admin\MekanikController;
use App\Http\Controllers\Admin\ServisController;
use App\Http\Controllers\Admin\SparepartController;
use App\Http\Controllers\Admin\WorkOrderController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\LaporanController;

// 1. Halaman Utama dengan Logic Redirect jika sudah login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->intended('/dashboard');
    }
    return redirect()->route('login');
});

// 2. Dashboard Route (Menggunakan DashboardController sesuai kode kamu)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 3. Authenticated Routes (Grup middleware untuk user yang sudah login)
Route::middleware('auth')->group(function () {

    // Profile Routes bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Customer Routes (Pelanggan)
    Route::prefix('customer')->name('customer.')->group(function () {
        // Vehicles (Kendaraan)
        Route::get('/vehicles', [CustomerController::class, 'vehiclesIndex'])->name('vehicles.index');
        Route::get('/vehicles/create', [CustomerController::class, 'vehiclesCreate'])->name('vehicles.create');
        Route::post('/vehicles', [CustomerController::class, 'vehiclesStore'])->name('vehicles.store');

        // Orders (Pesanan Service)
        Route::get('/orders', [CustomerController::class, 'ordersIndex'])->name('orders.index');
        Route::get('/orders/create', [CustomerController::class, 'ordersCreate'])->name('orders.create');
        Route::post('/orders', [CustomerController::class, 'ordersStore'])->name('orders.store');

        // Invoices (Tagihan)
        Route::get('/invoices', [CustomerController::class, 'invoicesIndex'])->name('invoices.index');
    });

    // Logout (Opsional: Breeze sudah punya ini di auth.php, tapi jika ingin tetap pakai logic manualmu)
    // Route::post('/logout', ...);
});

// Admin crud routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('mekanik', MekanikController::class);
    Route::resource('servis', ServisController::class);
    Route::resource('sparepart', SparepartController::class);
    Route::resource('work-order', WorkOrderController::class);
    Route::get('invoice', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('invoice/cetak/{id}', [InvoiceController::class, 'cetak'])->name('invoice.cetak');
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('laporan/generate', [LaporanController::class, 'generate'])->name('laporan.generate');
});

// 4. Memanggil Routes Autentikasi Breeze (Login, Register, Reset Password, dll)
require __DIR__.'/auth.php';
