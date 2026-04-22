@extends('mekanik.layouts.app')
@section('content')
    {{-- Header --}}
    <header class="bg-white py-6 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-bold text-2xl text-black">
                Servis Work Order #{{ $wo->nomor_wo }}
            </h2>
        </div>
    </header>

    {{-- Success Alert --}}
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        </div>
    @endif


    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">



            {{-- ===================== --}}
            {{-- Servis WORK ORDER DATA --}}
            {{-- ===================== --}}
            <div class="md:col-span-3 bg-white p-6 rounded-xl shadow border">
                <h3 class="font-bold text-lg mb-6">Servis Data Work Order</h3>

                <form action="{{ route('mekanik.work-order.servis.store', $wo->id_wo) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    {{-- DATA BASIC WO --}}
                    {{-- DATA BASIC WO --}}
                    <div class="bg-white p-8 rounded-2xl shadow-lg border">
                        <h4 class="font-bold text-xl mb-6 text-gray-800 border-b-2 border-blue-500 pb-3">Data Work Order
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Nomor WO (Readonly) --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WO</label>
                                <input type="text" name="nomor_wo" value="{{ old('nomor_wo', $wo->nomor_wo) }}"
                                    class="w-full border rounded-xl px-4 py-3 bg-gray-100 cursor-not-allowed" readonly>
                                @error('nomor_wo')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Status (Disabled) --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status_disabled"
                                    class="w-full border rounded-xl px-4 py-3 bg-gray-100 cursor-not-allowed" disabled>
                                    <option value="antrian" {{ old('status', $wo->status) == 'antrian' ? 'selected' : '' }}>
                                        Antrian</option>
                                    <option value="dikerjakan"
                                        {{ old('status', $wo->status) == 'dikerjakan' ? 'selected' : '' }}>Dikerjakan
                                    </option>
                                    <option value="selesai" {{ old('status', $wo->status) == 'selesai' ? 'selected' : '' }}>
                                        Selesai</option>
                                    <option value="ditolak" {{ old('status', $wo->status) == 'ditolak' ? 'selected' : '' }}>
                                        Ditolak</option>
                                </select>
                                {{-- Hidden input agar nilai status tetap terkirim ke server --}}
                                <input type="hidden" name="status" value="{{ $wo->status }}">
                            </div>

                            {{-- Keluhan (Readonly) --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Keluhan</label>
                                <textarea name="keluhan" rows="3" class="w-full border rounded-xl px-4 py-3 bg-gray-100 cursor-not-allowed"
                                    readonly>{{ old('keluhan', $wo->keluhan) }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Kendaraan</label>
                                <div
                                    class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                                    @if ($wo->kendaraan->foto_kendaraan)
                                        <img src="{{ asset('storage/' . $wo->kendaraan->foto_kendaraan) }}"
                                            alt="Foto Kendaraan"
                                            class="w-20 h-20 object-cover rounded-lg shadow-md flex-shrink-0">
                                    @else
                                        <div
                                            class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <span class="text-gray-500 text-xs">No photo</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Estimasi Selesai (Readonly) --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estimasi Selesai</label>
                                <input type="date" name="estimasi_selesai"
                                    value="{{ old('estimasi_selesai', $wo->estimasi_selesai ? $wo->estimasi_selesai->format('Y-m-d') : '') }}"
                                    class="w-full border rounded-xl px-4 py-3 bg-gray-100 cursor-not-allowed" readonly>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Mekanik</label>
                                <textarea name="catatan_mekanik" rows="4"
                                    class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500">{{ old('catatan_mekanik', $wo->catatan_mekanik) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- JASA SERVIS --}}
                    <div class="bg-gradient-to-r from-emerald-50 to-green-50 p-8 rounded-2xl border-2 border-emerald-200">
                        <h4 class="font-bold text-2xl mb-6 text-emerald-800 flex items-center">
                            <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                </path>
                            </svg>
                            Pilih Jenis Servis
                        </h4>

                        <div class="space-y-4">
                            @php
                                $kategori = ['ringan' => [], 'sedang' => [], 'berat' => []];
                                foreach ($jenisServis as $servis) {
                                    $kategori[$servis->kategori][] = $servis;
                                }
                            @endphp

                            @foreach (['ringan' => '🟢 Ringan', 'sedang' => '🟡 Sedang', 'berat' => '🔴 Berat'] as $kat => $label)
                                <details class="bg-white rounded-lg border border-gray-200 shadow-sm">
                                    <summary
                                        class="px-4 py-3 font-semibold text-gray-700 cursor-pointer hover:bg-gray-50 rounded-lg flex justify-between items-center list-none">
                                        <span>{{ $label }} <span
                                                class="text-xs text-gray-500">({{ count($kategori[$kat]) }}
                                                layanan)</span></span>
                                        <svg class="w-4 h-4 text-gray-500 transition-transform group-open:rotate-180"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </summary>
                                    <div class="p-3 border-t border-gray-100 max-h-64 overflow-y-auto">
                                        @if (!empty($kategori[$kat]))
                                            <div class="space-y-2">
                                                @foreach ($kategori[$kat] as $servis)
                                                    <label
                                                        class="flex items-start p-2 rounded-lg hover:bg-emerald-50 transition cursor-pointer">
                                                        <input type="checkbox" name="jenis_servis[]"
                                                            value="{{ $servis->id_jenis }}"
                                                            class="rounded w-4 h-4 text-emerald-600 mr-3 mt-0.5 focus:ring-emerald-500">
                                                        <div class="flex-1">
                                                            <div class="font-medium text-sm text-gray-800">
                                                                {{ $servis->nama_servis }}</div>
                                                            <div class="text-xs text-gray-500">Rp
                                                                {{ number_format($servis->harga_jasa) }} •
                                                                {{ $servis->deskripsi ?? '' }}</div>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-6 text-gray-400 text-sm">Tidak ada layanan
                                                {{ strtolower($label) }}</div>
                                        @endif
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    </div>

                    {{-- SPAREPART --}}
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-8 rounded-2xl border-2 border-blue-200">
                        <h4 class="font-bold text-2xl mb-6 text-blue-800 flex items-center">
                            <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Pilih Sparepart
                        </h4>

                        <div id="sparepart-container" class="space-y-4">
                            {{-- Baris Input Sparepart --}}
                            <div
                                class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end bg-white p-4 rounded-xl shadow-sm border border-blue-100">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sparepart</label>
                                    <select name="sparepart_id[]"
                                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                                        <option value="">-- Pilih Sparepart --</option>
                                        @foreach ($spareparts as $part)
                                            <option value="{{ $part->id_part }}">
                                                {{ $part->nama_part }} (Stok: {{ $part->stok }}) — Rp
                                                {{ number_format($part->harga_jual) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                                    <input type="number" name="sparepart_qty[]" min="1" value="0"
                                        class="w-full border rounded-lg px-3 py-2 text-center" placeholder="0">
                                </div>
                            </div>

                            {{-- Anda bisa menambahkan script JS nantinya untuk "Tambah Baris" jika ingin lebih dari satu sparepart --}}
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-emerald-600 to-green-600 text-black px-8 py-4 rounded-2xl text-lg font-bold hover:from-emerald-700 hover:to-green-700 shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1">
                            🚀 Simpan Data & Servis
                        </button>
                        <a href="{{ route('mekanik.work-order.index') }}"
                            class="flex-1 bg-gray-500 text-white px-8 py-4 rounded-2xl text-lg font-bold hover:bg-gray-600 text-center transition">
                            ← Kembali
                        </a>
                    </div>
                </form>
            </div>


        </div>
    </div>
@endsection
