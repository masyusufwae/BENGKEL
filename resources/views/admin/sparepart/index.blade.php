@extends('admin.layouts.app')
@section('title', 'Data Sparepart')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold">Sparepart</h2>
                    <a href="{{ route('admin.sparepart.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">+ Tambah</a>
                </div>
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4">{{ session('success') }}</div>
                @endif
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border">Kode</th>
                                <th class="py-2 px-4 border">Nama Part</th>
                                <th class="py-2 px-4 border">Satuan</th>
                                <th class="py-2 px-4 border">Stok</th>
                                <th class="py-2 px-4 border">Harga Jual</th>
                                <th class="py-2 px-4 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($spareparts as $sp)
                            <tr>
                                <td class="py-2 px-4 border">{{ $sp->kode_part }}</td>
                                <td class="py-2 px-4 border">{{ $sp->nama_part }}</td>
                                <td class="py-2 px-4 border">{{ $sp->satuan }}</td>
                                <td class="py-2 px-4 border">{{ $sp->stok }}</td>
                                <td class="py-2 px-4 border">Rp {{ number_format($sp->harga_jual, 0, ',', '.') }}</td>
                                <td class="py-2 px-4 border">
                                    <a href="{{ route('admin.sparepart.show', $sp->id_part) }}" class="text-green-600 mr-2">Detail</a>
                                    <a href="{{ route('admin.sparepart.edit', $sp->id_part) }}" class="text-blue-600 mr-2">Edit</a>
                                    <form action="{{ route('admin.sparepart.destroy', $sp->id_part) }}" method="POST" class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin hapus?')" class="text-red-600">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-4">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $spareparts->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection