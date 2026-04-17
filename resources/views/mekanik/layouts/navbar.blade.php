
<nav class="bg-white shadow-sm">
	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
		<div class="flex justify-between h-16">
			<!-- Logo -->
			<div class="flex items-center">
				<a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">
					🔧 Bengkel Mekanik
				</a>
			</div>
			<!-- Navigation Links -->
			<div class="flex items-center space-x-4">
				<a href="{{ route('mekanik.work-order.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 @if(request()->routeIs('mekanik.work-order.*')) underline @endif">
					Work Order
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
</nav>
