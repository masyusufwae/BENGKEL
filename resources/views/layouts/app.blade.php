<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Bengkel Management System')</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/logo/icon.png') }}?v=2">
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
    <!-- Include Navbar Component -->
    @include('components.navbar')

    <!-- Main Layout Container (Offset for Header) -->
    <div class="pt-16">
        @yield('content')
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
