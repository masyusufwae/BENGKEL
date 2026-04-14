@extends('layouts.app')

@section('title', 'Tambah Kendaraan - Pelanggan')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('customer.vehicles.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    ← Kembali
                </a>
                <h1 class="text-3xl font-bold text-gray-900 mt-4">Daftar Kendaraan Baru</h1>
                <p class="text-gray-600 mt-2">Tambahkan kendaraan untuk mulai service</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('customer.vehicles.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Nomor Polisi -->
                    <div>
                        <label for="nomor_polisi" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Polisi *
                        </label>
                        <input type="text" id="nomor_polisi" name="nomor_polisi"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Contoh: B 1234 ABC"
                            value="{{ old('nomor_polisi') }}"
                            required>
                        @error('nomor_polisi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Merek & Model -->
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="merek" class="block text-sm font-medium text-gray-700 mb-2">
                                Merek *
                            </label>
                            <input type="text" id="merek" name="merek"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contoh: Honda"
                                value="{{ old('merek') }}"
                                required>
                            @error('merek')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700 mb-2">
                                Model *
                            </label>
                            <input type="text" id="model" name="model"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contoh: Civic"
                                value="{{ old('model') }}"
                                required>
                            @error('model')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tahun & Warna -->
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun Produksi *
                            </label>
                            <input type="number" id="tahun" name="tahun" min="1950"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contoh: 2020"
                                value="{{ old('tahun') }}"
                                required>
                            @error('tahun')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="warna" class="block text-sm font-medium text-gray-700 mb-2">
                                Warna
                            </label>
                            <input type="text" id="warna" name="warna"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contoh: Hitam"
                                value="{{ old('warna') }}">
                        </div>
                    </div>

                    <!-- Nomor Rangka & Mesin -->
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="nomor_rangka" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Rangka
                            </label>
                            <input type="text" id="nomor_rangka" name="nomor_rangka"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Nomor rangka kendaraan"
                                value="{{ old('nomor_rangka') }}">
                        </div>
                        <div>
                            <label for="nomor_mesin" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Mesin
                            </label>
                            <input type="text" id="nomor_mesin" name="nomor_mesin"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Nomor mesin kendaraan"
                                value="{{ old('nomor_mesin') }}">
                        </div>
                    </div>

                    <!-- Jenis Bahan Bakar -->
                    <div>
                        <label for="jenis_bahan_bakar" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Bahan Bakar
                        </label>
                        <select id="jenis_bahan_bakar" name="jenis_bahan_bakar"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih jenis bahan bakar</option>
                            <option value="Bensin" {{ old('jenis_bahan_bakar') == 'Bensin' ? 'selected' : '' }}>Bensin</option>
                            <option value="Diesel" {{ old('jenis_bahan_bakar') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="Hybrid" {{ old('jenis_bahan_bakar') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                            <option value="Listrik" {{ old('jenis_bahan_bakar') == 'Listrik' ? 'selected' : '' }}>Listrik</option>
                        </select>
                    </div>

                    <!-- Form Actions -->
                    <div class="border-t border-gray-200 pt-6 flex gap-4">
                        <a href="{{ route('customer.vehicles.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                            Daftar Kendaraan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
