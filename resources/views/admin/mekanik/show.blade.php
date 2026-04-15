@extends('admin.layouts.app')
@section('title', 'Detail Mekanik')
@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">Detail Mekanik</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><strong>Nama:</strong> {{ $mekanik->nama_mekanik }}</div>
                    <div><strong>NIP:</strong> {{ $mekanik->nip ?? '-' }}</div>
                    <div><strong>Spesialisasi:</strong> {{ $mekanik->spesialisasi ?? '-' }}</div>
                    <div><strong>Jam Masuk:</strong> {{ $mekanik->jam_masuk ?? '-' }}</div>
                    <div><strong>Jam Keluar:</strong> {{ $mekanik->jam_keluar ?? '-' }}</div>
                    <div><strong>Status:</strong> {{ ucfirst($mekanik->status) }}</div>
                    <div><strong>Dibuat:</strong> {{ $mekanik->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('admin.mekanik.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection