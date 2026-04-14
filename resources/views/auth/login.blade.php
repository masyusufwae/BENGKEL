<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-900">Bengkel Management</h1>
        <p class="mt-1 text-sm text-gray-600">Sistem Manajemen Service Kendaraan</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3">
            @foreach ($errors->all() as $error)
                <p class="text-sm text-red-700">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="admin@bengkel.com"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="mb-2 flex items-center justify-between">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-indigo-600 hover:text-indigo-700 hover:underline" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 pr-20 text-sm shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                >
                <button
                    type="button"
                    onclick="const p=document.getElementById('password'); this.textContent=p.type==='password'?'Sembunyi':'Lihat'; p.type=p.type==='password'?'text':'password';"
                    class="absolute right-2 top-1/2 -translate-y-1/2 rounded-md px-2 py-1 text-xs font-medium text-gray-600 hover:bg-gray-100"
                >
                    Lihat
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="flex cursor-pointer items-center gap-2">
            <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <span class="text-sm text-gray-600">Ingat saya</span>
        </label>

        <button
            type="submit"
            class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
        >
            Login
        </button>
    </form>

    <div class="mt-6 rounded-lg border border-indigo-200 bg-indigo-50 p-4">
        <p class="mb-2 text-sm font-semibold text-indigo-900">Akun Demo</p>
        <div class="space-y-1 text-xs text-indigo-800">
            <p><strong>Admin:</strong> admin@bengkel.com</p>
            <p><strong>Mekanik:</strong> mekanik@bengkel.com</p>
            <p><strong>Pelanggan:</strong> pelanggan@bengkel.com</p>
            <p><strong>Password:</strong> password123</p>
        </div>
    </div>
</x-guest-layout>
