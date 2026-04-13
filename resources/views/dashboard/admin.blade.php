@extends('layouts.app')

@section('title', 'Dashboard - Kepala Bengkel')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard Kepala Bengkel</h1>
                <p class="text-gray-600 mt-2">Selamat datang, {{ auth()->user()->name }}!</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 xl:grid-cols-4">
                <!-- Antrian WO Hari Ini -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Antrian WO Hari Ini</p>
                            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $antrian_hari_ini }}</p>
                            <p class="text-gray-400 text-xs mt-2">Work Order pending</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Mekanik Aktif -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Mekanik Aktif</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ $mekanik_aktif }}</p>
                            <p class="text-gray-400 text-xs mt-2">Sedang bekerja</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pendapatan Hari Ini -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Pendapatan Hari Ini</p>
                            <p class="text-3xl font-bold text-purple-600 mt-2">Rp {{ number_format($pendapatan_hari_ini, 0, ',', '.') }}</p>
                            <p class="text-gray-400 text-xs mt-2">Total penerimaan</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total WO Bulan Ini -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total WO Bulan Ini</p>
                            <p class="text-3xl font-bold text-orange-600 mt-2">{{ $total_wo_bulan_ini }}</p>
                            <p class="text-gray-400 text-xs mt-2">Work Order selesai</p>
                        </div>
                        <div class="bg-orange-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Grafik WO --> 
                <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Statistik Servis Per Bulan</h2>
                    <div class="space-y-8">
                        <!-- WO Chart -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-4">Work Order</h3>
                            <div class="flex items-end justify-between h-48 space-x-2">
                                @foreach($chart_data['wo'] as $index => $value)
                                    <div class="flex flex-col items-center flex-1">
                                        <div class="w-full bg-blue-200 rounded-t" style="height: {{ ($value / 50) * 100 }}px; background-color: #3b82f6;"></div>
                                        <p class="text-xs text-gray-600 mt-2">{{ $chart_data['bulan'][$index] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Pendapatan Chart -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-4">Pendapatan</h3>
                            <div class="flex items-end justify-between h-48 space-x-2">
                                @foreach($chart_data['pendapatan'] as $index => $value)
                                    <div class="flex flex-col items-center flex-1">
                                        <div class="w-full bg-green-200 rounded-t" style="height: {{ ($value / 800000) * 100 }}px; background-color: #10b981;"></div>
                                        <p class="text-xs text-gray-600 mt-2">{{ $chart_data['bulan'][$index] }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-xs text-gray-500 mt-4 text-right">Rupiah (Juta)</p>
                        </div>
                    </div>
                </div>

                <!-- Layanan Populer -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Layanan Populer</h2>
                    <div class="space-y-4">
                        @foreach($layanan_populer as $index => $layanan)
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $layanan['nama'] }}</p>
                                    <div class="mt-1 w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($layanan['jumlah'] / 15) * 100 }}%"></div>
                                    </div>
                                </div>
                                <p class="text-sm font-semibold text-gray-900 ml-4">{{ $layanan['jumlah'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <a href="#" class="inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Work Order
                    </a>
                    <a href="#" class="inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Kelola Mekanik
                    </a>
                    <a href="#" class="inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        Jenis Servis
                    </a>
                    <a href="#" class="inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        Sparepart
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
