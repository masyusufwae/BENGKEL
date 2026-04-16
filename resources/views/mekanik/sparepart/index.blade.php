@extends('mekanik.layouts.app')
@section('content')

    {{-- Header --}}
    <header class="bg-white py-6 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h2 class="font-bold text-2xl text-black">
                Stok Sparepart
            </h2>

            {{-- Tombol Tambah --}}
            <a href="{{ route('mekanik.sparepart.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition shadow font-medium">
                + Tambah Sparepart
            </a>

        </div>
    </header>

    {{-- Content --}}
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ===================== --}}
            {{-- STATISTIK STOK MINIMUM --}}
            {{-- ===================== --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div class="bg-red-50 border border-red-200 p-4 rounded-xl shadow">
                    <p class="text-sm text-red-600">Stok Menipis</p>
                    <p class="text-2xl font-bold text-red-700">
                        {{ $stokMenipis }}
                    </p>
                </div>

                <div class="bg-green-50 border border-green-200 p-4 rounded-xl shadow">
                    <p class="text-sm text-green-600">Total Sparepart</p>
                    <p class="text-2xl font-bold text-green-700">
                        {{ $totalSparepart }}
                    </p>
                </div>

            </div>

            {{-- ===================== --}}
            {{-- TABEL SPAREPART --}}
            {{-- ===================== --}}
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="py-4 px-4 font-bold">Kode Part</th>
                            <th class="py-4 px-4 font-bold">Nama Part</th>
                            <th class="py-4 px-4 font-bold">Satuan</th>
                            <th class="py-4 px-4 font-bold">Harga Beli</th>
                            <th class="py-4 px-4 font-bold">Harga Jual</th>
                            <th class="py-4 px-4 font-bold">Stok</th>
                            <th class="py-4 px-4 text-center font-bold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($spareparts as $sp)
                            <tr class="border-b hover:bg-gray-50"
                                data-id="{{ $sp->id_part }}"
                                data-kode="{{ $sp->kode_part }}"
                                data-nama="{{ $sp->nama_part }}"
                                data-satuan="{{ $sp->satuan }}"
                                data-stok="{{ $sp->stok }}"
                                data-stok-min="{{ $sp->stok_minimum }}"
                                data-harga-beli="{{ $sp->harga_beli }}"
                                data-harga-jual="{{ $sp->harga_jual }}">

                                <td class="py-3 px-4 font-semibold">
                                    {{ $sp->kode_part }}
                                </td>

                                <td class="py-3 px-4">
                                    {{ $sp->nama_part }}
                                </td>

                                <td class="py-3 px-4 text-sm">
                                    {{ $sp->satuan ?? 'N/A' }}
                                </td>

                                <td class="py-3 px-4">
                                    Rp{{ number_format($sp->harga_beli) }}
                                </td>

                                <td class="py-3 px-4 font-mono">
                                    Rp{{ number_format($sp->harga_jual) }}
                                </td>

                                {{-- STOK + INDIKATOR --}}
                                <td class="py-3 px-4">
                                    @if($sp->stok <= $sp->stok_minimum)
                                        <span class="text-red-600 font-bold">
                                            {{ $sp->stok }} ⚠️
                                        </span>
                                    @else
                                        <span class="text-gray-800 font-semibold">
                                            {{ $sp->stok }}
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="py-3 px-4 text-center space-x-1">
                                    <a href="{{ route('mekanik.sparepart.detail', $sp->id_part) }}"
                                        class="bg-gray-600 text-black px-3 py-1 rounded-lg hover:bg-gray-700 text-xs inline-block text-center min-w-[50px] border border-black"
                                        title="Detail">
                                        Detail
                                    </a>
                                    <a href="{{ route('mekanik.sparepart.edit', $sp->id_part) }}"
                                        class="bg-yellow-500 text-black px-3 py-1 rounded-lg hover:bg-yellow-600 text-xs inline-block text-center min-w-[50px] border border-black"
                                        title="Edit">
                                        Edit
                                    </a>
                                    {{-- <button
                                        onclick="openEditModal({{ $sp->id_part }}, '{{ $sp->nama_part }}')"
                                        class="bg-yellow-500 text-black px-3 py-1 rounded-lg hover:bg-yellow-600 text-xs">
                                        Update
                                    </button> --}}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-10 text-gray-500">
                                    Tidak ada data sparepart.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="p-4">
                    {{ $spareparts->links() }}
                </div>

            </div>

        </div>
    </div>


@endsection

