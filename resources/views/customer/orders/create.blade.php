@extends('customer.layouts.app')

@section('title', 'Pesan Service - Pelanggan')

@section('page-content')
<div class="mb-8">
    <a href="{{ route('customer.orders.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
        ← Kembali
    </a>
                <h1 class="text-3xl font-bold text-gray-900 mt-4">Pesan Service</h1>
                <p class="text-gray-600 mt-2">Buat pesanan service untuk kendaraan Anda</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow p-6">
                @if($kendaraan->count() > 0)
                    <form action="{{ route('customer.orders.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Pilih Kendaraan -->
                        <div>
                            <label for="id_kendaraan" class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Kendaraan *
                            </label>
                            <select id="id_kendaraan" name="id_kendaraan"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                required>
                                <option value="">-- Pilih Kendaraan --</option>
                                @foreach($kendaraan as $k)
                                    <option value="{{ $k->id_kendaraan }}" {{ old('id_kendaraan') == $k->id_kendaraan ? 'selected' : '' }}>
                                        {{ $k->nomor_polisi }} - {{ $k->merek }} {{ $k->model }} ({{ $k->tahun }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kendaraan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Keluhan/Deskripsi Service -->
                        <div>
                            <label for="keluhan" class="block text-sm font-medium text-gray-700 mb-2">
                                Keluhan / Deskripsi Service *
                            </label>
                            <textarea id="keluhan" name="keluhan" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Deskripsikan keluhan atau jenis service yang diinginkan..."
                                required>{{ old('keluhan') }}</textarea>
                            <p class="text-gray-500 text-sm mt-2">Contoh: Service rutin, Ganti oli, Perbaikan mesin, AC tidak dingin, dll</p>
                            @error('keluhan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Info Layanan -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="font-semibold text-blue-900 mb-3">📋 Informasi Layanan</h3>
                            <ul class="space-y-2 text-sm text-blue-800">
                                <li>✓ Estimasi waktu service akan dikonfirmasi oleh mekanik</li>
                                <li>✓ Anda akan menerima notifikasi untuk setiap perubahan status</li>
                                <li>✓ Biaya akan ditentukan setelah mekanik mengecek kendaraan</li>
                                <li>✓ Jam operasional bengkel: 07:00 - 17:00 (Senin - Sabtu)</li>
                            </ul>
                        </div>

                        <!-- Form Actions -->
                        <div class="border-t border-gray-200 pt-6 flex gap-4">
                            <a href="{{ route('customer.orders.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                                Pesan Service
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9-7V5L12 12l-9-7v7l9 7z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Kendaraan</h3>
                        <p class="text-gray-600 mb-6">Silakan daftar kendaraan terlebih dahulu sebelum memesan service</p>
                        <a href="{{ route('customer.vehicles.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Daftar Kendaraan
                        </a>
                    </div>
                @endif
            </div>
@endsection
