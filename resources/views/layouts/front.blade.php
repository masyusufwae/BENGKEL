<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RevAuto - @yield('title', 'Bengkel & Showroom')</title>
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
            background-color: rgba(11, 17, 33, 0.95) !important;
            padding: 1rem 5%;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            position: fixed;
            width: 100%;
            z-index: 50;
            top: 0;
        }

        .nav-link-custom {
            color: #fff !important;
            font-weight: 500;
            margin: 0 15px;
            letter-spacing: 0.5px;
            position: relative;
            text-transform: uppercase;
            font-size: 0.9rem;
            text-decoration: none;
        }
        .nav-link-custom::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: #3b82f6;
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
            text-decoration: none;
        }
        .btn-glow:hover {
            background: #3b82f6;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
            color: #fff;
        }
        @yield('styles')
    </style>
</head>
<body class="antialiased">

    <!-- Navbar -->
    <nav class="navbar-custom d-flex justify-content-between align-items-center" id="mainNav" style="background-color: rgba(11, 17, 33, 0.95) !important;">
        <div class="d-flex align-items-center">
            <h2 class="m-0 fw-bold fs-3 text-white" style="letter-spacing: 2px;">
                <a href="{{ url('/') }}" class="text-white text-decoration-none">
                    <span class="text-blue-500">REV</span>AUTO
                </a>
            </h2>
        </div>

        <div class="d-none d-lg-flex align-items-center">
            <a href="{{ url('/') }}" class="nav-link-custom">Home</a>
            <a href="{{ url('/#inventory') }}" class="nav-link-custom">Inventory</a>
            <a href="{{ url('/#services') }}" class="nav-link-custom">Services</a>
            <a href="{{ url('/#about') }}" class="nav-link-custom">About</a>
            <a href="{{ url('/#contact') }}" class="nav-link-custom">Contact</a>
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

    <!-- Main Content -->
    <main style="margin-top: 80px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#0f172a] border-t border-slate-800 pt-16 pb-8 mt-20" id="contact">
        <div class="container">
            <div class="row text-slate-400 mb-12">
                <!-- Col 1 -->
                <div class="col-lg-3 col-md-6 mb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 border border-slate-700 rounded-lg flex items-center justify-center shrink-0 text-white">✉️</div>
                        <div>
                            <h4 class="text-white text-sm font-bold mb-1">Contact Us</h4>
                            <p class="text-sm m-0">contact@revauto.com</p>
                        </div>
                    </div>
                </div>
                <!-- Col 2 -->
                <div class="col-lg-3 col-md-6 mb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 border border-slate-700 rounded-lg flex items-center justify-center shrink-0 text-white">📞</div>
                        <div>
                            <h4 class="text-white text-sm font-bold mb-1">Call Us</h4>
                            <p class="text-sm m-0">+62 812 3456 7890</p>
                        </div>
                    </div>
                </div>
                <!-- Col 3 -->
                <div class="col-lg-3 col-md-6 mb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 border border-slate-700 rounded-lg flex items-center justify-center shrink-0 text-white">💬</div>
                        <div>
                            <h4 class="text-white text-sm font-bold mb-1">Live Chat</h4>
                            <p class="text-sm m-0">Mon - Sat | 08:00 - 17:00</p>
                        </div>
                    </div>
                </div>
                <!-- Col 4 -->
                <div class="col-lg-3 col-md-6 mb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 border border-slate-700 rounded-lg flex items-center justify-center shrink-0 text-white">📍</div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
