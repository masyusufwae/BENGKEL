<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RevAuto - Bengkel Modern</title>

    <link rel="icon" type="image/png" href="{{ asset('storage/logo/icon.png') }}?v=1">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- CSS Frameworks -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background-color: #0b1121; /* Dark navy background */
            color: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* Custom Navbar */
        .navbar-custom {
            background-color: transparent !important;
            padding: 1.5rem 5%;
            transition: all 0.3s ease;
            position: absolute;
            width: 100%;
            z-index: 50;
        }
        .navbar-custom.scrolled {
            background-color: rgba(11, 17, 33, 0.95) !important;
            padding: 1rem 5%;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            position: fixed;
        }

        .nav-link-custom {
            color: #fff !important;
            font-weight: 500;
            margin: 0 15px;
            letter-spacing: 0.5px;
            position: relative;
            text-transform: uppercase;
            font-size: 0.9rem;
        }
        .nav-link-custom::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: #3b82f6; /* Tailwind blue-500 */
            transition: width 0.3s;
        }
        .nav-link-custom:hover::after {
            width: 100%;
        }

        .btn-glow {
            background: transparent;
            color: #fff;
            border: 2px solid #3b82f6;
            border-radius: 30px;
            padding: 8px 25px;
            font-weight: 600;
            transition: all 0.3s;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }
        .btn-glow:hover {
            background: #3b82f6;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
            color: #fff;
        }

        /* Hero Section */
        .hero-section {
            height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            background: radial-gradient(circle at center, #1e293b 0%, #0b1121 70%);
        }

        .car-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
            opacity: 0;
            animation: fadeIn 2s ease forwards 0.3s;
        }

        .dark-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(11, 17, 33, 0.6); /* Dark navy with opacity */
            z-index: 1;
        }

        /* Subtle grid background over the dark overlay */
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: 2;
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            width: 100%;
            margin-top: 5vh;
        }

        .hero-title {
            font-size: 4.5rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 20px;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 1s ease forwards 0.2s;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: #94a3b8;
            max-width: 600px;
            margin: 0 auto 40px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 1s ease forwards 0.4s;
        }

        .hero-buttons {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 1s ease forwards 0.6s;
        }

        .about-image-main,
        .about-image-secondary {
            width: 100%;
            height: 260px;
            object-fit: cover;
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.25);
        }

        .about-image-secondary {
            height: 220px;
            margin-top: 14px;
        }

        .service-thumb {
            width: 100%;
            height: 130px;
            object-fit: cover;
            border-radius: 12px;
            position: relative;
            z-index: 10;
        }

        /* Stats Section */
        .stats-container {
            background: rgba(30, 41, 59, 0.5);
            border-top: 1px solid rgba(255,255,255,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            padding: 30px 0;
            position: relative;
            z-index: 20;
        }

        .stat-item {
            text-align: center;
            border-right: 1px solid rgba(255,255,255,0.1);
        }
        .stat-item:last-child { border-right: none; }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 5px;
        }
        .stat-label {
            color: #94a3b8;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Animations */
        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            to { opacity: 1; }
        }

    </style>
