@extends('layouts.app')

@section('title', 'Pesanan Service - Pelanggan')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Pesanan Service</h1>
                    <p class="text-gray-600 mt-2">Riwayat dan status pesanan service Anda</p>
                </div>
                <a href="{{ route('customer.orders.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Pesan Service
                </a>
            </div>

            <!-- Tabs -->
            <div class="mb-6 flex gap-4 border-b border-gray-200">
                <button class="px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600">
                    Semua Pesanan
                </button>
                <button class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">
                    Aktif
                </button>
                <button class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">
                    Selesai
                </button>
            </div>

            <!-- Orders List -->
            @if(count($riwayat_servis) > 0)
                <div class="space-y-4">
                    @foreach($riwayat_servis as $order)
                        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $order['id_wo'] }}</h3>
                                    <p class="text-sm text-gray-600">{{ $order['tanggal'] }}</p>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    {{ $order['status_bayar'] == 'lunas' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($order['status_bayar']) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 border-t border-gray-200 pt-4">
                                <div>
                                    <p class="text-xs text-gray-600 uppercase tracking-wide">Kendaraan</p>
                                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $order['kendaraan'] }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600 uppercase tracking-wide">Jenis Service</p>
                                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $order['jenis'] }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600 uppercase tracking-wide">Total Biaya</p>
                                    <p class="text-sm font-medium text-gray-900 mt-1">Rp {{ number_format($order['total'], 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                        Lihat Detail →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Pesanan</h3>
                    <p class="text-gray-600 mb-6">Mulai pesan service untuk kendaraan Anda</p>
                    <a href="{{ route('customer.orders.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Pesan Service Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
