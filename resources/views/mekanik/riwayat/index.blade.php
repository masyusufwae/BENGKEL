@extends('mekanik.layouts.app')
@section('content')
    {{-- Header --}}
    <header class="bg-white py-6 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h2 class="font-bold text-2xl text-black">
                Riwayat Work Order
            </h2>
        </div>
    </header>

    {{-- Filter --}}
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 p-6">
                <form method="GET" action="{{ route('mekanik.riwayat') }}"
                    class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    {{-- Filter Tanggal --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Masuk</label>
                        <div class="flex gap-2">
                            <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
                                class="flex-1 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                            <span class="text-gray-400">-</span>
                            <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
                                class="flex-1 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    {{-- Filter Plat Nomor --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Plat Nomor</label>
                        <input type="text" name="plat" value="{{ request('plat') }}" placeholder="Contoh: B 1234 ABC"
                            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                    {{-- Button --}}
                    <div class="flex gap-2">
                        <button type="submit"
                            class="flex-1 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-medium">
                            Filter
                        </button>
                        <a href="{{ route('mekanik.riwayat') }}"
                            class="flex-1 bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 font-medium text-center">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[700px]">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="py-4 px-6 font-bold text-black">No WO</th>
                                <th class="py-4 px-6 font-bold text-black">Tanggal Masuk</th>
                                <th class="py-4 px-6 font-bold text-black">Tanggal Selesai</th>
                                <th class="py-4 px-6 font-bold text-black">Plat Nomor</th>
                                <th class="py-4 px-6 font-bold text-black">Kendaraan</th>
                                <th class="py-4 px-6 font-bold text-black">Status</th>
                                <th class="py-4 px-6 text-center font-bold text-black">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($workOrdersSelesai as $wo)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-4 px-6 font-semibold">
                                        {{ $wo->nomor_wo }}
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-600">
                                        {{ $wo->tanggal_masuk->format('d M Y') }}
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-600">
                                        {{ $wo->tanggal_selesai?->format('d M Y') ?? '—' }}
                                    </td>
                                    <td class="py-4 px-6 font-bold text-lg">
                                        {{ $wo->kendaraan->nomor_polisi }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $wo->kendaraan->model ?? '-' }}<br>
                                        <span class="text-sm text-gray-500">{{ $wo->kendaraan->user->name ?? '-' }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span
                                            class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">
                                            ✅ Selesai
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <a href="{{ route('mekanik.work-order.detail', $wo->id_wo) }}"
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm transition shadow">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12 text-gray-500">
                                        <div class="space-y-2">
                                            <p class="text-lg">📋 Belum ada riwayat servis selesai</p>
                                            <p class="text-sm">Selesaikan beberapa Work Order untuk melihat arsip di sini.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-6 bg-gray-50 border-t">
                    {{ $workOrdersSelesai->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
