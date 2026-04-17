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

// Mekanik Work Order Routes

  Route::prefix('mekanik')->name('mekanik.')->group(function () {

    Route::get('work-order', [\App\Http\Controllers\Mekanik\WorkOrderController::class, 'index'])->name('work-order.index');

    // Route::get('work-order/create', [\App\Http\Controllers\Mekanik\WorkOrderController::class, 'create'])->name('work-order.create');

    // Route::post('work-order', [\App\Http\Controllers\Mekanik\WorkOrderController::class, 'store'])->name('work-order.store');

    Route::get('work-order/{id}', [\App\Http\Controllers\Mekanik\WorkOrderController::class, 'detail'])->name('work-order.detail');

    Route::get('work-order/{id}/edit', [\App\Http\Controllers\Mekanik\WorkOrderController::class, 'edit'])->name('work-order.edit');

    Route::put('work-order/{id}', [\App\Http\Controllers\Mekanik\WorkOrderController::class, 'update'])->name('work-order.update');

    Route::put('work-order/{id}/status', [\App\Http\Controllers\Mekanik\WorkOrderController::class, 'updateStatus'])->name('work-order.updateStatus');



    Route::put('work-order/{id}/catatan', [\App\Http\Controllers\Mekanik\WorkOrderController::class, 'updateCatatan'])->name('work-order.updateCatatan');

    Route::post('detail-servis', [\App\Http\Controllers\Mekanik\WorkOrderController::class, 'storeDetailServis'])->name('detail-servis.store');

    Route::post('penggunaan-part', [\App\Http\Controllers\Mekanik\WorkOrderController::class, 'storePenggunaanPart'])->name('penggunaan-part.store');



    // Riwayat Arsip Servis

    Route::get('riwayat', [\App\Http\Controllers\Mekanik\WorkOrderController::class, 'riwayat'])->name('riwayat');



    // Mekanik Sparepart Routes

    Route::get('sparepart', [\App\Http\Controllers\Mekanik\SparepartController::class, 'index'])->name('sparepart.index');

    Route::get('sparepart/tambah', [\App\Http\Controllers\Mekanik\SparepartController::class, 'create'])->name('sparepart.create');

    Route::get('sparepart/{id}', [\App\Http\Controllers\Mekanik\SparepartController::class, 'detail'])->name('sparepart.detail');

    Route::get('sparepart/{id}/edit', [\App\Http\Controllers\Mekanik\SparepartController::class, 'edit'])->name('sparepart.edit');

    Route::post('sparepart', [\App\Http\Controllers\Mekanik\SparepartController::class, 'store'])->name('sparepart.store');

    Route::put('sparepart/{id}', [\App\Http\Controllers\Mekanik\SparepartController::class, 'update'])->name('sparepart.update');

    Route::put('sparepart/update-stok', [\App\Http\Controllers\Mekanik\SparepartController::class, 'updateStok'])->name('sparepart.updateStok');

  });

// 4. Memanggil Routes Autentikasi Breeze (Login, Register, Reset Password, dll)
require __DIR__.'/auth.php';
