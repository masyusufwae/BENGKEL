@extends('layouts.app')

@section('title', 'Dashboard - Pelanggan')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard Pelanggan</h1>
                <p class="text-gray-600 mt-2">Selamat datang, {{ auth()->user()->name }}!</p>
            </div>

            <!-- Quick Info Cards -->
            <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-3">
                <!-- WO Aktif -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Service Aktif</p>
                            <p class="text-3xl font-bold text-blue-600 mt-2">{{ count($wo_aktif) }}</p>
                            <p class="text-gray-400 text-xs mt-2">Sedang diproses</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Servis -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Service</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ count($riwayat_servis) }}</p>
                            <p class="text-gray-400 text-xs mt-2">Riwayat servis</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Kendaraan Terdaftar -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Kendaraan Terdaftar</p>
                            <p class="text-3xl font-bold text-purple-600 mt-2">{{ count($kendaraan_terdaftar) }}</p>
                            <p class="text-gray-400 text-xs mt-2">Kendaraan milik Anda</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9-7V5L12 12l-9-7v7l9 7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Service Aktif -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Service Kendaraan Aktif</h2>
                    @if(count($wo_aktif) > 0)
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
                                    <div class="space-y-2">
                                        <div>
                                            <p class="text-xs text-gray-600">Tanggal Masuk: {{ $wo['tanggal_masuk'] }}</p>
                                            <p class="text-xs text-gray-600">Estimasi Selesai: <span class="font-semibold text-blue-600">{{ $wo['estimasi'] }}</span></p>
                                        </div>
                                        <div class="mt-4">
                                            <div class="flex justify-between items-center mb-2">
                                                <p class="text-xs font-medium text-gray-600">Progress</p>
                                                <p class="text-xs font-semibold text-gray-900">65%</p>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: 65%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-500">Tidak ada service aktif</p>
                            <a href="{{ route('customer.orders.create') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">Pesan Service Sekarang</a>
                        </div>
                    @endif
                </div>

                <!-- Jadwal Servis Berikutnya -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">📅 Jadwal Servis Berikutnya</h2>
                    <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-lg p-6 border border-orange-200">
                        <p class="text-sm text-gray-600">Estimasi servis berkala:</p>
                        <p class="text-2xl font-bold text-orange-600 mt-2">{{ $jadwal_servis_berikutnya }}</p>
                        <p class="text-xs text-gray-500 mt-4">Berdasarkan riwayat servis sebelumnya</p>
                        <button class="w-full mt-4 bg-orange-600 text-white py-2 rounded-lg hover:bg-orange-700 text-sm font-medium">
                            Pesan Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Data Kendaraan -->
            <div class="mt-8 bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Kendaraan Terdaftar</h2>
                    <a href="{{ route('customer.vehicles.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua</a>
                </div>
                @if(count($kendaraan_terdaftar) > 0)
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($kendaraan_terdaftar as $kendaraan)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center mb-3">
                                    <div class="w-12 h-12 bg-gray-300 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9-7V5L12 12l-9-7v7l9 7z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-900">{{ $kendaraan['nomor_polisi'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $kendaraan['merek'] }} {{ $kendaraan['model'] }}</p>
                                    </div>
                                </div>
                                <div class="space-y-2 text-sm text-gray-600 border-t border-gray-200 pt-3">
                                    <p>Tahun: {{ $kendaraan['tahun'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 py-8 text-center">Belum ada kendaraan terdaftar</p>
                @endif
            </div>

            <!-- Riwayat Service -->
            <div class="mt-8 bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Riwayat Service</h2>
                    <a href="{{ route('customer.orders.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua</a>
                </div>
                @if(count($riwayat_servis) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left px-4 py-3 text-sm font-semibold text-gray-900">ID WO</th>
                                    <th class="text-left px-4 py-3 text-sm font-semibold text-gray-900">Tanggal</th>
                                    <th class="text-left px-4 py-3 text-sm font-semibold text-gray-900">Kendaraan</th>
                                    <th class="text-left px-4 py-3 text-sm font-semibold text-gray-900">Jenis Service</th>
                                    <th class="text-left px-4 py-3 text-sm font-semibold text-gray-900">Total</th>
                                    <th class="text-left px-4 py-3 text-sm font-semibold text-gray-900">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayat_servis as $riwayat)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $riwayat['id_wo'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $riwayat['tanggal'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $riwayat['kendaraan'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $riwayat['jenis'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">Rp {{ number_format($riwayat['total'], 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $riwayat['status_bayar'] == 'lunas' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $riwayat['status_bayar'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 py-8 text-center">Belum ada riwayat service</p>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <a href="{{ route('customer.orders.create') }}" class="inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Pesan Service
                    </a>
                    <a href="{{ route('customer.vehicles.index') }}" class="inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Daftar Kendaraan
                    </a>
                    <a href="{{ route('customer.invoices.index') }}" class="inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700">
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
@endsection
