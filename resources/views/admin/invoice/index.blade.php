@extends('admin.layouts.app')
@section('title', 'Cetak Invoice')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">Pilih Work Order untuk Cetak Invoice</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border">No WO</th>
                                <th class="py-2 px-4 border">Customer</th>
                                <th class="py-2 px-4 border">Tanggal Masuk</th>
                                <th class="py-2 px-4 border">Status</th>
                                <th class="py-2 px-4 border">Total</th>
                                <th class="py-2 px-4 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($workOrders as $wo)
                            <tr>
                                <td class="py-2 px-4 border">{{ $wo->nomor_wo }}</td>
                                <td class="py-2 px-4 border">{{ $wo->kendaraan->nama_pelanggan ?? '-' }}</td>
                                <td class="py-2 px-4 border">{{ $wo->tanggal_masuk->format('d/m/Y') }}</td>
                                <td class="py-2 px-4 border">{{ ucfirst($wo->status) }}</td>
                                <td class="py-2 px-4 border">Rp {{ number_format($wo->totalHarga,0,',','.') }}</td>
                                <td class="py-2 px-4 border">
                                    <a href="{{ route('admin.invoice.cetak', $wo->id_wo) }}" target="_blank" class="bg-blue-500 text-white px-3 py-1 rounded">Cetak Invoice</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-4">Tidak ada WO yang siap cetak</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $workOrders->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection