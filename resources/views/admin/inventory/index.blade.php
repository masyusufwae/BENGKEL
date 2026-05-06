@extends('admin.layouts.app')
@section('title', 'Mutasi Barang')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white shadow-sm sm:rounded-lg p-5">
                <p class="text-sm text-gray-500">Nilai Barang Masuk</p>
                <p class="text-2xl font-bold text-green-700">Rp {{ number_format($summary['masuk'], 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400">{{ $summary['jumlah_masuk'] }} unit</p>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg p-5">
                <p class="text-sm text-gray-500">Nilai Barang Keluar</p>
                <p class="text-2xl font-bold text-red-700">Rp {{ number_format($summary['keluar'], 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400">{{ $summary['jumlah_keluar'] }} unit</p>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg p-5">
                <p class="text-sm text-gray-500">Total Sparepart</p>
                <p class="text-2xl font-bold text-slate-900">{{ $spareparts->count() }}</p>
                <p class="text-xs text-gray-400">Data item aktif</p>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg p-5">
                <p class="text-sm text-gray-500">Saldo Mutasi</p>
                <p class="text-2xl font-bold text-blue-700">Rp {{ number_format($summary['masuk'] - $summary['keluar'], 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400">Masuk dikurangi keluar</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg xl:col-span-1">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Input Mutasi Barang</h2>

                    <form action="{{ route('admin.inventory.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sparepart</label>
                            <select name="id_part" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">Pilih Sparepart</option>
                                @foreach($spareparts as $part)
                                    <option value="{{ $part->id_part }}">{{ $part->kode_part }} - {{ $part->nama_part }}</option>
                                @endforeach
                            </select>
                            @error('id_part') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis</label>
                            <select name="jenis" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="masuk">Barang Masuk</option>
                                <option value="keluar">Barang Keluar</option>
                            </select>
                            @error('jenis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                            <input type="number" name="jumlah" min="1" value="{{ old('jumlah', 1) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @error('jumlah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Harga Satuan (opsional)</label>
                            <input type="number" step="0.01" name="harga_satuan" value="{{ old('harga_satuan') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                            <textarea name="keterangan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('keterangan') }}</textarea>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            Simpan Mutasi
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg xl:col-span-2">
                <div class="p-6">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <h2 class="text-xl font-bold">Riwayat Mutasi Barang</h2>
                        <span class="text-sm text-gray-500">Pengeluaran dari work order tercatat otomatis saat sparepart dipakai.</span>
                    </div>

                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4">{{ session('error') }}</div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-2 px-4 border">Tanggal</th>
                                    <th class="py-2 px-4 border">Sparepart</th>
                                    <th class="py-2 px-4 border">Jenis</th>
                                    <th class="py-2 px-4 border">Jumlah</th>
                                    <th class="py-2 px-4 border">Subtotal</th>
                                    <th class="py-2 px-4 border">Sumber</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($movements as $movement)
                                    <tr>
                                        <td class="py-2 px-4 border">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="py-2 px-4 border">{{ $movement->sparepart?->nama_part ?? '-' }}</td>
                                        <td class="py-2 px-4 border">
                                            <span class="px-2 py-1 rounded text-white text-xs {{ $movement->jenis === 'masuk' ? 'bg-green-600' : 'bg-red-600' }}">
                                                {{ strtoupper($movement->jenis) }}
                                            </span>
                                        </td>
                                        <td class="py-2 px-4 border">{{ $movement->jumlah }}</td>
                                        <td class="py-2 px-4 border">Rp {{ number_format($movement->subtotal,0,',','.') }}</td>
                                        <td class="py-2 px-4 border">
                                            <div class="text-sm">
                                                <div>{{ $movement->sumber ?? '-' }}</div>
                                                @if($movement->workOrder)
                                                    <div class="text-gray-500">WO {{ $movement->workOrder->nomor_wo }}</div>
                                                    <div class="text-gray-500">{{ $movement->workOrder->mekanik?->nama_mekanik ?? '-' }}</div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">Belum ada mutasi barang</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $movements->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
