@extends('mekanik.layouts.app')

@section('title', 'Dashboard - Mekanik')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard Mekanik</h1>
                <p class="text-gray-600 mt-2">Selamat datang, {{ auth()->user()->name }}!</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
                <!-- WO Diproses -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">WO Diproses</p>
                            <p class="text-3xl font-bold text-blue-600 mt-2">{{ count($wo_diproses) }}</p>
                            <p class="text-gray-400 text-xs mt-2">Sedang dikerjakan</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- WO Menunggu -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">WO Menunggu</p>
                            <p class="text-3xl font-bold text-yellow-600 mt-2">{{ count($wo_menunggu) }}</p>
                            <p class="text-gray-400 text-xs mt-2">Antrian</p>
                        </div>
                        <div class="bg-yellow-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Sparepart Kosong -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Sparepart Kosong</p>
                            <p class="text-3xl font-bold text-red-600 mt-2">{{ count($sparepart_kosong) }}</p>
                            <p class="text-gray-400 text-xs mt-2">Perlu restok</p>
                        </div>
                        <div class="bg-red-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2M8 5a4 4 0 018 0v14a4 4 0 01-8 0V5z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total WO Hari Ini -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">WO Hari Ini</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ $total_wo_hari_ini }}</p>
                            <p class="text-gray-400 text-xs mt-2">
                                {{ $wo_selesai_hari_ini }} selesai,
                                {{ $total_wo_hari_ini - $wo_selesai_hari_ini }} diproses
                            </p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- WO yang Sedang Diproses -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Work Order Sedang Diproses</h2>
                    @if(count($wo_diproses) > 0)
                        <div class="space-y-4">
                            @foreach($wo_diproses as $wo)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $wo['id_wo'] }}</h3>
                                            <p class="text-sm text-gray-600">{{ $wo['kendaraan'] }}</p>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $wo['status'] }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <p class="text-xs text-gray-500">Estimasi: {{ $wo['estimasi'] }}</p>
                                        <button class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Lanjutkan</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 py-8 text-center">Tidak ada WO yang diproses</p>
                    @endif
                </div>

                <!-- Sparepart Stok Rendah -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">⚠️ Stok Rendah</h2>
                    @if(count($sparepart_kosong) > 0)
                        <div class="space-y-3">
                            @foreach($sparepart_kosong as $part)
                                <div class="border-l-4 border-red-500 bg-red-50 p-3 rounded">
                                    <p class="text-sm font-medium text-gray-900">{{ $part['nama'] }}</p>
                                    <p class="text-xs text-gray-600 mt-1">
                                        Stok: <span class="font-semibold {{ $part['stok'] == 0 ? 'text-red-600' : 'text-yellow-600' }}">{{ $part['stok'] }}</span> / Min: {{ $part['minimum'] }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 py-8 text-center">Semua sparepart stok aman</p>
                    @endif
                </div>
            </div>

            <!-- WO Menunggu -->
            <div class="mt-8 bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Antrian Work Order</h2>
                @if(count($wo_menunggu) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left px-4 py-3 text-sm font-semibold text-gray-900">ID WO</th>
                                    <th class="text-left px-4 py-3 text-sm font-semibold text-gray-900">Kendaraan</th>
                                    <th class="text-left px-4 py-3 text-sm font-semibold text-gray-900">Keluhan</th>
                                    <th class="text-left px-4 py-3 text-sm font-semibold text-gray-900">Tanggal Masuk</th>
                                    <th class="text-left px-4 py-3 text-sm font-semibold text-gray-900">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wo_menunggu as $wo)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $wo['id_wo'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $wo['kendaraan'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $wo['keluhan'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $wo['tanggal'] }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <button class="text-blue-600 hover:text-blue-800 font-medium">Mulai Kerja</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 py-8 text-center">Tidak ada WO yang menunggu</p>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <a href="#" class="inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Update Progress
                    </a>
                    <a href="#" class="inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Input Sparepart
                    </a>
                    <a href="#" class="inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Selesaikan WO
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
