@extends('admin.layouts.app')
@section('title', 'Data Mekanik')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold">Data Mekanik</h2>
                    <a href="{{ route('admin.mekanik.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">+ Tambah</a>
                </div>
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4">{{ session('success') }}</div>
                @endif
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border">Nama</th>
                                <th class="py-2 px-4 border">NIP</th>
                                <th class="py-2 px-4 border">Spesialisasi</th>
                                <th class="py-2 px-4 border">Jam Kerja</th>
                                <th class="py-2 px-4 border">Status</th>
                                <th class="py-2 px-4 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mekaniks as $m)
                            <tr>
                                <td class="py-2 px-4 border">{{ $m->nama_mekanik }}</td>
                                <td class="py-2 px-4 border">{{ $m->nip ?? '-' }}</td>
                                <td class="py-2 px-4 border">{{ $m->spesialisasi ?? '-' }}</td>
                                <td class="py-2 px-4 border">{{ $m->jam_masuk ?? '-' }} - {{ $m->jam_keluar ?? '-' }}</td>
                                <td class="py-2 px-4 border">
                                    <span class="px-2 py-1 rounded text-xs {{ $m->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $m->status }}
                                    </span>
                                </td>
                                <td class="py-2 px-4 border">
                                    <a href="{{ route('admin.mekanik.show', $m->id_mekanik) }}" class="text-green-600 mr-2">Detail</a>
                                    <a href="{{ route('admin.mekanik.edit', $m->id_mekanik) }}" class="text-blue-600 mr-2">Edit</a>
                                    <form action="{{ route('admin.mekanik.destroy', $m->id_mekanik) }}" method="POST" class="inline-block">
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
                <div class="mt-4">{{ $mekaniks->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection