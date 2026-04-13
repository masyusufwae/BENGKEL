<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Bengkel Management System')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen">
        <!-- Header Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">
                            🔧 Bengkel Management
                        </a>
                    </div>
                    <!-- Navigation Links -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucfirst(auth()->user()->role) }}
                                </span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                                    Logout
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
        <!-- Main Content -->
        <main>
            @yield('content')
        </main>
    </div>
    <!-- Footer -->
    <footer class="bg-white shadow-sm mt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
            <p class="text-center text-gray-600 text-sm">
                &copy; 2024 Bengkel Management System. Semua hak dilindungi.
            </p>
        </div>
    </footer>
</body>
</html>
