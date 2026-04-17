<!-- Header Navigation -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 w-full shadow-sm h-16">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
        <div class="flex justify-between items-center w-full">
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
