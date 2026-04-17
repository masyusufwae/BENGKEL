@extends('layouts.app')

@section('title', 'Dashboard - Pelanggan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="flex h-screen">
        <!-- Left Sidebar Navigation -->
        <div class="w-96 bg-white shadow-lg overflow-y-auto">
            <div class="p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Navigation</h2>
                <nav class="space-y-3 mb-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 rounded-lg bg-blue-100 text-blue-600 font-medium">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('customer.orders.index') }}" class="flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Order History
                    </a>
                    <a href="{{ route('customer.vehicles.index') }}" class="flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9-7V5L12 12l-9-7v7l9 7z"></path>
                        </svg>
                        Kendaraan
                    </a>
                    <a href="{{ route('customer.invoices.index') }}" class="flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Invoice
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Settings
                    </a>
                </nav>

                <!-- Stats Cards in Sidebar -->
                <div class="space-y-3 border-t border-gray-200 pt-6 mb-6">
                    <h3 class="text-sm font-bold text-gray-900 uppercase">Quick Stats</h3>

                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-xs font-medium text-gray-600">Service Aktif</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ count($wo_aktif) }}</p>
                    </div>

                    <div class="bg-green-50 rounded-lg p-4">
                        <p class="text-xs font-medium text-gray-600">Total Service</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ count($riwayat_servis) }}</p>
                    </div>

                    <div class="bg-purple-50 rounded-lg p-4">
                        <p class="text-xs font-medium text-gray-600">Kendaraan Terdaftar</p>
                        <p class="text-2xl font-bold text-purple-600 mt-1">{{ count($kendaraan_terdaftar) }}</p>
                    </div>
                </div>

                <!-- Recent Orders in Sidebar -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-sm font-bold text-gray-900 uppercase mb-3">Recent Orders</h3>
                    @if(count($riwayat_servis) > 0)
                        <div class="space-y-2 max-h-64 overflow-y-auto">
                            @foreach($riwayat_servis as $riwayat)
                                <div class="bg-gray-50 rounded p-3 text-xs">
                                    <div class="flex justify-between items-start mb-1">
                                        <p class="font-semibold text-gray-900">#{{ $riwayat['id_wo'] }}</p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                            {{ $riwayat['status_bayar'] == 'lunas' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $riwayat['status_bayar'] }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600">{{ $riwayat['kendaraan'] }}</p>
                                    <p class="text-gray-500 mt-1">Rp {{ number_format($riwayat['total'], 0, ',', '.') }}</p>
                                    <p class="text-gray-400 mt-1">{{ $riwayat['tanggal'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-xs">Belum ada order</p>
                    @endif
                </div>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="mt-8 border-t border-gray-200 pt-6">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 text-left">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="p-8">
                <!-- Profile Card -->
                <div class="bg-white rounded-lg shadow p-6 mb-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h3>
                                <p class="text-gray-500">Customer</p>
                            </div>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Edit Profile</a>
                    </div>
                </div>

                <!-- Jadwal Servis Berikutnya -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border border-blue-300 mb-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-3">📅 Jadwal Servis Berikutnya</h2>
                    <p class="text-sm text-gray-700 font-medium mb-2">Estimasi servis berkala:</p>
                    <p class="text-3xl font-bold text-blue-700">{{ $jadwal_servis_berikutnya }}</p>
                    <p class="text-xs text-gray-600 mt-3 italic">⏰ Berdasarkan interval servis standar manufaktur</p>
                    <a href="{{ route('customer.orders.create') }}" class="w-full mt-4 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 text-sm font-medium text-center block">
                        📍 Pesan Service Sekarang
                    </a>
                </div>

                <!-- Kendaraan Butuh Perhatian -->
                <div class="bg-white rounded-lg shadow p-6 mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold text-gray-900">🚗 Kendaraan Butuh Perhatian</h2>
                        <a href="{{ route('customer.vehicles.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua →</a>
                    </div>
                    @if(count($kendaraan_terdaftar) > 0)
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            @foreach($kendaraan_terdaftar as $kendaraan)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex items-center mb-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center text-white">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9-7V5L12 12l-9-7v7l9 7z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="font-semibold text-gray-900">{{ $kendaraan['nomor_polisi'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $kendaraan['merek'] }} {{ $kendaraan['model'] }}</p>
                                        </div>
                                    </div>
                                    <div class="space-y-2 text-sm text-gray-600 border-t border-gray-200 pt-3">
                                        <p>📅 Tahun: {{ $kendaraan['tahun'] }}</p>
                                        <div class="mt-3 pt-2 border-t border-gray-100 bg-blue-50 rounded p-3">
                                            <p class="text-xs text-gray-600 font-medium">Jadwal Servis:</p>
                                            <div class="flex items-center gap-2 mt-2">
                                                <span class="text-lg">{{ $kendaraan['jadwal_icon'] }}</span>
                                                <p class="font-bold
                                                    @if($kendaraan['jadwal_status'] === 'overdue' || $kendaraan['jadwal_status'] === 'urgent') text-red-600
                                                    @elseif($kendaraan['jadwal_status'] === 'warning') text-yellow-600
                                                    @else text-green-600
                                                    @endif
                                                ">
                                                    {{ $kendaraan['jadwal_servis'] }}
                                                </p>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">{{ $kendaraan['jadwal_tanggal'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 py-8 text-center">Belum ada kendaraan terdaftar</p>
                    @endif
                </div>

                <!-- Service Aktif -->
                @if(count($wo_aktif) > 0)
                    <div class="bg-white rounded-lg shadow p-6 mb-8">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Service Kendaraan Aktif</h2>
                        <div class="space-y-4">
                            @foreach($wo_aktif as $wo)
                                <div class="border border-blue-200 rounded-lg p-4 bg-blue-50">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $wo['id_wo'] }}</h3>
                                            <p class="text-sm text-gray-600">{{ $wo['kendaraan'] }}</p>
                                        </div>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-200 text-blue-800">
                                            {{ $wo['status'] }}
                                        </span>
                                    </div>
                                    <div class="space-y-2 text-xs text-gray-600">
                                        <p>Tanggal Masuk: {{ $wo['tanggal_masuk'] }}</p>
                                        <p>Estimasi Selesai: <span class="font-semibold text-blue-600">{{ $wo['estimasi'] }}</span></p>
                                        <div class="mt-3">
                                            <div class="flex justify-between items-center mb-1">
                                                <p>Progress</p>
                                                <p>65%</p>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: 65%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Aksi Cepat -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h2>
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                        <a href="{{ route('customer.orders.create') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Pesan Service
                        </a>
                        <a href="{{ route('customer.vehicles.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Daftar Kendaraan
                        </a>
                        <a href="{{ route('customer.invoices.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Lihat Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
