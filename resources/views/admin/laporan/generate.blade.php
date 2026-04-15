@extends('admin.layouts.app')
@section('title', 'Hasil Laporan Servis')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Laporan Servis</h2>
                    <button onclick="window.print()" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">Cetak Laporan</button>
                </div>
                <div class="mb-6"><strong>Periode:</strong> {{ $dari->format('d/m/Y') }} - {{ $sampai->format('d/m/Y') }}</div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-blue-100 p-4 rounded"><p class="text-sm">Total WO</p><p class="text-2xl font-bold">{{ $totalWO }}</p></div>
                    <div class="bg-green-100 p-4 rounded"><p class="text-sm">Total Pendapatan</p><p class="text-2xl font-bold">Rp {{ number_format($totalPendapatan,0,',','.') }}</p></div>
                    <div class="bg-yellow-100 p-4 rounded"><p class="text-sm">WO Selesai</p><p class="text-2xl font-bold">{{ $totalSelesai }}</p></div>
                    <div class="bg-purple-100 p-4 rounded"><p class="text-sm">WO Diserahkan</p><p class="text-2xl font-bold">{{ $totalDiserahkan }}</p></div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
                        <thead><tr class="bg-gray-100"><th class="py-2 px-4 border">No WO</th><th class="py-2 px-4 border">Tanggal Masuk</th><th class="py-2 px-4 border">Customer</th><th class="py-2 px-4 border">Mekanik</th><th class="py-2 px-4 border">Status</th><th class="py-2 px-4 border">Total</th></tr></thead>
                        <tbody>
                            @forelse($laporan as $wo)
                            <tr>
                                <td class="py-2 px-4 border">{{ $wo->nomor_wo }}</td>
                                <td class="py-2 px-4 border">{{ $wo->tanggal_masuk->format('d/m/Y') }}</td>
                                <td class="py-2 px-4 border">{{ $wo->kendaraan->nama_pelanggan ?? '-' }}</td>
                                <td class="py-2 px-4 border">{{ $wo->mekanik->nama_mekanik ?? '-' }}</td>
                                <td class="py-2 px-4 border">{{ ucfirst($wo->status) }}</td>
                                <td class="py-2 px-4 border">Rp {{ number_format($wo->totalHarga,0,',','.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-4">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection