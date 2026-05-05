@extends('customer.layouts.app')

@section('title', 'Detail Work Order - ' . ($wo->nomor_wo ?? ''))

@section('page-content')
<div class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Header --}}
        <header class="bg-white py-6 border-b">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-2xl text-black flex items-center gap-3">
                    <a href="{{ route('customer.orders.index') }}" class="text-gray-400 hover:text-blue-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    Detail Work Order #{{ $wo->nomor_wo }}
                </h2>
                <span class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-lg text-sm uppercase tracking-wide shadow-lg">
                    {{ ucfirst(str_replace('_', ' ', $wo->status)) }}
                </span>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            {{-- Left: Vehicle Info & Photo --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Vehicle Card --}}
                <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-4">
                        <h3 class="font-bold text-xl text-white">{{ $wo->kendaraan->merek }} {{ $wo->kendaraan->model }}</h3>
                        <p class="text-emerald-100 text-sm">Nopol: {{ $wo->kendaraan->nomor_polisi }}</p>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Spesifikasi Kendaraan
                            </h4>
                            <dl class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Tahun</span>
                                    <span class="font-medium">{{ $wo->kendaraan->tahun }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Warna</span>
                                    <span class="font-medium">{{ $wo->kendaraan->warna ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Bahan Bakar</span>
                                    <span class="font-medium">{{ $wo->kendaraan->jenis_bahan_bakar ?? '-' }}</span>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Identitas Mesin
                            </h4>
                            <dl class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">No. Rangka</span>
                                    <span class="font-mono bg-gray-100 px-3 py-1 rounded text-xs">{{ $wo->kendaraan->nomor_rangka ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">No. Mesin</span>
                                    <span class="font-mono bg-gray-100 px-3 py-1 rounded text-xs">{{ $wo->kendaraan->nomor_mesin ?? '-' }}</span>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                {{-- Vehicle Photo --}}
                @if($wo->kendaraan->foto_kendaraan)
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                    <h4 class="font-bold text-lg mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Foto Kendaraan
                    </h4>
                    <img src="{{ asset('storage/' . $wo->kendaraan->foto_kendaraan) }}" alt="Kendaraan" class="w-full h-80 object-cover rounded-xl shadow-md">
                </div>
                @endif
            </div>

            {{-- Right: Status & Summary --}}
            <div class="space-y-6">

                {{-- Status Timeline --}}
                <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                    <h5 class="font-bold text-lg mb-4 text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Status Saat Ini
                    </h5>
                    <div class="space-y-2">
                        <div class="flex items-center text-sm">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                            <span class="font-medium text-blue-600">{{ ucfirst($wo->status) }}</span>
                        </div>
                        <div class="text-xs text-gray-500 space-y-1">
                            <div>Tanggal Masuk: {{ $wo->tanggal_masuk?->format('d M Y H:i') ?? '-' }}</div>
                            @if($wo->estimasi_selesai)
                            <div>Estimasi Selesai: {{ $wo->estimasi_selesai->format('d M Y H:i') }}</div>
                            @endif
                            @if($wo->tanggal_selesai)
                            <div>Tanggal Selesai: {{ $wo->tanggal_selesai->format('d M Y H:i') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Mekanik Assigned --}}
                @if($wo->mekanik)
                <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                    <h5 class="font-bold text-lg mb-4 text-gray-800">Mekanik Penanggung Jawab</h5>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="font-bold text-blue-600 text-sm">{{ substr($wo->mekanik->nama_mekanik, 0, 2) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold">{{ $wo->mekanik->nama_mekanik }}</p>
                            <p class="text-sm text-gray-500">{{ $wo->mekanik->spesialisasi }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Quick Actions --}}
                <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                    <h5 class="font-bold text-lg mb-4 text-gray-800">Aksi Cepat</h5>
                    <div class="space-y-3">
                        <a href="{{ route('chat.index') }}" class="w-full flex items-center justify-center px-4 py-3 border border-blue-200 bg-blue-50 text-blue-700 rounded-xl hover:bg-blue-100 transition font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            Chat dengan Bengkel
                        </a>
                        @if($wo->invoice && $wo->invoice->first())
                        <a href="#" class="w-full flex items-center justify-center px-4 py-3 border border-emerald-200 bg-emerald-50 text-emerald-700 rounded-xl hover:bg-emerald-100 transition font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download Invoice
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Keluhan Pelanggan --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
            <h4 class="font-bold text-xl mb-6 flex items-center text-gray-800">
                <svg class="w-6 h-6 mr-3 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                Keluhan Anda
            </h4>
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 p-6 rounded-xl border-l-4 border-yellow-400">
                <blockquote class="text-lg italic text-gray-700 leading-relaxed">
                    "{{ $wo->keluhan }}"
                </blockquote>
                <p class="text-sm text-gray-500 mt-4">Diterima pada {{ $wo->tanggal_masuk?->format('d M Y H:i') }}</p>
            </div>
        </div>

        {{-- Servis & Parts --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- Servis Performed --}}
            <div class="bg-white rounded-xl shadow-md border border-gray-200">
                <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-4 rounded-t-xl">
                    <h4 class="font-bold text-lg text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                        Layanan Servis
                        <span class="ml-2 px-2 py-1 bg-white/20 rounded-full text-xs font-bold">({{ $wo->detailServis->count() }})</span>
                    </h4>
                </div>
                <div class="p-6">
                    @forelse($wo->detailServis as $servis)
                    <div class="flex justify-between items-start py-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">{{ $servis->jenisServis->nama_servis ?? $servis->jenis_servis }}</p>
                            @if($servis->keterangan)
                            <p class="text-sm text-gray-500 mt-1">{{ $servis->keterangan }}</p>
                            @endif
                        </div>
                        <span class="font-bold text-emerald-600 ml-4">Rp {{ number_format($servis->harga_jasa, 0, ',', '.') }}</span>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p>Belum ada layanan servis tercatat</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Parts Used --}}
            <div class="bg-white rounded-xl shadow-md border border-gray-200">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-xl">
                    <h4 class="font-bold text-lg text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Sparepart Digunakan
                        <span class="ml-2 px-2 py-1 bg-white/20 rounded-full text-xs font-bold">({{ $wo->penggunaanSparepart->count() }})</span>
                    </h4>
                </div>
                <div class="p-6">
                    @forelse($wo->penggunaanSparepart as $part)
                    <div class="flex justify-between items-start py-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">{{ $part->sparepart->nama_part ?? $part->nama_part }}</p>
                            <p class="text-sm text-gray-500">{{ $part->jumlah }} x Rp {{ number_format($part->harga_satuan, 0, ',', '.') }}</p>
                        </div>
                        <span class="font-bold text-blue-600 ml-4">Rp {{ number_format($part->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p>Belum ada sparepart tercatat</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Catatan Mekanik --}}
        @if($wo->catatan_mekanik)
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-8 border border-indigo-200">
            <h4 class="font-bold text-xl mb-6 flex items-center text-indigo-800">
                <svg class="w-6 h-6 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Catatan dari Mekanik
            </h4>
            <div class="bg-white p-6 rounded-xl border-l-4 border-indigo-400">
                <p class="text-gray-700 leading-relaxed">{{ $wo->catatan_mekanik }}</p>
            </div>
        </div>
        @endif

        {{-- Invoice Summary --}}
        @if($wo->invoice->isNotEmpty())
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <h4 class="font-bold text-xl mb-6 flex items-center text-gray-800">
                <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Ringkasan Invoice
            </h4>
            @php $latestInvoice = $wo->invoice->sortByDesc('created_at')->first(); @endphp
            <div class="bg-green-50 p-6 rounded-xl border border-green-200">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">No. Invoice</span>
                        <p class="font-bold text-gray-900">{{ $latestInvoice->id_invoice ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Total</span>
                        <p class="font-bold text-green-600 text-lg">Rp {{ number_format($latestInvoice->total_bayar, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Status Bayar</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                            {{ $latestInvoice->status_bayar == 'lunas' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($latestInvoice->status_bayar) }}
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-500">Tgl. Invoice</span>
                        <p class="font-medium">{{ $latestInvoice->created_at?->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
