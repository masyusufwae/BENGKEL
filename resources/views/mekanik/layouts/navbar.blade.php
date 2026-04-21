{{--
<nav class="bg-white shadow-sm">
	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
		<div class="flex justify-between h-16">
			<!-- Logo -->
			<div class="flex items-center">
				<a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
					<img src="{{ asset('storage/logo/icon.png') }}" alt="Logo Bengkel" class="h-10 w-10 rounded-full object-cover shadow-md">
					<span class="text-xl font-bold text-blue-600 hidden sm:inline">Bengkel Mekanik</span>
				</a>
			</div>
			<!-- Navigation Links -->
			<div class="flex items-center space-x-4">
				<a href="{{ route('mekanik.work-order.index') }}" id="wo-bell-link" class="relative p-2 rounded-lg hover:bg-red-50 text-gray-700 hover:text-red-900 group transition-all @if(request()->routeIs('mekanik.work-order.*')) bg-red-50 underline @endif">
					<svg id="wo-bell-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
					</svg>
					<span id="wo-dot-badge" class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 border-2 border-white rounded-full animate-ping"></span>
					<span id="wo-count-badge" class="absolute top-1 right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold shadow-lg border-2 border-white group-hover:scale-110 transition-all">0</span>
				</a>
				<a href="{{ route('mekanik.riwayat') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 @if(request()->routeIs('mekanik.riwayat')) underline font-bold @endif">
					Riwayat
				</a>
				<a href="{{ route('mekanik.sparepart.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 @if(request()->routeIs('mekanik.sparepart.*')) underline @endif">
					Sparepart
				</a>
				<div class="flex items-center space-x-2">
					<span class="text-sm text-gray-600">{{ auth()->user()->name ?? 'Mekanik' }}</span>
					<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
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
</nav> --}}
