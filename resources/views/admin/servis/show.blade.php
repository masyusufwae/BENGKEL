@extends('admin.layouts.app')
@section('title', 'Detail Jenis Servis')
@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">Detail Jenis Servis</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><strong>Nama Servis:</strong> {{ $servis->nama_servis }}</div>
                    <div><strong>Kategori:</strong> {{ ucfirst($servis->kategori) }}</div>
                    <div><strong>Estimasi Waktu:</strong> {{ $servis->estimasi_waktu }} menit</div>
                    <div><strong>Harga Jasa:</strong> Rp {{ number_format($servis->harga_jasa, 0, ',', '.') }}</div>
                    <div class="md:col-span-2"><strong>Deskripsi:</strong> {{ $servis->deskripsi ?? '-' }}</div>
                    <div><strong>Dibuat:</strong> {{ $servis->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('admin.servis.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection