@extends('mekanik.layouts.app')
@section('content')
    {{-- Header --}}
    <header class="bg-white py-6 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">

            <h2 class="font-bold text-2xl text-black">
                Edit Sparepart: {{ $sparepart->nama_part }}
            </h2>
        </div>
    </header>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-8 max-w-2xl mx-auto">
                <form action="{{ route('mekanik.sparepart.update', $sparepart->id_part) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kode Part <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="kode_part" value="{{ old('kode_part', $sparepart->kode_part) }}"
                                required
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 @error('kode_part') border-red-500 @enderror">
                            @error('kode_part')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Sparepart <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_part" value="{{ old('nama_part', $sparepart->nama_part) }}"
                                required
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 @error('nama_part') border-red-500 @enderror">
                            @error('nama_part')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    {{-- Upload Gambar --}}
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 mb-6">
                        <h5 class="font-bold text-gray-800 mb-4">Upload Gambar</h5>

                        {{-- Preview gambar lama --}}
                        @if ($sparepart->gambar)
                            <img src="{{ asset('storage/' . $sparepart->gambar) }}" class="w-32 mb-3 rounded-lg shadow">
                        @endif

                        <input type="file" name="gambar" class="w-full border rounded-lg px-3 py-2 mb-3">

                        @error('gambar')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Satuan</label>
                            <input type="text" name="satuan" value="{{ old('satuan', $sparepart->satuan) }}"
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Stok Minimum</label>
                            <input type="number" name="stok_minimum"
                                value="{{ old('stok_minimum', $sparepart->stok_minimum) }}" min="0"
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Stok Saat ini</label>
                            <input type="number" name="stok" value="{{ old('stok', $sparepart->stok) }}" min="0"
                                required
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 @error('stok') border-red-500 @enderror">
                            @error('stok')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Harga Beli <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="harga_beli" value="{{ old('harga_beli', $sparepart->harga_beli) }}"
                                min="0" required class="w-full border rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga Jual <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="harga_jual" value="{{ old('harga_jual', $sparepart->harga_jual) }}"
                                min="0" required
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 @error('harga_jual') border-red-500 @enderror">
                            @error('harga_jual')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                            class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-medium shadow">
                            Update Sparepart
                        </button>
                        <a href="{{ route('mekanik.sparepart.index') }}"
                            class="flex-1 bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 font-medium text-center shadow">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
