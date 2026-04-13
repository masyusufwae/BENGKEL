<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MekanikController;
use App\Http\Controllers\Admin\JenisServisController;
use App\Http\Controllers\Admin\SparepartController;
use App\Http\Controllers\Admin\WorkOrderController;

Route::prefix('admin')->group(function () {
    Route::get('/', fn () => redirect()->route('dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('mekanik', MekanikController::class);
    Route::resource('jenis-servis', JenisServisController::class);
    Route::resource('sparepart', SparepartController::class);
    Route::resource('work-order', WorkOrderController::class);
});

require __DIR__.'/auth.php';
