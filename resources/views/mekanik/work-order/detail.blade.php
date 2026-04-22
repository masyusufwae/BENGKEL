@extends('mekanik.layouts.app')

@section('content')
    {{-- Header --}}
    <header class="bg-white py-6 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h2 class="font-bold text-2xl text-black flex items-center gap-3">
                <a href="{{ route('mekanik.work-order.index') }}" class="text-gray-400 hover:text-blue-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
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

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- ======================================================== --}}
            {{-- BARIS ATAS: KIRI (Info & Gambar) | KANAN (Aksi & Status) --}}
            {{-- ======================================================== --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                {{-- KIRI: Informasi Kendaraan, Detail & Gambar (2/3 Lebar) --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Card Info Utama & Detail --}}
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-xl text-white">{{ $wo->kendaraan->merek }} {{ $wo->kendaraan->model }}</h3>
                                <p class="text-blue-100 text-sm">Work Order #{{ $wo->id_wo }}</p>
                            </div>
                            <span class="px-3 py-1 bg-white/20 rounded-full text-white text-sm font-bold uppercase tracking-wider border border-blue-400 shadow-sm">
                                {{ $wo->kendaraan->nomor_polisi }}
                            </span>
                        </div>

                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Kolom Spesifikasi 1 --}}
                            <div>
                                <h4 class="font-bold text-gray-800 border-b-2 border-blue-500 pb-2 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1"></path></svg>
                                    Spesifikasi Umum
                                </h4>
                                <ul class="space-y-3 text-sm">
                                    <li class="flex items-center text-gray-600"><span class="w-24 text-gray-500 uppercase text-xs font-bold">Merek</span> <strong class="text-gray-800">{{ $wo->kendaraan->merek }}</strong></li>
                                    <li class="flex items-center text-gray-600"><span class="w-24 text-gray-500 uppercase text-xs font-bold">Model</span> <strong class="text-gray-800">{{ $wo->kendaraan->model }}</strong></li>
                                    <li class="flex items-center text-gray-600"><span class="w-24 text-gray-500 uppercase text-xs font-bold">Tahun</span> <strong class="text-gray-800">{{ $wo->kendaraan->tahun }}</strong></li>
                                    <li class="flex items-center text-gray-600"><span class="w-24 text-gray-500 uppercase text-xs font-bold">Bahan Bakar</span> <strong class="text-gray-800">{{ $wo->kendaraan->jenis_bahan_bakar }}</strong></li>
                                    <li class="flex items-center text-gray-600"><span class="w-24 text-gray-500 uppercase text-xs font-bold">Warna</span> <strong class="text-gray-800">{{ $wo->kendaraan->warna }}</strong></li>
                                </ul>
                            </div>

                            {{-- Kolom Spesifikasi 2 --}}
                            <div>
                                <h4 class="font-bold text-gray-800 border-b-2 border-blue-500 pb-2 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                    Identitas Mesin
                                </h4>
                                <ul class="space-y-3 text-sm">
                                    <li class="flex flex-col text-gray-600 mb-2">
                                        <span class="text-gray-500 uppercase text-xs font-bold mb-1">Nomor Rangka</span>
                                        <span class="font-mono bg-gray-100 px-2 py-1 rounded text-gray-800">{{ $wo->kendaraan->nomor_rangka ?? '-' }}</span>
                                    </li>
                                    <li class="flex flex-col text-gray-600">
                                        <span class="text-gray-500 uppercase text-xs font-bold mb-1">Nomor Mesin</span>
                                        <span class="font-mono bg-gray-100 px-2 py-1 rounded text-gray-800">{{ $wo->kendaraan->nomor_mesin ?? '-' }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Card Gambar Kendaraan --}}
                    @if ($wo->kendaraan && $wo->kendaraan->foto_kendaraan)
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-4">
                        <h4 class="font-bold text-gray-800 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16l4-4a3 3 0 014 0l4 4m-2-2l1-1a3 3 0 014 0l3 3m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Foto Kendaraan
                        </h4>
                        <img src="{{ asset('storage/' . $wo->kendaraan->foto_kendaraan) }}" class="w-full h-80 object-cover rounded-xl border border-gray-100 shadow-sm">
                    </div>
                    @endif
                </div>

                {{-- KANAN: Status, Aksi & Catatan Mekanik (1/3 Lebar) --}}
                <div class="space-y-6">

                    {{-- Status Badge --}}
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 text-center">
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-widest mb-2">Status Saat Ini</p>
                        <span class="inline-block px-6 py-2 rounded-lg text-sm font-bold uppercase tracking-wider
                            {{ $wo->status == 'antrian' ? 'bg-yellow-100 text-yellow-800 border border-yellow-300' : '' }}
                            {{ $wo->status == 'dikerjakan' ? 'bg-blue-100 text-blue-800 border border-blue-300' : '' }}
                            {{ $wo->status == 'selesai' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : '' }}
                            {{ $wo->status == 'ditolak' ? 'bg-red-100 text-red-800 border border-red-300' : '' }}">
                            {{ str_replace('_', ' ', $wo->status) }}
                        </span>
                        <div class="mt-4 pt-4 border-t flex justify-between text-xs text-gray-500">
                            <span>Tgl: <strong class="text-gray-800">{{ $wo->created_at->format('d/m/Y') }}</strong></span>
                            <span>Jam: <strong class="text-gray-800">{{ $wo->created_at->format('H:i') }}</strong></span>
                        </div>
                    </div>

                    {{-- Form Aksi (Tindakan) --}}
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                        <h5 class="font-bold text-lg text-blue-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Tindakan Mekanik
                        </h5>

                        @if ($wo->status == 'antrian')
                            <div class="space-y-3">
                                <form action="{{ route('mekanik.work-order.updateStatus', $wo->id_wo) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="dikerjakan">
                                    <button type="submit" class="w-full bg-emerald-500 text-white py-3 rounded-xl hover:bg-emerald-600 font-bold shadow transition">✅ Setujui (Mulai Servis)</button>
                                </form>
                                <form action="{{ route('mekanik.work-order.updateStatus', $wo->id_wo) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" class="w-full bg-red-50 text-red-600 border border-red-200 py-3 rounded-xl hover:bg-red-100 font-bold transition">❌ Tolak</button>
                                </form>
                            </div>
                        @elseif ($wo->status == 'dikerjakan')
                            <div class="space-y-3">
                                @if(!$wo->servis_completed)
                                <a href="{{ route('mekanik.work-order.edit', $wo->id_wo) }}" class="flex items-center justify-center w-full px-4 py-3 bg-yellow-400 text-yellow-900 rounded-xl hover:bg-yellow-500 shadow font-bold text-sm transition">
                                    🔧 Tambah Servis & Part
                                </a>
                                @endif
                            </div>
                        @else
                            <p class="text-sm text-gray-500 italic text-center">Work Order telah ditutup.</p>
                        @endif
                    </div>

                    {{-- Catatan Mekanik --}}
                    @if ($wo->status == 'dikerjakan' || $wo->catatan_mekanik)
                    <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-200">
                        <h4 class="font-bold text-indigo-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Catatan Mekanik
                        </h4>

                        @if($wo->status == 'dikerjakan')
                            <form action="{{ route('mekanik.work-order.updateCatatan', $wo->id_wo) }}" method="POST">
                                @csrf @method('PUT')
                                <textarea name="catatan_mekanik" rows="3" placeholder="Tulis catatan perbaikan..." class="w-full border border-indigo-300 rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 text-sm mb-3">{{ $wo->catatan_mekanik }}</textarea>
                                <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-xl hover:bg-indigo-700 font-bold text-sm shadow transition">💾 Simpan Catatan</button>
                            </form>
                        @else
                            <p class="text-sm text-gray-700 italic bg-white p-3 rounded-lg border border-indigo-100">"{{ $wo->catatan_mekanik }}"</p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            {{-- ======================================================== --}}
            {{-- BARIS TENGAH: KELUHAN PELANGGAN (Full Width)           --}}
            {{-- ======================================================== --}}
            <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-200">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-6">
                    <h4 class="font-bold text-xl text-gray-800 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                        Keluhan Pelanggan
                    </h4>
                    <div class="text-right flex items-center">
                        <div class="w-10 h-10 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center font-bold text-lg mr-3">
                            {{ substr($wo->kendaraan->user->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="text-left">
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Customer</p>
                            <p class="font-semibold text-gray-800">{{ $wo->kendaraan->user->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="relative pl-10 pr-4">
                    <span class="absolute left-0 top-0 text-6xl text-gray-200 font-serif leading-none mt-[-10px]">“</span>
                    <p class="text-gray-700 italic leading-relaxed text-lg relative z-10">{{ $wo->keluhan ?? 'Tidak ada deskripsi keluhan.' }}</p>
                </div>
            </div>

            {{-- ======================================================== --}}
            {{-- BARIS BAWAH: LAYANAN (Kiri) | SPAREPART (Kanan)        --}}
            {{-- ======================================================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- Daftar Layanan Servis --}}
                <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden flex flex-col">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                        <h4 class="font-bold text-lg text-white flex items-center"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                        Layanan Servis ({{ $wo->detailServis->count() }})</h4>
                    </div>
                    <div class="p-6 flex-1 bg-white">
                        @forelse($wo->detailServis as $servis)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-b-0">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $servis->jenisServis->nama_servis }}</p>
                                    @if ($servis->keterangan)
                                        <p class="text-sm text-gray-500">{{ $servis->keterangan }}</p>
                                    @endif
                                </div>
                                <span class="font-bold text-emerald-600">Rp {{ number_format($servis->harga_jasa) }}</span>
                            </div>
                        @empty
                            <div class="text-center py-10 text-gray-400 italic">Belum ada layanan servis ditambahkan.</div>
                        @endforelse
                    </div>
                </div>

                {{-- Daftar Sparepart --}}
                <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden flex flex-col">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                        <h4 class="font-bold text-lg text-white flex items-center"><svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Sparepart Digunakan ({{ $wo->penggunaanSparepart->count() }})</h4>
                    </div>
                    <div class="p-6 flex-1 bg-white">
                        @forelse($wo->penggunaanSparepart as $part)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-b-0">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $part->sparepart->nama_part }}</p>
                                    <p class="text-sm text-gray-500">x{{ $part->jumlah }} @ Rp {{ number_format($part->harga_satuan) }}</p>
                                </div>
                                <span class="font-bold text-blue-600">Rp {{ number_format($part->subtotal) }}</span>
                            </div>
                        @empty
                            <div class="text-center py-10 text-gray-400 italic">Belum ada sparepart yang digunakan.</div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
