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

        {{-- Navbar --}}
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    {{-- Logo & Brand --}}
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition">
                            <img src="{{ asset('storage/logo/icon.png') }}" alt="Logo Bengkel"
                                class="h-10 w-10 rounded-full object-cover shadow-md ring-2 ring-blue-100">
                            <span class="text-xl font-bold text-blue-600">Bengkel Mekanik</span>
                        </a>
                    </div>

                    {{-- Menu Kanan --}}
                    <div class="flex items-center space-x-4">
                        {{-- Menu Navigasi --}}
                        <div class="hidden sm:flex sm:space-x-8">
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

                        {{-- Ikon Notifikasi (Lonceng) dengan latar kuning --}}
                        <div class="relative">
                            <button id="notification-button"
                                class="relative p-2 rounded-full bg-yellow-100 hover:bg-yellow-200 text-gray-800 transition focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span id="notif-badge"
                                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold shadow-lg hidden">0</span>
                            </button>
                        </div>

                        {{-- Role Badge --}}
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Mekanik
                            </span>
                        </div>

                        {{-- Logout --}}
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

        {{-- Optional Header (jika view mendefinisikan @section('header')) --}}
        @hasSection('header')
            <header class="bg-white shadow-sm">
                <div class="bg-white border-b border-gray-200">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                        @yield('header')
                    </div>
                </div>
            </header>
        @endif

        {{-- Main Content --}}
        <main class="flex-1">
            {{-- Script polling notifikasi --}}
            <script>
                // Fungsi untuk mengecek apakah halaman saat ini adalah Work Order Index
                function isWorkOrderIndexPage() {
                    // Cek apakah route name mengandung 'mekanik.work-order.index'
                    // Alternatif: bandingkan URL dengan route('mekanik.work-order.index')
                    const currentUrl = window.location.pathname;
                    const woIndexUrl = '{{ route('mekanik.work-order.index') }}';
                    // Hapus domain dari URL
                    const urlPath = currentUrl.replace(/^https?:\/\/[^\/]+/, '');
                    const woPath = woIndexUrl.replace(/^https?:\/\/[^\/]+/, '');
                    return urlPath === woPath;
                }

                function updateNotificationBadge() {
                    // Jika sedang di halaman Work Order Index, sembunyikan badge dan tidak perlu request
                    if (isWorkOrderIndexPage()) {
                        const badge = document.getElementById('notif-badge');
                        if (badge) badge.classList.add('hidden');
                        return;
                    }

                    fetch('{{ route('mekanik.work-order.api.antrian-count') }}')
                        .then(response => response.json())
                        .then(data => {
                            const count = data.count;
                            const badge = document.getElementById('notif-badge');
                            if (count > 0) {
                                badge.textContent = count;
                                badge.classList.remove('hidden');
                            } else {
                                badge.classList.add('hidden');
                            }
                        })
                        .catch(error => console.error('Notifikasi error:', error));
                }

                // Event klik notifikasi -> arahkan ke Work Order dengan filter status antrian
                document.getElementById('notification-button')?.addEventListener('click', function() {
                    // Sembunyikan badge segera (optimis) sebelum redirect
                    const badge = document.getElementById('notif-badge');
                    if (badge) badge.classList.add('hidden');
                    window.location.href = '{{ route('mekanik.work-order.index') }}?status=antrian';
                });

                document.addEventListener('DOMContentLoaded', function() {
                    updateNotificationBadge();
                    setInterval(updateNotificationBadge, 10000);
                });
            </script>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                @yield('content')

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
