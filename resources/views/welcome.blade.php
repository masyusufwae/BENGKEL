<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RevAuto - Bengkel & Showroom</title>

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

    <!-- Navbar -->
    <nav class="navbar-custom d-flex justify-content-between align-items-center" id="mainNav">
        <div class="d-flex align-items-center">
            <h2 class="m-0 fw-bold fs-3 text-white" style="letter-spacing: 2px;">
                <span class="text-blue-500">REV</span>AUTO
            </h2>
        </div>

        <div class="d-none d-lg-flex align-items-center">
            <a href="#" class="nav-link-custom">Home</a>
            <a href="#" class="nav-link-custom">Inventory</a>
            <a href="#" class="nav-link-custom">Services</a>
            <a href="#" class="nav-link-custom">About</a>
            <a href="#" class="nav-link-custom">Contact</a>
        </div>

        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-glow text-decoration-none">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-white text-decoration-none me-4 font-semibold hover:text-blue-400 transition" style="font-size:0.9rem; text-transform:uppercase;">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-glow text-decoration-none">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <!-- Fullscreen Background Image -->
        <img src="https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Sports Car" class="car-bg">

        <!-- Dark Overlay -->
        <div class="dark-overlay"></div>

        <div class="container hero-content">
            <h1 class="hero-title">EXPLORE THE NEXT <br>GENERATION OF CARS</h1>
            <p class="hero-subtitle">Discover unparalleled performance, sleek design, and cutting-edge technology. Your dream ride awaits in our premium showroom.</p>

            <div class="hero-buttons d-flex justify-content-center gap-4">
                <a href="#inventory" class="btn btn-glow" style="background:#3b82f6; box-shadow: 0 0 15px rgba(59, 130, 246, 0.4);">
                    Explore Inventory
                </a>
                <a href="#services" class="btn btn-glow">
                    Book Service
                </a>
            </div>

        </div>
    </section>

    <!-- Stats Bar (Bulma + Bootstrap structure) -->
    <div class="stats-container">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6 stat-item">
                    <div class="stat-value">500+</div>
                    <div class="stat-label">Vehicles Sold</div>
                </div>
                <div class="col-md-3 col-6 stat-item">
                    <div class="stat-value">12k</div>
                    <div class="stat-label">Happy Clients</div>
                </div>
                <div class="col-md-3 col-6 stat-item">
                    <div class="stat-value">15</div>
                    <div class="stat-label">Years Exp</div>
                </div>
                <div class="col-md-3 col-6 stat-item">
                    <div class="stat-value">24/7</div>
                    <div class="stat-label">Support</div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Us Section -->
    <section class="py-20 relative overflow-hidden" id="about" style="background-color: #0f172a;">
        <div class="container">
            <div class="row align-items-center">
                <!-- Images Left -->
                <div class="col-lg-6 mb-5 mb-lg-0 relative">
                    <div class="relative w-full" style="padding-bottom: 75%; max-width: 90%;">
                        <img src="https://images.unsplash.com/photo-1613214150148-52ba71ab523b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Workshop Bay" class="absolute top-0 left-0 w-10/12 h-5/6 object-cover rounded-2xl shadow-[0_20px_40px_rgba(0,0,0,0.5)] z-10 border border-slate-700">
                        <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Red Sports Car" class="absolute bottom-0 right-0 w-8/12 h-3/4 object-cover rounded-2xl shadow-[0_25px_50px_rgba(0,0,0,0.8)] z-20 border-2 border-slate-800">
                    </div>
                </div>
                <!-- Text Right -->
                <div class="col-lg-6 lg:pl-16">
                    <p class="text-blue-500 font-bold tracking-widest uppercase mb-2 text-sm">About Us</p>
                    <h2 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight text-white">Redefining The Workshop & <br>Showroom Experience</h2>
                    <p class="text-slate-400 mb-8 leading-relaxed">
                        At our facility, we redefine the car ownership and maintenance experience with exceptional service, cutting-edge diagnostic tools, and customer-focused solutions tailored to your vehicle's needs.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                        <div class="flex items-center text-sm text-slate-300 font-medium">
                            <div class="w-6 h-6 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center mr-3 shrink-0">✓</div>
                            Customer-Centric Approach
                        </div>
                        <div class="flex items-center text-sm text-slate-300 font-medium">
                            <div class="w-6 h-6 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center mr-3 shrink-0">✓</div>
                            Expert Certified Mechanics
                        </div>
                        <div class="flex items-center text-sm text-slate-300 font-medium">
                            <div class="w-6 h-6 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center mr-3 shrink-0">✓</div>
                            Comprehensive Services
                        </div>
                        <div class="flex items-center text-sm text-slate-300 font-medium">
                            <div class="w-6 h-6 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center mr-3 shrink-0">✓</div>
                            Premium Original Parts
                        </div>
                    </div>

                    <div class="flex items-center gap-6">
                        <a href="#services" class="btn-glow inline-flex items-center bg-blue-500 text-white" style="border-color: #3b82f6;">
                            ABOUT REVAUTO
                        </a>
                        <div class="flex items-center border-l border-slate-700 pl-6">
                            <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-600 flex items-center justify-center mr-3">
                                📞
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 m-0">Call For Help</p>
                                <p class="text-white font-bold m-0 tracking-wider">+(704) 555-0127</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- New Arrival / Featured Section -->
    <section class="py-20 relative bg-[#0b1121]" id="inventory">
        <div class="container">
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
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="bg-slate-800 rounded-2xl p-5 border border-slate-700 hover:border-blue-500 transition-all duration-300 group">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-bold text-white text-lg">Engine Tuning</h3>
                            <p class="text-xs text-slate-400">Performance</p>
                        </div>
                        <button class="text-slate-500 hover:text-red-500">♡</button>
                    </div>
                    <div class="h-32 flex items-center justify-center my-4 overflow-hidden relative">
                        <!-- Glow behind image -->
                        <div class="absolute w-20 h-20 bg-blue-500/30 rounded-full blur-xl group-hover:bg-blue-400/40 transition-all"></div>
                        <img src="https://images.unsplash.com/photo-1625047509248-ec889cbff17f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Engine" class="max-h-full object-contain relative z-10 transform group-hover:scale-110 transition-transform duration-500 rounded-lg">
                    </div>
                    <div class="flex justify-between text-[11px] text-slate-400 mb-4 border-b border-slate-700 pb-4">
                        <span class="flex items-center gap-1">⚙️ Remap</span>
                        <span class="flex items-center gap-1">⚡ Stage 2</span>
                        <span class="flex items-center gap-1">⏱️ 2 Days</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="font-bold text-xl text-white">Rp 2.5jt</p>
                        <a href="{{ route('service.details', 'engine-tuning') }}" class="text-xs bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white px-3 py-1.5 rounded-full transition-colors flex items-center gap-2 no-underline">
                            View More <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-slate-800 rounded-2xl p-5 border border-slate-700 hover:border-blue-500 transition-all duration-300 group">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-bold text-white text-lg">Periodic Maintenance</h3>
                            <p class="text-xs text-slate-400">General Run</p>
                        </div>
                        <button class="text-slate-500 hover:text-red-500">♡</button>
                    </div>
                    <div class="h-32 flex items-center justify-center my-4 overflow-hidden relative">
                        <div class="absolute w-20 h-20 bg-yellow-500/20 rounded-full blur-xl group-hover:bg-yellow-400/30 transition-all"></div>
                        <img src="https://images.unsplash.com/photo-1493139369975-47eb021e5485?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Maintenance" class="max-h-full object-contain relative z-10 transform group-hover:scale-110 transition-transform duration-500 drop-shadow-2xl rounded-lg">
                    </div>
                    <div class="flex justify-between text-[11px] text-slate-400 mb-4 border-b border-slate-700 pb-4">
                        <span class="flex items-center gap-1">🛢️ Oil</span>
                        <span class="flex items-center gap-1">🧹 Filter</span>
                        <span class="flex items-center gap-1">⏱️ 2 Hours</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="font-bold text-xl text-white">Rp 850k</p>
                        <a href="{{ route('service.details', 'general-maintenance') }}" class="text-xs bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white px-3 py-1.5 rounded-full transition-colors flex items-center gap-2 no-underline">
                            View More <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-slate-800 rounded-2xl p-5 border border-slate-700 hover:border-blue-500 transition-all duration-300 group">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-bold text-white text-lg">Performance Parts</h3>
                            <p class="text-xs text-slate-400">Inventory & Install</p>
                        </div>
                        <button class="text-slate-500 hover:text-red-500">♡</button>
                    </div>
                    <div class="h-32 flex items-center justify-center my-4 overflow-hidden relative">
                        <div class="absolute w-20 h-20 bg-cyan-500/20 rounded-full blur-xl group-hover:bg-cyan-400/30 transition-all"></div>
                        <img src="https://images.unsplash.com/photo-1594966601815-5e60a3c20042?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Parts" class="max-h-full object-contain relative z-10 transform group-hover:scale-110 transition-transform duration-500 drop-shadow-2xl rounded-lg">
                    </div>
                    <div class="flex justify-between text-[11px] text-slate-400 mb-4 border-b border-slate-700 pb-4">
                        <span class="flex items-center gap-1">⚙️ OEM</span>
                        <span class="flex items-center gap-1">🔩 Forged</span>
                        <span class="flex items-center gap-1">✨ Install</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="font-bold text-xl text-white">Varies</p>
                        <a href="{{ route('service.details', 'custom-parts') }}" class="text-xs bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white px-3 py-1.5 rounded-full transition-colors flex items-center gap-2 no-underline">
                            View More <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-slate-800 rounded-2xl p-5 border border-slate-700 hover:border-blue-500 transition-all duration-300 group">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-bold text-white text-lg">Heavy Service</h3>
                            <p class="text-xs text-slate-400">Overhaul</p>
                        </div>
                        <button class="text-slate-500 hover:text-red-500">♡</button>
                    </div>
                    <div class="h-32 flex items-center justify-center my-4 overflow-hidden relative">
                        <div class="absolute w-20 h-20 bg-red-500/20 rounded-full blur-xl group-hover:bg-red-400/30 transition-all"></div>
                        <img src="https://images.unsplash.com/photo-1635784964531-90a6e3505877?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Service" class="max-h-full object-contain relative z-10 transform group-hover:scale-110 transition-transform duration-500 rounded-lg">
                    </div>
                    <div class="flex justify-between text-[11px] text-slate-400 mb-4 border-b border-slate-700 pb-4">
                        <span class="flex items-center gap-1">🔧 Rebuild</span>
                        <span class="flex items-center gap-1">🚿 Flush</span>
                        <span class="flex items-center gap-1">⏱️ 3 Days</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="font-bold text-xl text-white">Rp 5.5jt</p>
                        <a href="{{ route('service.details', 'heavy-service') }}" class="text-xs bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white px-3 py-1.5 rounded-full transition-colors flex items-center gap-2 no-underline">
                            View More <span>→</span>
                        </a>
                    </div>
                </div>
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
        <img src="https://images.unsplash.com/photo-1549490349-8643362247b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="White Car Dark" class="absolute bottom-0 right-0 h-[80%] object-contain transform scale-110 drop-shadow-[0_0_50px_rgba(255,255,255,0.1)]">

        <div class="container relative z-10">
            <div class="max-w-xl">
                <h2 class="text-4xl font-extrabold text-white mb-4">Precision Engineering at Your Fingertips</h2>
                <p class="text-slate-400 mb-8">Access our premium workshop facilities and high-end vehicle inventory curated just for automotive enthusiasts.</p>
                <a href="#contact" class="btn-glow border-white hover:bg-white hover:text-black hover:shadow-[0_0_20px_rgba(255,255,255,0.5)]">Contact Us Today</a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-20 bg-[#0f172a]">
        <div class="container">
            <div class="text-center mb-12">
                <p class="text-blue-500 font-bold text-sm tracking-widest uppercase">Testimonials</p>
                <h2 class="text-3xl font-extrabold text-white">What Our Clients Say</h2>
            </div>

            <div class="row justify-content-center">
                <!-- Review 1 -->
                <div class="col-md-5 mb-4">
                    <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 flex gap-4 h-full">
                        <img src="https://images.unsplash.com/photo-1627448378616-2a781ce72c83?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" class="w-32 h-32 object-cover rounded-xl shrink-0" alt="Workshop">
                        <div>
                            <div class="text-yellow-400 text-sm mb-2">★★★★★</div>
                            <p class="text-slate-300 text-sm leading-relaxed mb-4">"From start to finish, the mechanics at RevAuto answered all my questions, perfectly tuned my engine, and delivered top-notch service!"</p>
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-slate-600 mr-3 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Avatar">
                                </div>
                                <div>
                                    <h4 class="text-white text-sm font-bold m-0">Floyd Miles</h4>
                                    <p class="text-slate-500 text-xs m-0">Car Enthusiast</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Review 2 -->
                <div class="col-md-5 mb-4">
                    <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 flex gap-4 h-full">
                        <img src="https://images.unsplash.com/photo-1542282088-fe8426682b8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" class="w-32 h-32 object-cover rounded-xl shrink-0" alt="Car Fix">
                        <div>
                            <div class="text-yellow-400 text-sm mb-2">★★★★★</div>
                            <p class="text-slate-300 text-sm leading-relaxed mb-4">"Their showroom inventory is amazing, but their maintenance bay is what keeps me coming back. Highly recommend!"</p>
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-slate-600 mr-3 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Avatar">
                                </div>
                                <div>
                                    <h4 class="text-white text-sm font-bold m-0">Darlene Robertson</h4>
                                    <p class="text-slate-500 text-xs m-0">Business Owner</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                            ✉️
                        </div>
                        <div>
                            <h4 class="text-white text-sm font-bold mb-1">Contact Us</h4>
                            <p class="text-sm m-0">contact@revauto.com</p>
                        </div>
                    </div>
                </div>
                <!-- Col 2 -->
                <div class="col-lg-3 col-md-6 mb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 border border-slate-700 rounded-lg flex items-center justify-center shrink-0 text-white">
                            📞
                        </div>
                        <div>
                            <h4 class="text-white text-sm font-bold mb-1">Call Us</h4>
                            <p class="text-sm m-0">+62 812 3456 7890</p>
                        </div>
                    </div>
                </div>
                <!-- Col 3 -->
                <div class="col-lg-3 col-md-6 mb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 border border-slate-700 rounded-lg flex items-center justify-center shrink-0 text-white">
                            💬
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
                            📍
                        </div>
                        <div>
                            <h4 class="text-white text-sm font-bold mb-1">Location</h4>
                            <p class="text-sm m-0">Jl. Teknologi No.12, Jakarta</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center border-t border-slate-800 pt-8">
                <p class="text-xs text-slate-500 mb-4 md:mb-0">&copy; 2026 BENGKEL RevAuto. All rights reserved.</p>
                <div class="flex gap-2">
                    <div class="px-3 py-1 bg-slate-800 text-xs text-slate-300 font-bold rounded">VISA</div>
                    <div class="px-3 py-1 bg-slate-800 text-xs text-slate-300 font-bold rounded">MC</div>
                    <div class="px-3 py-1 bg-slate-800 text-xs text-slate-300 font-bold rounded">QS</div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.css"></script>
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
