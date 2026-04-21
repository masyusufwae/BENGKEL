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

// 1. Halaman Utama (Landing Page)
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('home');

// Halaman Detail Layanan Dinamis
Route::get('/services/{slug}', function ($slug) {
    if (Auth::check() && request()->is('/')) {
        // Just bypass if auth logic leaks
    }

    $services = [
        'engine-tuning' => [
            'title' => 'Engine Tuning & Remap',
            'main_image' => 'https://images.unsplash.com/photo-1625047509248-ec889cbff17f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'description_1' => 'At our high-performance workshop, you\'ll discover top-tier engine diagnostics and remapping solutions tailored to unleash your vehicle\'s full potential. Whether you are looking for increased horsepower, better fuel economy, or specialized track adjustments, our certified technicians are ready to guide you.',
            'description_2' => 'We provide comprehensive ECU remapping (Stage 1 to Stage 3), ensuring that the software perfectly complements your engine’s hardware upgrades. Every tune is rigorously dyno-tested to ensure it meets our strict standards for both performance and reliability.',
            'description_3' => 'Our tuning center is equipped with state-of-the-art AWD dynamometers and diagnostic tools. From routine sensor checks to complex forced-induction setups, we only use genuine and licensed software to maintain the integrity of your powertrain.',
            'highlight_text' => 'We offer flexible tuning staged packages tailored to your performance goals and financial situation. Our expert team works closely with you to understand exactly what you want from your car.',
            'sub_image_1' => 'https://images.unsplash.com/photo-1541446059296-1abdd2561ea9?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'sub_image_2' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'subtitle' => 'Advanced Diagnostics',
            'sub_description' => "For those not looking for extreme power but maximum efficiency, we offer eco-tuning plans. Our team will work with you to find the perfect calibration that fits your daily driving needs.\n\nCan't find exactly the tune you're looking for? With our custom mapping service, you can build your ideal throttle response and power curve. We work directly with master tuners globally to deliver specific requirements."
        ],
        'heavy-service' => [
            'title' => 'Heavy Engine Overhaul',
            'main_image' => 'https://images.unsplash.com/photo-1635784964531-90a6e3505877?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'description_1' => 'When your vehicle requires major mechanical surgery, our engine overhaul service provides a total rebuild, bringing your car back to factory-fresh performance or better. We specialize in both block rebuilding and cylinder head machinery.',
            'description_2' => 'An engine overhaul involves completely disassembling the engine, cleaning all components, and replacing worn parts like piston rings, bearings, and gaskets. This meticulous process ensures true longevity and reliability for your prized vehicle.',
            'description_3' => 'We utilize specialized precision machinery to bore, hone, and deck engine blocks. All replacements adhere strictly to OEM specifications unless performance forged internals are requested by the client.',
            'highlight_text' => 'We provide comprehensive warranties on all our rebuilt engines. Drive with peace of mind knowing your vehicle was assembled by master technicians.',
            'sub_image_1' => 'https://images.unsplash.com/photo-1486262715619-67081300ce39?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'sub_image_2' => 'https://images.unsplash.com/photo-1510461683296-6d6f51cb7e4c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'subtitle' => 'Precision Machining Services',
            'sub_description' => "From balancing crankshafts to porting cylinder heads, our machine shop is fully equipped to handle complex engineering tasks in-house.\n\nNever compromise on quality. Our stringent quality control measures ensure every bolt is torqued perfectly according to constructor manuals."
        ],
        'general-maintenance' => [
            'title' => 'Periodic Maintenance',
            'main_image' => 'https://images.unsplash.com/photo-1493139369975-47eb021e5485?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'description_1' => 'Routine maintenance is the key to preserving your vehicle’s lifespan and ensuring your safety on the road. Our general maintenance service covers everything from rapid oil changes to extensive fluid flushes and brake inspections.',
            'description_2' => 'We follow the official maintenance schedules of all major vehicle manufacturers. By proactively replacing filters, checking belts, and inspecting the undercarriage, we prevent minor wear from becoming a major breakdown.',
            'description_3' => 'Our service bays are optimized for quick yet thorough inspections. We only use premium synthetic oils, OEM-grade filters, and high-performance brake components to guarantee optimal operation under any condition.',
            'highlight_text' => 'Join our Customer Loyalty Program for discounted rates on scheduled maintenance and priority bay reservations during peak seasons.',
            'sub_image_1' => 'https://images.unsplash.com/photo-1542282088-fe8426682b8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'sub_image_2' => 'https://images.unsplash.com/photo-1616423640778-28d1b53229bd?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'subtitle' => 'Scheduled Care Plans',
            'sub_description' => "Never miss a service interval again. We provide complete service history tracking and automated reminders tailored to your driving habits.\n\nWhether you need a quick pre-trip inspection or your annual 50,000 KM major service, our team is equipped to handle it efficiently and transparently."
        ],
        'custom-parts' => [
            'title' => 'Performance Spare Parts',
            'main_image' => 'https://images.unsplash.com/photo-1589716183362-e6bb1aebf5ba?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'description_1' => 'Searching for genuine OEM or high-end aftermarket parts? Our parts department supplies a vast inventory of rare and performance-oriented components to support your build or restoration project.',
            'description_2' => 'From forged pistons and turbochargers to carbon-ceramic brake kits and titanium exhaust systems, we source our parts directly from renowned global manufacturers. This ensures authenticity, perfect fitment, and reliable performance.',
            'description_3' => 'We also offer professional installation for all parts purchased through us. Our deep understanding of aftermarket parts compatibility guarantees that each component harmonizes with your entire setup.',
            'highlight_text' => 'We provide competitive pricing on all performance gear and offer specialized consulting to ensure you purchase the right parts for your specific build objectives.',
            'sub_image_1' => 'https://images.unsplash.com/photo-1517524008697-84bbe3c3fd98?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'sub_image_2' => 'https://images.unsplash.com/photo-1594966601815-5e60a3c20042?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
            'subtitle' => 'Parts Procurement',
            'sub_description' => "Struggling to find a rare JDM or Euro part? Use our bespoke procurement service. We have channels globally to import difficult-to-find components right to our shop floor.\n\nAll installed parts are backed by a comprehensive labor and material warranty."
        ]
    ];

    if (!array_key_exists($slug, $services)) {
        abort(404);
    }

    return view('service-details', [
        'service' => $services[$slug],
        'current_slug' => $slug,
        'all_services' => $services
    ]);
})->name('service.details');

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
        Route::get('/vehicles/{id}/edit', [CustomerController::class, 'vehiclesEdit'])->name('vehicles.edit');
        Route::patch('/vehicles/{id}', [CustomerController::class, 'vehiclesUpdate'])->name('vehicles.update');
        Route::delete('/vehicles/{id}', [CustomerController::class, 'vehiclesDestroy'])->name('vehicles.destroy');

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

Route::prefix('mekanik')->name('mekanik.')->middleware(['auth'])->group(function () {

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

   Route::get('work-order/{id}/servis', [\App\Http\Controllers\Mekanik\WorkOrderController::class, 'servis'])
    ->name('work-order.servis');

Route::post('work-order/{id}/servis', [\App\Http\Controllers\Mekanik\WorkOrderController::class, 'storeServis'])
    ->name('work-order.servis.store');
});

// 4. Memanggil Routes Autentikasi Breeze (Login, Register, Reset Password, dll)
require __DIR__ . '/auth.php';
