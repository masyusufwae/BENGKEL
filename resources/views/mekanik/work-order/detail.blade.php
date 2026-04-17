@extends('mekanik.layouts.app')
@section('content')
    {{-- Header --}}
    <header class="bg-white py-6 border-b shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-bold text-2xl text-gray-900">
                Detail Work Order
            </h2>
        </div>
    </header>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Grid Utama: 2/3 Konten, 1/3 Sidebar --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                {{-- KOLOM KIRI & TENGAH (Bagian yang Lebar) --}}
                <div class="lg:col-span-2 space-y-6">


                    {{-- 2. CARD INFO UTAMA --}}
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                        {{-- Header Card --}}
                        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4 flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-xl text-white">{{ $wo->kendaraan->merek }}
                                    {{ $wo->kendaraan->model }}</h3>
                                <p class="text-blue-100 text-sm">Work Order #{{ $wo->id_wo }}</p>
                            </div>
                            <span
                                class="px-3 py-1 bg-white/20 rounded-full text-white text-xs font-semibold uppercase tracking-wider border border-white/30">
                                {{ $wo->kendaraan->nomor_polisi }}
                            </span>
                        </div>

                        <div class="p-6">
                            {{-- Grid untuk Detail Kendaraan (2 Kolom ke Samping) --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                                {{-- Section: Interior & Engine --}}
                                <div>
                                    <h4
                                        class="font-bold text-gray-800 border-b-2 border-blue-500 pb-2 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1">
                                            </path>
                                        </svg>
                                        Interior & Engine
                                    </h4>
                                    <ul class="space-y-3 text-sm">
                                        <li class="flex items-center text-gray-600">
                                            <svg class="w-4 h-4 text-green-500 mr-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Merek: <strong class="ml-1 text-gray-800">{{ $wo->kendaraan->merek }}</strong>
                                        </li>
                                        <li class="flex items-center text-gray-600">
                                            <svg class="w-4 h-4 text-green-500 mr-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Tahun: <strong class="ml-1 text-gray-800">{{ $wo->kendaraan->tahun }}</strong>
                                        </li>
                                        <li class="flex items-center text-gray-600">
                                            <svg class="w-4 h-4 text-green-500 mr-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Bahan Bakar: <strong
                                                class="ml-1 text-gray-800">{{ $wo->kendaraan->jenis_bahan_bakar }}</strong>
                                        </li>
                                    </ul>
                                </div>

                                {{-- Section: Exterior & Identity --}}
                                <div>
                                    <h4
                                        class="font-bold text-gray-800 border-b-2 border-blue-500 pb-2 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                                            </path>
                                        </svg>
                                        Exterior & Identity
                                    </h4>
                                    <ul class="space-y-3 text-sm">
                                        <li class="flex items-center text-gray-600">
                                            <svg class="w-4 h-4 text-blue-500 mr-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Rangka: <span
                                                class="ml-1 font-mono text-gray-800">{{ $wo->kendaraan->nomor_rangka }}</span>
                                        </li>
                                        <li class="flex items-center text-gray-600">
                                            <svg class="w-4 h-4 text-blue-500 mr-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Mesin: <span
                                                class="ml-1 font-mono text-gray-800">{{ $wo->kendaraan->nomor_mesin }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            {{-- Gambar Work Order --}}
                            @if ($wo->gambar)
                                <div class="mb-6">
                                    <h4 class="font-bold text-gray-800 mb-3 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 16l4-4a3 3 0 014 0l4 4m-2-2l1-1a3 3 0 014 0l3 3m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Gambar Kendaraan
                                    </h4>

                                    <img src="{{ asset('storage/' . $wo->gambar) }}"
                                        class="w-full max-h-64 object-cover rounded-xl border shadow">
                                </div>
                            @endif

                            {{-- Section: Keluhan --}}
                            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
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
                                    <span
                                        class="absolute left-0 top-0 text-4xl text-blue-200 font-serif leading-none">“</span>
                                    <p class="text-gray-700 italic leading-relaxed text-sm">
                                        {{ $wo->keluhan }}
                                    </p>
                                </div>
                                <div class="mt-6 pt-4 border-t border-gray-200 flex justify-between items-center">
                                    <div>
                                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Customer
                                        </p>
                                        <p class="font-semibold text-gray-800">{{ $wo->kendaraan->user->name ?? '-' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Status
                                            Saat
                                            Ini</p>
                                        <span
                                            class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded uppercase tracking-tighter">
                                            {{ str_replace('_', ' ', $wo->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN (Aksi & Status) --}}
                <div class="space-y-6">
                    {{-- Card Update Status --}}
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                        <h5 class="font-bold text-gray-800 mb-4 flex items-center">
                            <span class="w-2 h-6 bg-blue-600 rounded mr-2"></span>
                            Update Status
                        </h5>

                        <form action="{{ route('mekanik.work-order.updateStatus', $wo->id_wo) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-2">Pilih
                                        Progress</label>
                                    <select name="status"
                                        class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 transition shadow-sm text-sm">
                                        <option value="dikerjakan" {{ $wo->status == 'dikerjakan' ? 'selected' : '' }}>🔨
                                            Sedang Dikerjakan</option>
                                        <option value="menunggu_part"
                                            {{ $wo->status == 'menunggu_part' ? 'selected' : '' }}>⏳ Menunggu Part</option>
                                        <option value="selesai" {{ $wo->status == 'selesai' ? 'selected' : '' }}>✅ Selesai
                                        </option>
                                    </select>
                                </div>
                                <button
                                    class="w-full bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700 transition duration-300 font-bold shadow-lg shadow-blue-200">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Upload Gambar --}}
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                        <h5 class="font-bold text-gray-800 mb-4">Upload Gambar</h5>

                        <form action="{{ route('mekanik.work-order.update', $wo->id_wo) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="file" name="gambar" class="w-full border rounded-lg px-3 py-2 mb-3">

                            <button class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                                Upload
                            </button>
                        </form>
                    </div>

                    {{-- 1. QUICK SPECIFICATIONS (Berjejer 4 ke samping) --}}
                    <div class="bg-white p-4 rounded-xl shadow-md border border-gray-200">
                        {{-- grid-cols-4 memaksa konten berjejer 4 kolom secara horizontal --}}
                        <div class="grid grid-cols-4 gap-3">
                            {{-- Item 1: Warna --}}
                            <div class="p-3 bg-blue-50 rounded-lg text-center border border-blue-100">
                                <span
                                    class="block text-[10px] md:text-xs text-gray-500 uppercase font-bold tracking-tight">Warna</span>
                                <span
                                    class="block font-bold text-blue-700 text-xs md:text-sm truncate">{{ $wo->kendaraan->warna }}</span>
                            </div>

                            {{-- Item 2: Model --}}
                            <div class="p-3 bg-blue-50 rounded-lg text-center border border-blue-100">
                                <span
                                    class="block text-[10px] md:text-xs text-gray-500 uppercase font-bold tracking-tight">Model</span>
                                <span
                                    class="block font-bold text-blue-700 text-xs md:text-sm truncate">{{ $wo->kendaraan->model }}</span>
                            </div>

                            {{-- Item 3: Tanggal --}}
                            <div class="p-3 bg-blue-50 rounded-lg text-center border border-blue-100">
                                <span
                                    class="block text-[10px] md:text-xs text-gray-500 uppercase font-bold tracking-tight">Tanggal</span>
                                <span
                                    class="block font-bold text-blue-700 text-xs md:text-sm">{{ $wo->created_at->format('d/m/y') }}</span>
                            </div>

                            {{-- Item 4: Jam --}}
                            <div class="p-3 bg-blue-50 rounded-lg text-center border border-blue-100">
                                <span
                                    class="block text-[10px] md:text-xs text-gray-500 uppercase font-bold tracking-tight">Jam
                                    WO</span>
                                <span
                                    class="block font-bold text-blue-700 text-xs md:text-sm">{{ $wo->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('mekanik.work-order.index') }}"
                        class="flex items-center justify-center w-full px-4 py-3 text-sm font-bold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Daftar
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
