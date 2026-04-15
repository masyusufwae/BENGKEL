@extends('admin.layouts.app')
@section('title', 'Data Jenis Servis')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold">Jenis Servis</h2>
                    <a href="{{ route('admin.servis.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">+ Tambah</a>
                </div>
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4">{{ session('success') }}</div>
                @endif
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border">Nama Servis</th>
                                <th class="py-2 px-4 border">Kategori</th>
                                <th class="py-2 px-4 border">Estimasi (menit)</th>
                                <th class="py-2 px-4 border">Harga Jasa</th>
                                <th class="py-2 px-4 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($servis as $s)
                            <tr>
                                <td class="py-2 px-4 border">{{ $s->nama_servis }}</td>
                                <td class="py-2 px-4 border">{{ ucfirst($s->kategori) }}</td>
                                <td class="py-2 px-4 border">{{ $s->estimasi_waktu }}</td>
                                <td class="py-2 px-4 border">Rp {{ number_format($s->harga_jasa, 0, ',', '.') }}</td>
                                <td class="py-2 px-4 border">
                                    <a href="{{ route('admin.servis.show', $s->id_jenis) }}" class="text-green-600 mr-2">Detail</a>
                                    <a href="{{ route('admin.servis.edit', $s->id_jenis) }}" class="text-blue-600 mr-2">Edit</a>
                                    <form action="{{ route('admin.servis.destroy', $s->id_jenis) }}" method="POST" class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin hapus?')" class="text-red-600">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $servis->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection