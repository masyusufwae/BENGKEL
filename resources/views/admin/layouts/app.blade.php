{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Bengkel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-xl font-bold text-gray-800">Bengkel System</h1>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('admin.dashboard') }}"
                            class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'border-blue-500 text-gray-900' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.mekanik.index') }}"
                            class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('admin.mekanik.*') ? 'border-blue-500 text-gray-900' : '' }}">
                            Mekanik
                        </a>
                        <a href="{{ route('admin.servis.index') }}"
                            class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('admin.servis.*') ? 'border-blue-500 text-gray-900' : '' }}">
                            Jenis Servis
                        </a>
                        <a href="{{ route('admin.sparepart.index') }}"
                            class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('admin.sparepart.*') ? 'border-blue-500 text-gray-900' : '' }}">
                            Sparepart
                        </a>
                        <a href="{{ route('admin.work-order.index') }}"
                            class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('admin.work-order.*') ? 'border-blue-500 text-gray-900' : '' }}">
                            Work Order
                        </a>
                        <a href="{{ route('admin.invoice.index') }}"
                            class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Cetak Invoice
                        </a>
                        <a href="{{ route('admin.laporan.index') }}"
                            class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('admin.laporan.*') ? 'border-blue-500 text-gray-900' : '' }}">
                            Laporan Servis
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="ml-3 relative">
                        <div class="flex items-center space-x-3 cursor-pointer" onclick="toggleDropdown()">
                            <!-- Foto Profil -->
                            <img class="h-8 w-8 rounded-full object-cover"
                                src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt="profile">

                            <!-- Nama -->
                            <span class="text-sm text-gray-700">{{ auth()->user()->name }}</span>
                        </div>

                        <!-- Dropdown -->
                        <div id="dropdownMenu"
                            class="hidden absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Profil
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Script Dropdown -->
                <script>
                    function toggleDropdown() {
                        const menu = document.getElementById('dropdownMenu');
                        menu.classList.toggle('hidden');
                    }

                    // Optional: klik di luar untuk menutup
                    window.addEventListener('click', function(e) {
                        if (!e.target.closest('.relative')) {
                            document.getElementById('dropdownMenu').classList.add('hidden');
                        }
                    });
                </script>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>
</body>

</html>
