<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Dashboard - Bengkel</title>

    <!-- CSS Frameworks Mix (Bootstrap, Bulma, Tailwind) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Blue/White Theme Config for Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0d6efd',
                        primaryHover: '#0b5ed7',
                    },
                    animation: {
                        'gradient-x': 'gradient-x 4s ease infinite',
                    },
                    keyframes: {
                        'gradient-x': {
                            '0%, 100%': {
                                'background-size': '200% 200%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            },
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Resolving Framework Conflicts & Custom Styling */
        body, html { height: 100vh; overflow-x: hidden; margin: 0; padding: 0; background-color: #f8fafc; }
        body.modal-open { overflow-y: hidden !important; padding-right: var(--scrollbar-width, 0px); }
        a { text-decoration: none !important; }

        /* Isometric Cube Navy Motif */
        .bg-navy-motif {
            background-color: #0f172a; /* Tailwind slate-900 */
            background-image:
                linear-gradient(30deg, rgba(255,255,255,0.02) 12%, transparent 12.5%, transparent 87%, rgba(255,255,255,0.02) 87.5%, rgba(255,255,255,0.02)),
                linear-gradient(150deg, rgba(255,255,255,0.02) 12%, transparent 12.5%, transparent 87%, rgba(255,255,255,0.02) 87.5%, rgba(255,255,255,0.02)),
                linear-gradient(30deg, rgba(255,255,255,0.02) 12%, transparent 12.5%, transparent 87%, rgba(255,255,255,0.02) 87.5%, rgba(255,255,255,0.02)),
                linear-gradient(150deg, rgba(255,255,255,0.02) 12%, transparent 12.5%, transparent 87%, rgba(255,255,255,0.02) 87.5%, rgba(255,255,255,0.02)),
                linear-gradient(60deg, rgba(255,255,255,0.02) 25%, transparent 25.5%, transparent 75%, rgba(255,255,255,0.02) 75%, rgba(255,255,255,0.02)),
                linear-gradient(60deg, rgba(255,255,255,0.02) 25%, transparent 25.5%, transparent 75%, rgba(255,255,255,0.02) 75%, rgba(255,255,255,0.02));
            background-size: 40px 70px; /* Made larger */
            background-position: 0 0, 0 0, 20px 35px, 20px 35px, 0 0, 20px 35px;
        }

        /* Custom Scrollbar for sleek UI */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #3b82f6; }

        /* Custom Animations */
        @keyframes slideDown {
            0% { transform: translateY(-100%); }
            50% { transform: translateY(300%); }
            100% { transform: translateY(-100%); }
        }
        @keyframes shimmer {
            100% { transform: translateX(100%); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .page-transition {
            opacity: 0;
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            animation-delay: 0.8s; /* Wait for wipe effect to finish */
        }

        /* Cyber Wipe Effect */
        .wipe-out-active {
            animation: wipe-up 0.8s cubic-bezier(0.86, 0, 0.07, 1) forwards;
            border-bottom: 4px solid #06b6d4; /* cyan glow bottom edge */
            box-shadow: 0 15px 40px rgba(6, 182, 212, 0.5);
        }
        @keyframes wipe-up {
            0% { transform: translateY(0); }
            100% { transform: translateY(-100%); }
        }

        /* Glitch Animation */
        .glitch-hover { position: relative; }
        .glitch-hover:hover::before, .glitch-hover:hover::after {
            content: attr(data-text);
            position: absolute; top: 0; left: 0; opacity: 0.8;
        }
        .glitch-hover:hover::before {
            color: #0ff; z-index: -1; animation: glitch-anim 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) both infinite;
        }
        .glitch-hover:hover::after {
            color: #f0f; z-index: -2; animation: glitch-anim2 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) both infinite reverse;
        }
        @keyframes glitch-anim {
            0% { clip-path: inset(20% 0 80% 0); transform: translate(-2px, 1px); }
            20% { clip-path: inset(60% 0 10% 0); transform: translate(2px, -1px); }
            40% { clip-path: inset(40% 0 50% 0); transform: translate(-2px, 2px); }
            60% { clip-path: inset(80% 0 5% 0); transform: translate(2px, -2px); }
            80% { clip-path: inset(10% 0 70% 0); transform: translate(-1px, 1px); }
            100% { clip-path: inset(30% 0 50% 0); transform: translate(1px, -1px); }
        }
        @keyframes glitch-anim2 {
            0% { clip-path: inset(10% 0 60% 0); transform: translate(2px, -1px); }
            20% { clip-path: inset(30% 0 20% 0); transform: translate(-2px, 1px); }
            40% { clip-path: inset(70% 0 10% 0); transform: translate(2px, -2px); }
            60% { clip-path: inset(20% 0 50% 0); transform: translate(-2px, 2px); }
            80% { clip-path: inset(60% 0 30% 0); transform: translate(1px, -1px); }
            100% { clip-path: inset(5% 0 80% 0); transform: translate(-1px, 1px); }
        }

        /* 3D Hover & Glow */
        .hover-3d-glow { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); border: 1px solid transparent; }
        .hover-3d-glow:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 15px 30px -5px rgba(34, 211, 238, 0.3), 0 0 15px rgba(34, 211, 238, 0.2);
            border-color: rgba(34, 211, 238, 0.5);
            z-index: 10; relative;
        }

        /* Glassmorphism Classes */
        .glass-nav { background: rgba(15, 23, 42, 0.85) !important; backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.05); }
        .glass-header { background: rgba(255, 255, 255, 0.8) !important; backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
    </style>
</head>
<body class="flex flex-col h-screen w-screen antialiased bg-gray-50 text-gray-800">

@php
    $logged_in_user = Auth::user();
    $active_jobs_count = 0;
    $total_logs_count = 0;

    if ($logged_in_user) {
        $active_jobs_count = isset($wo_aktif) ? count($wo_aktif) : \App\Models\WorkOrder::whereHas('kendaraan', function($q) use ($logged_in_user) {
            $q->where('id_pelanggan', $logged_in_user->id);
        })->whereIn('status', ['antrian', 'dikerjakan', 'menunggu_part'])->count();

        $total_logs_count = isset($riwayat_servis) ? count($riwayat_servis) : \App\Models\WorkOrder::whereHas('kendaraan', function($q) use ($logged_in_user) {
            $q->where('id_pelanggan', $logged_in_user->id);
        })->where('status', 'selesai')->count();
    }
@endphp

    <!-- Tech Preloader -->
    <div id="tech-preloader" class="fixed inset-0 z-[9999] bg-slate-900 flex flex-col items-center justify-center">
        <!-- Wraps the gear contents so we can fade them out before wiping -->
        <div id="preloader-content" class="relative flex flex-col items-center justify-center transition-opacity duration-500">
            <div class="relative flex items-center justify-center">
                <div class="absolute inset-0 bg-cyan-500 rounded-full blur-[60px] opacity-20 animate-pulse"></div>
                <i class="fas fa-cog text-6xl text-cyan-400 animate-[spin_3s_linear_infinite] drop-shadow-[0_0_15px_rgba(34,211,238,0.8)]"></i>
                <i class="fas fa-cog text-4xl text-blue-500 animate-[spin_2s_linear_infinite_reverse] drop-shadow-[0_0_10px_rgba(59,130,246,0.8)] absolute -bottom-3 -right-3"></i>
            </div>
            <div class="mt-8 text-cyan-400 text-xs font-bold tracking-[0.4em] uppercase animate-pulse">Inisialisasi Sistem...</div>
        </div>
    </div>

    <!-- Header / Navbar (Navy Template) -->
    <nav class="h-[64px] glass-nav flex-shrink-0 flex items-center justify-between px-6 z-50 shadow-md relative">
        <!-- Glowing Gradient Bottom Accent -->
        <div class="absolute bottom-0 left-0 w-full h-[3px] bg-gradient-to-r from-blue-700 via-cyan-400 to-indigo-700 shadow-[0_2px_12px_rgba(34,211,238,0.4)] z-50"></div>

        <div class="flex items-center">
            <a href="{{ route('dashboard') }}" aria-label="BENGKELPRO" class="glitch-hover text-white text-xl md:text-2xl font-extrabold tracking-wide flex items-center hover:text-blue-400 transition-colors duration-300 drop-shadow-md" data-text="BENGKEL">
                <i class="fas fa-tools text-blue-500 mr-3 text-2xl drop-shadow-[0_0_5px_rgba(59,130,246,0.6)]"></i>
                BENGKEL<span class="font-light ml-1 opacity-80 text-blue-300">PRO</span>
            </a>
        </div>

        <div class="flex items-center space-x-5">
            <!-- Glowing Notification Bell -->
            @php
                $unreadChats = Auth::check() ? \App\Models\Chat::where('receiver_id', Auth::id())->where('is_read', false)->count() : 0;
            @endphp
            <a href="{{ route('chat.index') }}" class="relative text-slate-300 hover:text-cyan-400 transition-colors group focus:outline-none hidden md:block">
                <i class="fas fa-bell text-xl group-hover:scale-110 transition-transform"></i>
                @if($unreadChats > 0)
                <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full border border-slate-900"></span>
                <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full animate-ping opacity-75"></span>
                <span class="absolute -top-1 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $unreadChats }}</span>
                @endif
            </a>

            @auth
            <div class="hidden md:flex items-center space-x-3 border-r border-slate-700 pr-5">
                <span class="text-slate-200 font-semibold tracking-wide shadow-sm">{{ auth()->user()->name }}</span>
                <!-- Bulma Tag customized for Dark Theme -->
                <span class="tag is-dark bg-slate-800 text-blue-400 border border-slate-700 font-bold is-rounded shadow-sm">{{ strtoupper(auth()->user()->role) }}</span>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <!-- Bootstrap Outline Button customized for Navy/Dark look -->
                <button type="submit" class="btn btn-sm fw-bold border border-slate-600 bg-slate-800 text-slate-300 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-300 rounded px-4 shadow-sm">
                    <i class="fas fa-sign-out-alt mr-1"></i> LOGOUT
                </button>
            </form>
            @endauth
        </div>
    </nav>

    <!-- Main Layout Area Container -->
    <div class="flex-1 flex overflow-hidden w-full bg-gray-100 relative" id="main-scroll-container">

        <!-- Sidebar Navigation (Navy Blue style with motif and Animated Line) -->
        <aside class="w-[280px] bg-navy-motif flex-shrink-0 flex flex-col border-r-0 shadow-[4px_0_15px_rgba(0,0,0,0.3)] z-40 relative">

            <!-- Sleek Animated Glowing Edge (Lebih Terlihat) -->
            <div class="absolute right-0 top-0 bottom-0 w-[4px] bg-slate-800/80 z-50 overflow-hidden">
                <div class="w-full h-1/2 bg-gradient-to-b from-transparent via-cyan-400 to-transparent opacity-100 animate-[slideDown_3s_linear_infinite] shadow-[0_0_15px_rgba(34,211,238,1)] blur-[1px]"></div>
            </div>

            <div class="flex-1 overflow-y-auto py-6 px-4">

                <h6 class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-4 pl-3">Portal Menu</h6>

                <!-- Mixed Bootstrap List Group with Tailwind utility logic -->
                <div class="list-group mb-5 rounded-0 border-0 bg-transparent gap-1">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action border-0 mb-1 rounded flex items-center px-4 py-3 bg-transparent text-slate-300 hover:bg-slate-800 hover:text-blue-400 transition-all border-l-[4px] @if(Route::currentRouteName() == 'dashboard') border-blue-500 bg-blue-900/50 text-blue-400 font-bold @else border-transparent @endif">
                        <i class="fas fa-border-all w-6 text-center @if(Route::currentRouteName() == 'dashboard') text-blue-400 @endif"></i>
                        <span class="ml-2 tracking-wide text-sm font-semibold">DASHBOARD</span>
                    </a>

                    <a href="{{ route('customer.vehicles.index') }}" class="list-group-item list-group-item-action border-0 mb-1 rounded flex items-center px-4 py-3 bg-transparent text-slate-300 hover:bg-slate-800 hover:text-blue-400 transition-all border-l-[4px] @if(Route::currentRouteName() == 'customer.vehicles.index') border-blue-500 bg-blue-900/50 text-blue-400 font-bold @else border-transparent @endif">
                        <i class="fas fa-car-side w-6 text-center @if(Route::currentRouteName() == 'customer.vehicles.index') text-blue-400 @endif"></i>
                        <span class="ml-2 tracking-wide text-sm font-semibold">KENDARAAN</span>
                    </a>

                    <a href="{{ route('customer.orders.index') }}" class="list-group-item list-group-item-action border-0 mb-1 rounded flex items-center px-4 py-3 bg-transparent text-slate-300 hover:bg-slate-800 hover:text-blue-400 transition-all border-l-[4px] @if(Route::currentRouteName() == 'customer.orders.index') border-blue-500 bg-blue-900/50 text-blue-400 font-bold @else border-transparent @endif">
                        <i class="fas fa-history w-6 text-center @if(Route::currentRouteName() == 'customer.orders.index') text-blue-400 @endif"></i>
                        <span class="ml-2 tracking-wide text-sm font-semibold">ORDER HISTORY</span>
                    </a>

                    <a href="{{ route('customer.invoices.index') }}" class="list-group-item list-group-item-action border-0 mb-1 rounded flex items-center px-4 py-3 bg-transparent text-slate-300 hover:bg-slate-800 hover:text-blue-400 transition-all border-l-[4px] @if(Route::currentRouteName() == 'customer.invoices.index') border-blue-500 bg-blue-900/50 text-blue-400 font-bold @else border-transparent @endif">
                        <i class="fas fa-file-invoice-dollar w-6 text-center @if(Route::currentRouteName() == 'customer.invoices.index') text-blue-400 @endif"></i>
                        <span class="ml-2 tracking-wide text-sm font-semibold">INVOICE</span>
                    </a>

                    <a href="{{ route('chat.index') }}" class="list-group-item list-group-item-action border-0 mb-1 rounded flex items-center px-4 py-3 bg-transparent text-slate-300 hover:bg-slate-800 hover:text-blue-400 transition-all border-l-[4px] @if(Route::currentRouteName() == 'chat.index') border-blue-500 bg-blue-900/50 text-blue-400 font-bold @else border-transparent @endif">
                        <i class="fas fa-comments w-6 text-center @if(Route::currentRouteName() == 'chat.index') text-blue-400 @endif"></i>
                        <span class="ml-2 tracking-wide text-sm font-semibold">LIVE CHAT</span>
                        @php
                            $unreadChats = \App\Models\Chat::where('receiver_id', Auth::id())->where('is_read', false)->count();
                        @endphp
                        @if($unreadChats > 0)
                            <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full animate-pulse">{{ $unreadChats }}</span>
                        @endif
                    </a>
                </div>

                <h6 class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-4 pl-3 mt-8">System Stats</h6>

                <!-- Bulma Box + Tailwind Light/Blue Theme (Adapted for Dark Sidebar) -->
                <div class="box bg-slate-800 border border-slate-700 p-4 mx-2 mb-3 rounded-lg shadow-sm">
                    <div class="flex justify-between items-end mb-2">
                        <h6 class="text-xs text-slate-300 font-bold mb-0 tracking-wider">ACTIVE JOBS</h6>
                        <h3 class="text-blue-400 fs-4 mb-0 font-black">{{ $active_jobs_count }}</h3>
                    </div>
                    <div class="w-full bg-slate-900 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-blue-500 h-full shadow-[0_0_8px_rgba(59,130,246,0.8)]" style="width: {{ $active_jobs_count > 0 ? '100%' : '15%' }};"></div>
                    </div>
                </div>

                <div class="box bg-slate-800 border border-slate-700 p-4 mx-2 border-l-[4px] border-l-blue-500 rounded-lg shadow-sm">
                    <div class="flex justify-between items-end mb-2">
                        <h6 class="text-xs text-slate-300 font-bold mb-0 tracking-wider">TOTAL LOGS</h6>
                        <h3 class="text-white fs-4 mb-0 font-black">{{ $total_logs_count }}</h3>
                    </div>
                </div>

                <!-- User Profile Widget -->
                <div class="mt-8 mx-2 mb-10 relative rounded-xl border border-slate-700 bg-gradient-to-br from-slate-800 to-slate-900 overflow-hidden group shadow-lg hover:border-cyan-500/50 transition-all duration-300">
                    <!-- Base animation overlay -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/5 to-transparent -translate-x-[100%] group-hover:animate-[shimmer_1.5s_infinite]"></div>

                    <div class="relative z-10 p-5 flex flex-col items-center text-center">
                        <div class="relative w-16 h-16 flex items-center justify-center mb-3">
                            <div class="absolute inset-0 bg-blue-500 rounded-full blur-md opacity-20 group-hover:opacity-40 transition-opacity"></div>
                            <div class="w-full h-full rounded-full border-2 border-cyan-400/50 overflow-hidden bg-slate-700 flex flex-col items-center justify-center shadow-[0_0_10px_rgba(34,211,238,0.3)] group-hover:border-cyan-400 group-hover:shadow-[0_0_15px_rgba(34,211,238,0.6)] transition-all">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Profile" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-user-astronaut text-2xl text-cyan-300"></i>
                                @endif
                            </div>
                        </div>

                        <h5 class="text-slate-100 font-extrabold text-sm mb-0 uppercase tracking-wide truncate w-full">{{ auth()->user()->name }}</h5>
                        <p class="text-[10px] text-slate-400 font-medium mb-4 truncate w-full">
                            {{ auth()->user()->email }}
                        </p>

                        <a href="{{ route('profile.edit') }}" class="w-full text-center bg-slate-700 border border-slate-600 hover:bg-cyan-600 hover:border-cyan-500 text-slate-300 hover:text-white font-bold text-xs py-2 px-4 rounded-md transition-all shadow-sm flex items-center justify-center group-hover:shadow-[0_0_8px_rgba(34,211,238,0.3)]">
                            <i class="fas fa-user-edit mr-2"></i> EDIT PROFILE
                        </a>
                    </div>
                </div>

            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto bg-gray-50 relative z-10 w-full flex flex-col page-transition" id="main-content-scroll">

            <!-- Page Banner/Header (Clean Blue/White Style) -->
            <div class="w-full glass-header border-b border-gray-200 px-8 py-6 shadow-sm sticky top-0 z-30">
                <h1 class="text-3xl font-black text-gray-800 uppercase tracking-tight m-0 leading-none">@yield('title', 'Control Center')</h1>
                <p class="text-sm font-semibold text-blue-600 mt-2 tracking-widest uppercase">Dashboard Pelanggan</p>
            </div>

            <!-- Dynamic Page Content -->
            <div class="p-6 lg:p-10 w-full max-w-[1600px] mx-auto flex-1">
                <!-- Wrapper Box inside main content -->
                <div class="box p-0 shadow border border-gray-100 rounded-xl overflow-hidden bg-white">
                    <div class="bg-gray-50 text-gray-700 px-5 py-3 border-b border-gray-200 flex items-center">
                        <h5 class="m-0 fs-6 font-bold tracking-wider text-blue-700"><i class="fas fa-list-alt text-blue-500 mr-2"></i> DATA PORTAL</h5>
                    </div>
                    <div class="p-5 bg-white text-gray-800">
                        <!-- Blade Yield Area -->
                        @yield('page-content')
                    </div>
                </div>
            </div>

            <!-- Tech Footer Area -->
            <footer class="bg-slate-900 border-t-[3px] border-cyan-500 py-4 px-8 flex justify-between items-center text-xs text-slate-400 font-bold tracking-widest relative overflow-hidden mt-auto">
                <div class="absolute inset-0 bg-navy-motif opacity-30"></div>
                <div class="relative z-10 flex items-center">
                    <i class="fas fa-shield-alt text-cyan-400 mr-2 text-lg drop-shadow-[0_0_5px_rgba(34,211,238,0.8)]"></i>
                    <span>BENGKEL PRO &copy; 2026 | <span class="text-slate-500">System Version 2.0</span></span>
                </div>
                <div class="relative z-10 flex items-center space-x-3 text-[10px]">
                    <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-green-500 animate-pulse mr-1"></span> Server Online</span>
                </div>
            </footer>
        </main>
    </div>

    <!-- Floating Action Button (FAB) -->
    <a href="{{ route('customer.orders.create') }}" class="fixed bottom-6 right-6 w-14 h-14 bg-cyan-600 rounded-full flex items-center justify-center text-slate-900 shadow-[0_0_20px_rgba(34,211,238,0.6)] hover:scale-110 hover:bg-cyan-400 hover:shadow-[0_0_30px_rgba(34,211,238,0.9)] transition-all duration-300 z-[100] group cursor-pointer border-2 border-cyan-300 hover-3d-glow">
        <i class="fas fa-tools text-2xl group-hover:rotate-12 transition-transform duration-300"></i>
        <div class="absolute -top-3 -right-3">
            <span class="relative flex h-4 w-4">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-4 w-4 bg-cyan-500 border border-white"></span>
            </span>
        </div>
    </a>

    <!-- Script for Tech Preloader -->
    <script>
        // Wipe Transition Preloader Logic
        window.addEventListener('load', function() {
            const preloader = document.getElementById('tech-preloader');
            const preloaderContent = document.getElementById('preloader-content');

            if (preloader && preloaderContent) {
                // Delay 3 detik agar animasi loading lebih lama terasa
                setTimeout(() => {
                    // 1. Meredupkan gear animasi dulu
                    preloaderContent.style.opacity = '0';

                    // 2. Tarik background gelap ke atas (Wipe Up transisi)
                    setTimeout(() => {
                        preloader.classList.add('wipe-out-active');

                        // 3. Hilangkan full preloader setelah Wipe selesai
                        setTimeout(() => {
                            preloader.style.display = 'none';
                        }, 800);
                    }, 350);
                }, 3000); // 3000 ms = 3 detik
            }
        });
    </script>
