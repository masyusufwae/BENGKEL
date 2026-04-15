@extends('admin.layouts.app')
@section('title', 'Detail Sparepart')
@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">Detail Sparepart</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><strong>Kode Part:</strong> {{ $sparepart->kode_part }}</div>
                    <div><strong>Nama Part:</strong> {{ $sparepart->nama_part }}</div>
                    <div><strong>Satuan:</strong> {{ $sparepart->satuan }}</div>
                    <div><strong>Stok:</strong> {{ $sparepart->stok }}</div>
                    <div><strong>Stok Minimum:</strong> {{ $sparepart->stok_minimum }}</div>
                    <div><strong>Harga Beli:</strong> Rp {{ number_format($sparepart->harga_beli, 0, ',', '.') }}</div>
                    <div><strong>Harga Jual:</strong> Rp {{ number_format($sparepart->harga_jual, 0, ',', '.') }}</div>
                    <div><strong>Dibuat:</strong> {{ $sparepart->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('admin.sparepart.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection