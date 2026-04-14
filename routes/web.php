<?php
<<<<<<< HEAD
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
=======

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// 1. Halaman Utama dengan Logic Redirect jika sudah login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->intended('/dashboard');
    }
    return view('welcome');
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

    // Logout (Opsional: Breeze sudah punya ini di auth.php, tapi jika ingin tetap pakai logic manualmu)
    // Route::post('/logout', ...);
>>>>>>> c99bb5fd5290a672e47c157edc772b047d501034
});

// 4. Memanggil Routes Autentikasi Breeze (Login, Register, Reset Password, dll)
require __DIR__.'/auth.php';
