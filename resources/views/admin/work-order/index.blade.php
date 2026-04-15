@extends('admin.layouts.app')
@section('title', 'Data Work Order')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold">Work Order</h2>
                    <a href="{{ route('admin.work-order.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">+ Buat WO</a>
                </div>
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4">{{ session('success') }}</div>
                @endif
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border">No WO</th>
                                <th class="py-2 px-4 border">Customer</th>
                                <th class="py-2 px-4 border">Kendaraan</th>
                                <th class="py-2 px-4 border">Mekanik</th>
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
                                <td class="py-2 px-4 border">{{ $wo->kendaraan->no_plat ?? '-' }}</td>
                                <td class="py-2 px-4 border">{{ $wo->mekanik->nama_mekanik ?? '-' }}</td>
                                <td class="py-2 px-4 border">
                                    <span class="px-2 py-1 rounded text-xs 
                                        @if($wo->status == 'antrian') bg-yellow-100 text-yellow-800
                                        @elseif($wo->status == 'dikerjakan') bg-blue-100 text-blue-800
                                        @elseif($wo->status == 'menunggu part') bg-orange-100 text-orange-800
                                        @elseif($wo->status == 'selesai') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($wo->status) }}
                                    </span>
                                </td>
                                <td class="py-2 px-4 border">Rp {{ number_format($wo->totalHarga, 0, ',', '.') }}</td>
                                <td class="py-2 px-4 border">
                                    <a href="{{ route('admin.work-order.show', $wo->id_wo) }}" class="text-green-600 mr-2">Detail</a>
                                    <a href="{{ route('admin.work-order.edit', $wo->id_wo) }}" class="text-blue-600 mr-2">Edit</a>
                                    <form action="{{ route('admin.work-order.destroy', $wo->id_wo) }}" method="POST" class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin hapus?')" class="text-red-600">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center py-4">Tidak ada data</td></tr>
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