<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Bengkel Management System')</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/logo/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="min-h-screen flex flex-col">

        {{-- Navbar Langsung di dalam App --}}
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition">
                            <img src="{{ asset('storage/logo/icon.png') }}" alt="Logo Bengkel" class="h-10 w-10 rounded-full object-cover shadow-md ring-2 ring-blue-100">
                            <span class="text-xl font-bold text-blue-600">Bengkel Mekanik</span>
                        </a>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="flex">
                            <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                                <a href="{{ route('mekanik.work-order.index') }}"
                                    class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('mekanik.work-order.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                    Work Order
                                </a>
                                <a href="{{ route('mekanik.sparepart.index') }}"
                                    class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('mekanik.sparepart.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                    Sparepart
                                </a>
                                <a href="{{ route('mekanik.riwayat') }}"
                                    class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('mekanik.riwayat') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                    Riwayat
                                </a>

                            </div>
                        </div>

                        <div class="flex items-center space-x-2">

                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Mekanik
                            </span>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Optional Header (Hanya tampil jika @section('header') ada di view) --}}
        @hasSection('header')
            <header class="bg-white shadow-sm">
                {{-- Header --}}
                <div class="bg-white border-b border-gray-200">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <h2 class="font-bold text-2xl text-gray-800">Detail Work Order</h2>

                            <form method="GET" action="" class="flex items-center gap-2">
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Cari Plat Nomor..."
                                        class="border border-gray-300 rounded-lg pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none w-full md:w-64 transition">
                                    <div class="absolute left-3 top-2.5 text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 shadow-sm transition font-medium text-sm">
                                    Cari
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
        @endif

        {{-- Main Content --}}
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                {{-- Slot untuk isi halaman --}}
                @yield('content')

                {{-- Area Pagination Otomatis --}}
                <div class="mt-4">
                    @yield('pagination')
                </div>
            </div>
        </main>

        {{-- Footer --}}
        <footer class="bg-white border-t mt-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Bengkel Management System
            </div>
        </footer>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Helper untuk Toast SweetAlert
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true
        });

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                background: '#10b981',
                color: 'white'
            });
        @endif

        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                background: '#ef4444',
                color: 'white'
            });
        @endif

        @if (session('warning'))
            Toast.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: '{{ session('warning') }}'
            });
        @endif
    </script>
</body>

</html>
