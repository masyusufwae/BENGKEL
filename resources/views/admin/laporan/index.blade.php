@extends('admin.layouts.app')
@section('title', 'Laporan Servis')
@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between gap-4 flex-wrap mb-6">
                    <div>
                        <h2 class="text-2xl font-bold">Generate Laporan Servis</h2>
                        <p class="text-sm text-gray-500 mt-1">Filter per periode atau per mekanik, lalu lihat ringkasan pendapatan dan kalender servis.</p>
                    </div>
                    <a href="{{ route('admin.laporan.calendar') }}" class="bg-slate-900 hover:bg-slate-700 text-white px-4 py-2 rounded">
                        Buka Kalender Servis
                    </a>
                </div>

                <form action="{{ route('admin.laporan.generate') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                            <input type="date" name="dari_tanggal" value="{{ old('dari_tanggal', now()->startOfMonth()->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('dari_tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                            <input type="date" name="sampai_tanggal" value="{{ old('sampai_tanggal', now()->endOfMonth()->format('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('sampai_tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mekanik</label>
                            <select name="id_mekanik" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="" {{ old('id_mekanik') === null || old('id_mekanik') === '' ? 'selected' : '' }}>Semua Mekanik</option>
                                @foreach($mekaniks as $mekanik)
                                    <option value="{{ $mekanik->id_mekanik }}" {{ (string) old('id_mekanik') === (string) $mekanik->id_mekanik ? 'selected' : '' }}>{{ $mekanik->nama_mekanik }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                            Generate Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Rekap Cepat</h3>
                <p class="text-sm text-gray-600">Laporan mencakup total WO, pendapatan, dan rincian servis per mekanik untuk periode yang dipilih.</p>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Mutasi Barang</h3>
                <p class="text-sm text-gray-600">Gunakan menu barang masuk/keluar untuk mencatat stok pembelian dan pengurangan dari pekerjaan servis.</p>
            </div>
        </div>
    </div>
</div>
@endsection