</head>
<body>
    @php
        $brand = $landingContent['brand'] ?? 'RevAuto';
        $headline = $landingContent['headline'] ?? 'Servis Tepat, Performa Hebat';
        $subheadline = $landingContent['subheadline'] ?? 'Bengkel modern dengan layanan cepat dan transparan.';
        $aboutTitle = $landingContent['about_title'] ?? 'Bengkel Modern dengan Sistem Terintegrasi';
        $aboutBody = $landingContent['about_body'] ?? 'Semua proses servis kendaraan dikelola lebih efisien dalam satu platform.';
        $contactEmail = $landingContent['contact_email'] ?? 'hello@revauto.id';
        $contactPhone = $landingContent['contact_phone'] ?? '-';
        $contactAddress = $landingContent['contact_address'] ?? '-';

        $globalFallbackImage = 'data:image/svg+xml;utf8,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="1600" height="900"><rect width="100%" height="100%" fill="#0f172a"/><rect x="40" y="40" width="1520" height="820" rx="24" fill="#1e293b" stroke="#334155" stroke-width="4"/><text x="50%" y="47%" fill="#93c5fd" font-family="Arial, sans-serif" font-size="72" text-anchor="middle">RevAuto</text><text x="50%" y="58%" fill="#e2e8f0" font-family="Arial, sans-serif" font-size="38" text-anchor="middle">Bengkel Modern</text></svg>');
    @endphp

    <!-- Navbar -->
    <nav class="navbar-custom d-flex justify-content-between align-items-center" id="mainNav">
        <div class="d-flex align-items-center">
            <h2 class="m-0 fw-bold fs-3 text-white" style="letter-spacing: 2px;">
                <span class="text-blue-500">REV</span>AUTO
            </h2>
        </div>

        <div class="d-none d-lg-flex align-items-center">
            <a href="#" class="nav-link-custom">Home</a>
            <a href="#services" class="nav-link-custom">Layanan</a>
            <a href="#about" class="nav-link-custom">Tentang</a>
            <a href="#contact" class="nav-link-custom">Kontak</a>
        </div>

        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-glow text-decoration-none">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-glow text-decoration-none">Masuk</a>
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <!-- Fullscreen Background Image -->
<<<<<<< Updated upstream
        <img src="https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Sports Car" class="car-bg">

=======
        <img src="https://images.unsplash.com/photo-1514316454349-750a7fd3da3a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Bengkel RevAuto" class="car-bg" onerror="this.onerror=null;this.src='{{ $globalFallbackImage }}';">
        
>>>>>>> Stashed changes
        <!-- Dark Overlay -->
        <div class="dark-overlay"></div>

        <div class="container hero-content">
<<<<<<< Updated upstream
            <h1 class="hero-title">EXPLORE THE NEXT <br>GENERATION OF CARS</h1>
            <p class="hero-subtitle">Discover unparalleled performance, sleek design, and cutting-edge technology. Your dream ride awaits in our premium showroom.</p>

=======
            <h1 class="hero-title">{{ strtoupper($headline) }}</h1>
            <p class="hero-subtitle">{{ $subheadline }}</p>
            
>>>>>>> Stashed changes
            <div class="hero-buttons d-flex justify-content-center gap-4">
                <a href="{{ Route::has('login') ? route('login') : '#' }}" class="btn btn-glow">
                    Booking Servis
                </a>
            </div>

        </div>
    </section>

    <!-- Stats Bar (Bulma + Bootstrap structure) -->
    <div class="stats-container">
        <div class="container">
            <div class="row">
                @foreach ($stats ?? [] as $index => $stat)
                    <div class="col-md-3 col-6 stat-item {{ $index >= 2 ? 'mt-4 mt-md-0' : '' }}">
                        <div class="stat-value">{{ $stat['value'] }}</div>
                        <div class="stat-label">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- About Us Section -->
    <section class="py-20 relative overflow-hidden" id="about" style="background-color: #0f172a;">
        <div class="container">
            <div class="row align-items-center">
                <!-- Images Left -->
                <div class="col-lg-6 mb-5 mb-lg-0 relative">
                    <img src="https://images.unsplash.com/photo-1613214150148-52ba71ab523b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Area kerja bengkel" class="about-image-main" onerror="this.onerror=null;this.src='{{ $globalFallbackImage }}';">
                    <img src="https://images.unsplash.com/photo-1486006920555-c77dcf18193c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Peralatan servis kendaraan" class="about-image-secondary" onerror="this.onerror=null;this.src='{{ $globalFallbackImage }}';">
                </div>
                <!-- Text Right -->
                <div class="col-lg-6 lg:pl-16">
<<<<<<< Updated upstream
                    <p class="text-blue-500 font-bold tracking-widest uppercase mb-2 text-sm">About Us</p>
                    <h2 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight text-white">Redefining The Workshop & <br>Showroom Experience</h2>
                    <p class="text-slate-400 mb-8 leading-relaxed">
                        At our facility, we redefine the car ownership and maintenance experience with exceptional service, cutting-edge diagnostic tools, and customer-focused solutions tailored to your vehicle's needs.
                    </p>

=======
                    <p class="text-blue-500 font-bold tracking-widest uppercase mb-2 text-sm">Tentang {{ $brand }}</p>
                    <h2 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight text-white">{{ $aboutTitle }}</h2>
                    <p class="text-slate-400 mb-8 leading-relaxed">{{ $aboutBody }}</p>
                    
>>>>>>> Stashed changes
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                        <div class="flex items-center text-sm text-slate-300 font-medium">
                            <div class="w-6 h-6 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center mr-3 shrink-0">✓</div>
                            Pengerjaan Transparan
                        </div>
                        <div class="flex items-center text-sm text-slate-300 font-medium">
                            <div class="w-6 h-6 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center mr-3 shrink-0">✓</div>
                            Mekanik Berpengalaman
                        </div>
                        <div class="flex items-center text-sm text-slate-300 font-medium">
                            <div class="w-6 h-6 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center mr-3 shrink-0">✓</div>
                            Layanan Servis Lengkap
                        </div>
                        <div class="flex items-center text-sm text-slate-300 font-medium">
                            <div class="w-6 h-6 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center mr-3 shrink-0">✓</div>
                            Sparepart Original
                        </div>
                    </div>

                    <div class="flex items-center border-l border-slate-700 pl-6">
                        <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-600 flex items-center justify-center mr-3">
                            TEL
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 m-0">Hubungi Kami</p>
                            <p class="text-white font-bold m-0 tracking-wider">{{ $contactPhone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- New Arrival / Featured Section -->
    <section class="py-20 relative bg-[#0b1121]" id="services">
        <div class="container">
<<<<<<< Updated upstream
            <h2 class="text-3xl md:text-4xl font-extrabold mb-8 text-white">Featured Vehicle & Services</h2>

            <!-- Filters -->
            <div class="flex flex-wrap justify-between items-end mb-10 border-b border-slate-800 pb-4">
                <div class="flex gap-6 text-sm font-semibold text-slate-400 mb-4 md:mb-0">
                    <button class="text-blue-500 border-b-2 border-blue-500 pb-4 -mb-[17px]">All</button>
                    <button class="hover:text-blue-400 pb-4">Tuning</button>
                    <button class="hover:text-blue-400 pb-4">Maintenance</button>
                    <button class="hover:text-blue-400 pb-4">Showroom</button>
                    <button class="hover:text-blue-400 pb-4">Spare Parts</button>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-1.5 rounded-full border border-blue-500 text-blue-400 text-xs font-semibold">Latest</button>
                    <button class="px-4 py-1.5 rounded-full border border-slate-700 text-slate-400 hover:text-white text-xs font-semibold">Popular</button>
                </div>
=======
            <h2 class="text-3xl md:text-4xl font-extrabold mb-8 text-white">Layanan Unggulan {{ $brand }}</h2>
            
            <div class="mb-10 border-b border-slate-800 pb-4">
                <p class="text-slate-400 m-0">Daftar layanan aktif yang tersedia di bengkel {{ $brand }}.</p>
>>>>>>> Stashed changes
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Cards Dynamic -->
                @forelse ($services as $service)
                @php
                    $serviceQuery = trim(($service->nama_servis ?? 'servis mobil') . ' ' . ($service->kategori ?? '') . ' car mechanic workshop');
                    $serviceImage = 'https://loremflickr.com/900/600/' . rawurlencode($serviceQuery) . '?lock=' . ($service->id_jenis ?? crc32($serviceQuery));
                    $serviceTitle = htmlspecialchars(trim($service->nama_servis ?? 'Layanan Servis'), ENT_QUOTES, 'UTF-8');
                    $serviceFallback = 'data:image/svg+xml;utf8,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="900" height="600"><rect width="100%" height="100%" fill="#0f172a"/><rect x="28" y="28" width="844" height="544" rx="22" fill="#1e293b" stroke="#334155" stroke-width="4"/><text x="50%" y="46%" fill="#93c5fd" font-family="Arial, sans-serif" font-size="46" text-anchor="middle">RevAuto</text><text x="50%" y="58%" fill="#e2e8f0" font-family="Arial, sans-serif" font-size="30" text-anchor="middle">' . $serviceTitle . '</text></svg>');
                @endphp
                <div class="bg-slate-800 rounded-2xl p-5 border border-slate-700 hover:border-blue-500 transition-all duration-300 group">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-bold text-white text-lg">{{ $service->nama_servis }}</h3>
                            <p class="text-xs text-slate-400">{{ \Illuminate\Support\Str::limit($service->deskripsi, 60) }}</p>
                        </div>
                        <span class="text-slate-500 text-xs">Layanan</span>
                    </div>
                    <div class="h-32 flex items-center justify-center my-4 overflow-hidden relative">
                        <div class="absolute w-20 h-20 bg-blue-500/30 rounded-full blur-xl group-hover:bg-blue-400/40 transition-all"></div>
                        <img src="{{ $serviceImage }}" alt="{{ $service->nama_servis }}" class="service-thumb transform group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null;this.src='{{ $serviceFallback }}';">
                    </div>
                    <div class="flex justify-between text-[11px] text-slate-400 mb-4 border-b border-slate-700 pb-4">
                        <span class="flex items-center gap-1">Estimasi: {{ $service->estimasi_waktu }} jam</span>
                        <span class="flex items-center gap-1">{{ $service->kategori ?? 'Servis Umum' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="font-bold text-xl text-white">Rp {{ number_format($service->harga_jasa, 0, ',', '.') }}</p>
                        <a href="{{ Auth::check() ? route('customer.orders.create') : route('login') }}" class="text-xs bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white px-3 py-1.5 rounded-full transition-colors flex items-center gap-2 no-underline">
                            Booking
                        </a>
                    </div>
                </div>
                @empty
                    <p class="text-slate-400">Belum ada layanan tersedia saat ini.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Middle Banner Overlay -->
    <section class="relative h-[400px] flex items-center overflow-hidden bg-black">
        <!-- Abstract Circles -->
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute -top-[50%] -left-[10%] w-[500px] h-[500px] rounded-full border border-slate-800/50 bg-slate-900/20"></div>
            <div class="absolute -bottom-[50%] right-[10%] w-[600px] h-[600px] rounded-full border border-slate-800/50 bg-slate-900/30"></div>
        </div>
<<<<<<< Updated upstream
        <img src="https://images.unsplash.com/photo-1549490349-8643362247b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="White Car Dark" class="absolute bottom-0 right-0 h-[80%] object-contain transform scale-110 drop-shadow-[0_0_50px_rgba(255,255,255,0.1)]">

=======
        <img src="https://images.unsplash.com/photo-1549490349-8643362247b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="White Car Dark" class="absolute bottom-0 right-0 h-[80%] object-contain transform scale-110 drop-shadow-[0_0_50px_rgba(255,255,255,0.1)]" onerror="this.onerror=null;this.src='{{ $globalFallbackImage }}';">
        
>>>>>>> Stashed changes
        <div class="container relative z-10">
            <div class="max-w-xl">
                <h2 class="text-4xl font-extrabold text-white mb-4">Servis Presisi untuk Kendaraan Anda</h2>
                <p class="text-slate-400 mb-8">Mulai dari diagnosa cepat hingga pengerjaan detail, semua layanan RevAuto dirancang untuk menjaga performa kendaraan tetap optimal.</p>
                <a href="#contact" class="btn-glow border-white hover:bg-white hover:text-black hover:shadow-[0_0_20px_rgba(255,255,255,0.5)]">Hubungi Tim Kami</a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-20 bg-[#0f172a]">
        <div class="container">
            <div class="text-center mb-12">
                <p class="text-blue-500 font-bold text-sm tracking-widest uppercase">Testimonials</p>
                <h2 class="text-3xl font-extrabold text-white">Apa Kata Pelanggan</h2>
            </div>

            <div class="row justify-content-center">
                @foreach ($testimonials ?? [] as $testimonial)
                    <div class="col-md-5 mb-4">
                        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 h-full">
                            <div class="text-yellow-400 text-sm mb-2">★★★★★</div>
                            <p class="text-slate-300 text-sm leading-relaxed mb-4">"{{ $testimonial['quote'] }}"</p>
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-slate-600 mr-3 flex items-center justify-center text-xs text-white">
                                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($testimonial['name'], 0, 2)) }}
                                </div>
                                <div>
                                    <h4 class="text-white text-sm font-bold m-0">{{ $testimonial['name'] }}</h4>
                                    <p class="text-slate-500 text-xs m-0">{{ $testimonial['role'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-center gap-2 mt-6">
                <div class="w-6 h-1.5 bg-blue-500 rounded-full"></div>
                <div class="w-6 h-1.5 bg-slate-700 rounded-full"></div>
                <div class="w-6 h-1.5 bg-slate-700 rounded-full"></div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#0b1121] border-t border-slate-800 pt-16 pb-8" id="contact">
        <div class="container">
            <div class="row text-slate-400 mb-12">
                <!-- Col 1 -->
                <div class="col-lg-3 col-md-6 mb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 border border-slate-700 rounded-lg flex items-center justify-center shrink-0 text-white">
                            @
                        </div>
                        <div>
                            <h4 class="text-white text-sm font-bold mb-1">Contact Us</h4>
                            <p class="text-sm m-0">{{ $contactEmail }}</p>
                        </div>
                    </div>
                </div>
                <!-- Col 2 -->
                <div class="col-lg-3 col-md-6 mb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 border border-slate-700 rounded-lg flex items-center justify-center shrink-0 text-white">
                            TEL
                        </div>
                        <div>
                            <h4 class="text-white text-sm font-bold mb-1">Call Us</h4>
                            <p class="text-sm m-0">{{ $contactPhone }}</p>
                        </div>
                    </div>
                </div>
                <!-- Col 3 -->
                <div class="col-lg-3 col-md-6 mb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 border border-slate-700 rounded-lg flex items-center justify-center shrink-0 text-white">
                            CS
                        </div>
                        <div>
                            <h4 class="text-white text-sm font-bold mb-1">Live Chat</h4>
                            <p class="text-sm m-0">Mon - Sat | 08:00 - 17:00</p>
                        </div>
                    </div>
                </div>
                <!-- Col 4 -->
                <div class="col-lg-3 col-md-6 mb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 border border-slate-700 rounded-lg flex items-center justify-center shrink-0 text-white">
                            LOC
                        </div>
                        <div>
                            <h4 class="text-white text-sm font-bold mb-1">Location</h4>
                            <p class="text-sm m-0">{{ $contactAddress }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center border-t border-slate-800 pt-8">
                <p class="text-xs text-slate-500 mb-4 md:mb-0">&copy; {{ now()->year }} {{ $brand }}. All rights reserved.</p>
                <div class="flex gap-2">
                    <div class="px-3 py-1 bg-slate-800 text-xs text-slate-300 font-bold rounded">VISA</div>
                    <div class="px-3 py-1 bg-slate-800 text-xs text-slate-300 font-bold rounded">MC</div>
                    <div class="px-3 py-1 bg-slate-800 text-xs text-slate-300 font-bold rounded">QS</div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar Scrolled Effect
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNav');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>

