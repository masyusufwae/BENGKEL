@extends('mekanik.layouts.app')
@section('content')

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <header class="bg-white py-6 border-b">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">

                        <h2 class="font-bold text-2xl text-black">
                            Detail Sparepart: {{ $sparepart->nama_part }}
                        </h2>
                        <a href="{{ route('mekanik.sparepart.edit', $sparepart->id_part) }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                            Edit Sparepart
                        </a>
                    </div>
                </header>
                <div class="p-8">
                    <div class="flex flex-col md:flex-row gap-8 md:items-stretch">
                        {{-- KIRI: Info Sparepart dalam card --}}
                        <div class="md:w-5/12 w-full flex">
                            <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6 space-y-6 w-full">
                                {{-- STOK --}}
                                <div>
                                    <h3 class="font-semibold text-gray-800 text-lg mb-3">Stok</h3>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="bg-gray-50 p-4 rounded-xl border">
                                            <p class="text-xs text-gray-500 mb-1">Stok Saat Ini</p>
                                            <p
                                                class="text-3xl font-bold {{ $sparepart->stok <= $sparepart->stok_minimum ? 'text-red-600' : 'text-green-600' }}">
                                                {{ $sparepart->stok }}
                                            </p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-xl border">
                                            <p class="text-xs text-gray-500 mb-1">Stok Minimum</p>
                                            <p class="text-xl font-semibold text-orange-500">{{ $sparepart->stok_minimum }}
                                            </p>
                                        </div>
                                        <div class="bg-gray-50 p-4 rounded-xl border col-span-2">
                                            <p class="text-xs text-gray-500 mb-1">Satuan</p>
                                            <p class="text-base font-medium text-gray-700">{{ $sparepart->satuan ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- HARGA --}}
                                <div>
                                    <h3 class="font-semibold text-gray-800 text-lg mb-3">Harga</h3>
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg border">
                                            <span class="text-sm text-gray-500">Harga Beli</span>
                                            <span class="font-mono text-gray-700">Rp
                                                {{ number_format($sparepart->harga_beli) }}</span>
                                        </div>
                                        <div
                                            class="flex justify-between items-center bg-green-50 p-3 rounded-lg border border-green-100">
                                            <span class="text-sm text-gray-600">Harga Jual</span>
                                            <span class="font-bold text-green-600 text-lg">Rp
                                                {{ number_format($sparepart->harga_jual) }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- INFO UMUM --}}
                                <div>
                                    <h3 class="font-semibold text-gray-800 text-lg mb-3">Info Umum</h3>
                                    <div class="bg-gray-50 p-4 rounded-xl border space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Kode Part</span>
                                            <span class="font-medium text-gray-800">{{ $sparepart->kode_part }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Nama</span>
                                            <span class="font-medium text-gray-800">{{ $sparepart->nama_part }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- KANAN: Riwayat Penggunaan --}}
                        <div class="md:w-7/12 w-full flex flex-col">
                            <div class="bg-gray-50 border border-gray-200 rounded-xl shadow-sm p-6 h-full flex-1">
                                <h3 class="font-bold text-lg mb-4">Riwayat Penggunaan</h3>
                                @if ($sparepart->penggunaanSparepart->count() > 0)
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left border-collapse">
                                            <thead>
                                                <tr class="bg-gray-100">
                                                    <th class="py-3 px-4 font-bold">WO #</th>
                                                    <th class="py-3 px-4 font-bold">Jumlah</th>
                                                    <th class="py-3 px-4 font-bold">Subtotal</th>
                                                    <th class="py-3 px-4 font-bold text-right">Tanggal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sparepart->penggunaanSparepart->take(10) as $ps)
                                                    <tr class="border-b hover:bg-gray-100">
                                                        <td class="py-3 px-4 font-medium">
                                                            <a href="{{ route('mekanik.work-order.detail', $ps->workOrder->id_wo) }}"
                                                                class="text-blue-600 hover:underline">
                                                                {{ $ps->workOrder->nomor_wo }}
                                                            </a>
                                                        </td>
                                                        <td class="py-3 px-4 font-semibold">{{ $ps->jumlah }}
                                                            {{ $sparepart->satuan ?? '' }}</td>
                                                        <td class="py-3 px-4">Rp{{ number_format($ps->subtotal) }}</td>
                                                        <td class="py-3 px-4 text-right text-sm text-gray-500">
                                                            {{ $ps->created_at->format('d/m/Y H:i') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @if ($sparepart->penggunaanSparepart->count() > 10)
                                        <div class="p-4 text-center text-sm text-gray-500">
                                            ... dan {{ $sparepart->penggunaanSparepart->count() - 10 }} lagi
                                        </div>
                                    @endif
                                @else
                                    <div class="p-8 text-center text-gray-500">
                                        <p>Belum ada riwayat penggunaan untuk sparepart ini.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endsection
