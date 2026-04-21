{{-- detail.blade.php --}}
@extends('mekanik.layouts.app')

{{-- @section('header')
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h2 class="font-bold text-2xl text-gray-800">Detail Work Order</h2>
            <p class="text-sm text-gray-500">Informasi lengkap kendaraan, layanan, dan sparepart</p>
        </div>
    </div>
@endsection --}}

@section('content')
    <header class="bg-white py-6 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h2 class="font-bold text-2xl text-black">
                Detail Work Order
            </h2>

            <div class="flex items-center gap-2">
                {{-- Search --}}
                <form method="GET" action="" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Cari Plat Nomor..."
                        class="border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </header>
    <div class="py-8">
        {{-- Grid Utama: 2/3 Konten, 1/3 Sidebar --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            {{-- KOLOM KIRI & TENGAH (Lebar) --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- CARD INFO UTAMA --}}
                <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-xl text-white">{{ $wo->kendaraan->merek }} {{ $wo->kendaraan->model }}
                            </h3>
                            <p class="text-blue-100 text-sm">Work Order #{{ $wo->id_wo }}</p>
                        </div>
                        <span
                            class="px-3 py-1 bg-white/20 rounded-full text-white text-xs font-semibold uppercase tracking-wider border border-blue">
                            {{ $wo->kendaraan->nomor_polisi }}
                        </span>
                    </div>

                    <div class="p-6">
                        {{-- Grid Detail Kendaraan --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <h4 class="font-bold text-gray-800 border-b-2 border-blue-500 pb-2 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1">
                                        </path>
                                    </svg>
                                    Interior & Engine
                                </h4>
                                <ul class="space-y-3 text-sm">
                                    <li class="flex items-center text-gray-600"><svg class="w-4 h-4 text-green-500 mr-3"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>Merek: <strong class="ml-1 text-gray-800">{{ $wo->kendaraan->merek }}</strong>
                                    </li>
                                    <li class="flex items-center text-gray-600"><svg class="w-4 h-4 text-green-500 mr-3"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>Tahun: <strong class="ml-1 text-gray-800">{{ $wo->kendaraan->tahun }}</strong>
                                    </li>
                                    <li class="flex items-center text-gray-600"><svg class="w-4 h-4 text-green-500 mr-3"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>Bahan Bakar: <strong
                                            class="ml-1 text-gray-800">{{ $wo->kendaraan->jenis_bahan_bakar }}</strong></li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 border-b-2 border-blue-500 pb-2 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                                        </path>
                                    </svg>
                                    Exterior & Identity
                                </h4>
                                <ul class="space-y-3 text-sm">
                                    <li class="flex items-center text-gray-600"><svg class="w-4 h-4 text-blue-500 mr-3"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>Rangka: <span
                                            class="ml-1 font-mono text-gray-800">{{ $wo->kendaraan->nomor_rangka }}</span>
                                    </li>
                                    <li class="flex items-center text-gray-600"><svg class="w-4 h-4 text-blue-500 mr-3"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>Mesin: <span
                                            class="ml-1 font-mono text-gray-800">{{ $wo->kendaraan->nomor_mesin }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- Gambar Kendaraan --}}
                        @if ($wo->kendaraan && $wo->kendaraan->foto_kendaraan)
                            <div class="mb-6">
                                <h4 class="font-bold text-gray-800 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 16l4-4a3 3 0 014 0l4 4m-2-2l1-1a3 3 0 014 0l3 3m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Foto Kendaraan
                                </h4>
                                <img src="{{ asset('storage/' . $wo->kendaraan->foto_kendaraan) }}"
                                    class="w-full max-h-84 object-cover rounded-xl border shadow">
                            </div>
                        @endif

                        {{-- Keluhan Pelanggan --}}
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 mb-6">
                            <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                    </path>
                                </svg>
                                Keluhan Pelanggan
                            </h4>
                            <div class="relative pl-6">
                                <span class="absolute left-0 top-0 text-4xl text-blue-200 font-serif leading-none">“</span>
                                <p class="text-gray-700 italic leading-relaxed text-sm">{{ $wo->keluhan }}</p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-gray-200 flex justify-between items-center">
                                <div>
                                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Customer</p>
                                    <p class="font-semibold text-gray-800">{{ $wo->kendaraan->user->name ?? '-' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Status Saat
                                        Ini
                                    </p><span
                                        class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded uppercase tracking-tighter">{{ str_replace('_', ' ', $wo->status) }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Estimasi Selesai --}}
                        {{-- @if ($wo->estimasi_selesai)
                            <div class="bg-amber-50 p-6 rounded-xl border border-amber-200 text-center mb-6">
                                <div class="flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-amber-500 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span
                                        class="text-2xl font-bold text-amber-700">{{ $wo->estimasi_selesai->format('d M Y') }}</span>
                                </div>
                                <p class="text-amber-800 font-medium">Estimasi Selesai</p>
                            </div>
                        @endif --}}

                        {{-- Daftar Layanan Servis --}}
                        <div class="bg-Blue rounded-xl shadow-md border border-gray-200 overflow-hidden mb-6">
                            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                                <h4 class="font-bold text-xl text-black flex items-center"><svg class="w-6 h-6 mr-3"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                        </path>
                                    </svg>Layanan Servis ({{ $wo->detailServis->count() }})</h4>
                            </div>
                            <div class="p-6">
                                @forelse($wo->detailServis as $servis)
                                    <div
                                        class="flex justify-between items-center py-3 border-b border-gray-100 last:border-b-0">
                                        <div>
                                            <p class="font-bold">{{ $servis->jenisServis->nama_servis }}</p>
                                            @if ($servis->keterangan)
                                                <p class="text-sm text-gray-500">{{ $servis->keterangan }}</p>
                                            @endif
                                        </div>
                                        <span class="font-bold text-emerald-600 text-lg">Rp
                                            {{ number_format($servis->harga_jasa) }}</span>
                                    </div>
                                @empty
                                    <div class="text-center py-12 text-gray-500">
                                        <p>Belum ada layanan servis</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- Daftar Sparepart --}}
                        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden mb-6">
                            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                                <h4 class="font-bold text-xl text-black flex items-center"><svg class="w-6 h-6 mr-3"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>Sparepart Digunakan ({{ $wo->penggunaanSparepart->count() }})</h4>
                            </div>
                            <div class="p-6">
                                @forelse($wo->penggunaanSparepart as $part)
                                    <div class="flex justify-between py-3 border-b border-gray-100 last:border-b-0">
                                        <div>
                                            <p class="font-bold">{{ $part->sparepart->nama_part }}</p>
                                            <p class="text-sm text-gray-500">x{{ $part->jumlah }} (Rp
                                                {{ number_format($part->harga_satuan) }})</p>
                                        </div>
                                        <span class="font-bold text-blue-600 text-lg">Rp
                                            {{ number_format($part->subtotal) }}</span>
                                    </div>
                                @empty
                                    <div class="text-center py-12 text-gray-500">
                                        <p>Belum ada sparepart digunakan</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- Ringkasan Total --}}
                        {{-- <div
                            class="bg-gradient-to-r from-emerald-500 to-green-600 p-8 rounded-2xl shadow-2xl mb-6 text-black text-center">
                            <h3 class="text-4xl font-black mb-2">Rp {{ number_format($wo->total_harga) }}</h3>
                            <p class="text-emerald-100 font-semibold text-lg mb-4">Total Biaya Servis</p>
                        </div> --}}
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN (Aksi & Status) --}}
            <div class="space-y-6">
                @if ($wo->status == 'antrian')
                    <div class="bg-white p-4 rounded-xl shadow-md border border-gray-200">
                        <h5 class="font-bold text-xl text-blue mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Tindakan Pertama
                        </h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <form action="{{ route('mekanik.work-order.updateStatus', $wo->id_wo) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="dikerjakan">
                                <button type="submit"
                                    class="w-full bg-emerald-500 text-white py-4 rounded-xl hover:bg-emerald-600 font-bold shadow-xl text-lg">
                                    ✅ Setuju
                                </button>
                            </form>
                            <form action="{{ route('mekanik.work-order.updateStatus', $wo->id_wo) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="ditolak">
                                <button type="submit"
                                    class="w-full bg-red-500 text-white py-4 rounded-xl hover:bg-red-600 font-bold shadow-xl text-lg">
                                    ❌ Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                @endif


                {{-- Catatan Mekanik --}}
                <div class="bg-indigo-50 p-6 rounded-xl border-2 border-indigo-200 mb-6">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Catatan Mekanik
                    </h4>
                    <form action="{{ route('mekanik.work-order.updateCatatan', $wo->id_wo) }}" method="POST">
                        @csrf @method('PUT')
                        <textarea name="catatan_mekanik" rows="4"
                            placeholder="Tulis catatan perbaikan, temuan khusus, atau instruksi..."
                            class="w-full border border-indigo-300 rounded-xl p-4 focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-vertical font-medium text-sm">{{ $wo->catatan_mekanik }}</textarea>
                        <button type="submit"
                            class="mt-3 w-full bg-green-600 text-white py-3 rounded-xl hover:bg-green-700 font-bold shadow-lg transition">💾
                            Simpan Catatan</button>
                    </form>
                </div>


                {{-- Quick Specs (4 kolom horizontal) --}}
                <div class="bg-white p-4 rounded-xl shadow-md border border-gray-200">
                    <div class="grid grid-cols-4 gap-3">
                        <div class="p-3 bg-blue-50 rounded-lg text-center border border-blue-100"><span
                                class="block text-[10px] md:text-xs text-gray-500 uppercase font-bold tracking-tight">Warna</span><span
                                class="block font-bold text-blue-700 text-xs md:text-sm truncate">{{ $wo->kendaraan->warna }}</span>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg text-center border border-blue-100"><span
                                class="block text-[10px] md:text-xs text-gray-500 uppercase font-bold tracking-tight">Model</span><span
                                class="block font-bold text-blue-700 text-xs md:text-sm truncate">{{ $wo->kendaraan->model }}</span>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg text-center border border-blue-100"><span
                                class="block text-[10px] md:text-xs text-gray-500 uppercase font-bold tracking-tight">Tanggal</span><span
                                class="block font-bold text-blue-700 text-xs md:text-sm">{{ $wo->created_at->format('d/m/y') }}</span>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg text-center border border-blue-100"><span
                                class="block text-[10px] md:text-xs text-gray-500 uppercase font-bold tracking-tight">Jam
                                WO</span><span
                                class="block font-bold text-blue-700 text-xs md:text-sm">{{ $wo->created_at->format('H:i') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="space-y-4">
                    @if ($wo->status !== 'ditolak')
                        <a href="{{ route('mekanik.work-order.edit', $wo->id_wo) }}"
                            class="flex items-center justify-center w-full px-6 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow-lg font-bold text-lg transition transform hover:-translate-y-1"><svg
                                class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>🔧 Tambah Servis & Sparepart</a>
                    @endif
                    {{-- <a href="{{ route('mekanik.work-order.servis', $wo->id_wo) }}"
                        class="flex items-center justify-center w-full px-6 py-4 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 shadow-lg font-bold text-lg transition transform hover:-translate-y-1"><svg
                            class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                            </path>
                        </svg>🔧 Tambah Servis & Sparepart</a> --}}
                    <a href="{{ route('mekanik.work-order.index') }}"
                        class="flex items-center justify-center w-full px-4 py-3 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm"><svg
                            class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>Kembali ke Daftar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
