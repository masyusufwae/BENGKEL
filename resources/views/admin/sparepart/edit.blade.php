@extends('admin.layouts.app')
@section('title', 'Edit Sparepart')
@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">Edit Sparepart</h2>
                <form action="{{ route('admin.sparepart.update', $sparepart->id_part) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kode Part</label>
                            <input type="text" name="kode_part" value="{{ old('kode_part', $sparepart->kode_part) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Part</label>
                            <input type="text" name="nama_part" value="{{ old('nama_part', $sparepart->nama_part) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Satuan</label>
                            <input type="text" name="satuan" value="{{ old('satuan', $sparepart->satuan) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stok</label>
                            <input type="number" name="stok" value="{{ old('stok', $sparepart->stok) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stok Minimum</label>
                            <input type="number" name="stok_minimum" value="{{ old('stok_minimum', $sparepart->stok_minimum) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Harga Beli</label>
                            <input type="number" step="0.01" name="harga_beli" value="{{ old('harga_beli', $sparepart->harga_beli) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Harga Jual</label>
                            <input type="number" step="0.01" name="harga_jual" value="{{ old('harga_jual', $sparepart->harga_jual) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('admin.sparepart.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded mr-2">Batal</a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection