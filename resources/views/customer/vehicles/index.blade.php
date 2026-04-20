@extends('customer.layouts.app')

@section('title', 'Kendaraan Saya - Pelanggan')

@section('page-content')
<!-- Header -->
<div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Kendaraan Saya</h1>
                    <p class="text-gray-600 mt-2">Kelola kendaraan yang terdaftar</p>
                </div>
                <a href="{{ route('customer.vehicles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Kendaraan
                </a>
            </div>

<!-- Vehicles List -->
            @if(count($kendaraan_terdaftar) > 0)
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($kendaraan_terdaftar as $kendaraan)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                            <!-- Foto Kendaraan banner -->
                            @if(isset($kendaraan['foto_kendaraan']) && $kendaraan['foto_kendaraan'])
                                <div class="w-full h-48 bg-gray-100 flex items-center justify-center border-b border-gray-200">
                                    <img src="{{ asset('storage/' . $kendaraan['foto_kendaraan']) }}" alt="Foto {{ $kendaraan['merek'] }} {{ $kendaraan['model'] }}" class="w-full h-full object-contain">
                                </div>
                            @endif

                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center">
                                        <!-- Logo Brand Menggunakan API Automatis -->
                                        <div class="w-14 h-14 rounded-lg bg-gray-50 flex items-center justify-center flex-shrink-0 border border-gray-100 overflow-hidden p-1">
                                            @php
                                                $merek_awal = strtolower(explode(' ', trim($kendaraan['merek']))[0] ?? 'auto');
                                                
                                                // Mapping domain resmi brand kendaraan populer (lokal & global)
                                                // Menggunakan domain global agar API Clearbit dapat menemukan logonya
                                                $domainMap = [
                                                    'toyota' => 'toyota.com',
                                                    'honda' => 'honda.com',
                                                    'daihatsu' => 'daihatsu.com',
                                                    'suzuki' => 'globalsuzuki.com',
                                                    'mitsubishi' => 'mitsubishi-motors.com',
                                                    'nissan' => 'nissan-global.com',
                                                    'hyundai' => 'hyundai.com',
                                                    'kia' => 'kia.com',
                                                    'wuling' => 'wulingmotors.com',
                                                    'mazda' => 'mazda.com',
                                                    'isuzu' => 'isuzu.com',
                                                    'chevrolet' => 'chevrolet.com',
                                                    'bmw' => 'bmw.com',
                                                    'mercedes' => 'mercedes-benz.com',
                                                    'yamaha' => 'yamaha-motor.com',
                                                    'kawasaki' => 'kawasaki.com',
                                                    'vespa' => 'vespa.com',
                                                    'ktm' => 'ktm.com',
                                                    'ducati' => 'ducati.com',
                                                    'harley' => 'harley-davidson.com',
                                                    'piaggio' => 'piaggio.com'
                                                ];
                                                
                                                $domain = $domainMap[$merek_awal] ?? ($merek_awal . '.com');
                                            @endphp
                                            <img src="https://logo.clearbit.com/{{ $domain }}" 
                                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($merek_awal) }}&background=eff6ff&color=1d4ed8&bold=true&size=128';" 
                                                 class="w-full h-full object-contain mix-blend-multiply" 
                                                 alt="Logo {{ $kendaraan['merek'] }}">
                                        </div>
                                        <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $kendaraan['nomor_polisi'] }}</h3>
                                        <p class="text-sm text-gray-500">{{ $kendaraan['merek'] }} {{ $kendaraan['model'] }}</p>
                                    </div>
                                </div>
                                <div class="relative" x-data="{ open{{ $kendaraan['id_kendaraan'] }}: false }">
                                    <button onclick="toggleDropdown({{ $kendaraan['id_kendaraan'] }})" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                                        </svg>
                                    </button>
                                    <div id="dropdown-{{ $kendaraan['id_kendaraan'] }}" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible transition-all duration-200 z-10" style="display: none;">
                                        <a href="{{ route('customer.vehicles.edit', $kendaraan['id_kendaraan']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                        <button onclick="openDeleteConfirm({{ $kendaraan['id_kendaraan'] }})" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Hapus</button>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3 border-t border-gray-200 pt-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Tahun</span>
                                    <span class="font-medium text-gray-900">{{ $kendaraan['tahun'] }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Warna</span>
                                    <span class="font-medium text-gray-900">{{ $kendaraan['warna'] ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Bahan Bakar</span>
                                    <span class="font-medium text-gray-900">{{ $kendaraan['jenis_bahan_bakar'] ?? '-' }}</span>
                                </div>
                            </div>

                            <button class="w-full mt-4 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium">
                                Lihat Riwayat Service
                            </button>

                            <!-- Hidden Delete Form -->
                            <form id="delete-form-{{ $kendaraan['id_kendaraan'] }}" action="{{ route('customer.vehicles.destroy', $kendaraan['id_kendaraan']) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            </div> <!-- tutup div.p-6 -->
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9-7V5L12 12l-9-7v7l9 7z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Kendaraan</h3>
                    <p class="text-gray-600 mb-6">Daftarkan kendaraan Anda untuk memulai service</p>
                    <a href="{{ route('customer.vehicles.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Daftar Kendaraan Pertama
                    </a>
                </div>
            @endif

<!-- JavaScript for Dropdown and Delete Functionality -->
<script>
    let currentOpenDropdown = null;

    function toggleDropdown(vehicleId) {
        const dropdown = document.getElementById('dropdown-' + vehicleId);
        const isCurrentlyOpen = currentOpenDropdown === vehicleId;

        // Close previously open dropdown
        if (currentOpenDropdown !== null && currentOpenDropdown !== vehicleId) {
            const prevDropdown = document.getElementById('dropdown-' + currentOpenDropdown);
            if (prevDropdown) {
                prevDropdown.style.display = 'none';
                prevDropdown.classList.add('opacity-0', 'invisible');
                prevDropdown.classList.remove('opacity-100', 'visible');
            }
        }

        // Toggle current dropdown
        if (isCurrentlyOpen) {
            dropdown.style.display = 'none';
            dropdown.classList.add('opacity-0', 'invisible');
            dropdown.classList.remove('opacity-100', 'visible');
            currentOpenDropdown = null;
        } else {
            dropdown.style.display = 'block';
            dropdown.classList.remove('opacity-0', 'invisible');
            dropdown.classList.add('opacity-100', 'visible');
            currentOpenDropdown = vehicleId;
        }
    }

    function openDeleteConfirm(vehicleId) {
        if (confirm('Apakah Anda yakin ingin menghapus kendaraan ini? Semua data service akan ikut terhapus.')) {
            document.getElementById('delete-form-' + vehicleId).submit();
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (currentOpenDropdown !== null) {
            const dropdown = document.getElementById('dropdown-' + currentOpenDropdown);
            const button = event.target.closest('button');

            if (!dropdown.contains(event.target) && !button) {
                const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
                allDropdowns.forEach(dd => {
                    dd.style.display = 'none';
                    dd.classList.add('opacity-0', 'invisible');
                    dd.classList.remove('opacity-100', 'visible');
                });
                currentOpenDropdown = null;
            }
        }
    });
</script>
@endsection
