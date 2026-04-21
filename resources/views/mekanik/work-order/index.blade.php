@extends('mekanik.layouts.app')
@section('content')
    {{-- Header --}}
    <header class="bg-white py-6 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h2 class="font-bold text-2xl text-black">
                Work Order (Pusat Kerja)
            </h2>

            <div class="flex items-center gap-2">
                {{-- Filters --}}
                <form method="GET" action="" class="flex items-center gap-2">
                    {{-- Search --}}
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Plat Nomor..."
                        class="border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500">

                    {{-- Status Filter --}}
                    <select name="status" class="border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="antrian" {{ request('status') == 'antrian' ? 'selected' : '' }}>Antrian</option>
                        <option value="dikerjakan" {{ request('status') == 'dikerjakan' ? 'selected' : '' }}>Dikerjakan
                        </option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>

                    {{-- Sort Filter --}}
                    <select name="sort" class="border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>tanggal</option>
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                    </select>

                    <button class="bg-blue-600 text-black px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Filter
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- Content --}}
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">

                {{-- Table --}}

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[800px]">

                        <thead>

                            <tr class="bg-gray-50 border-b">
                                <th class="py-4 px-4 font-bold text-black">Nomor</th>
                                <th class="py-4 px-4 font-bold text-black">Status</th>
                                <th class="py-4 px-4 font-bold text-black">Keluhan</th>
                                <th class="py-4 px-4 font-bold text-black">Foto Kendaraan</th>
                                <th class="py-4 px-4 font-bold text-black">No Polisi</th>
                                <th class="py-4 px-4 font-bold text-black">Model</th>
                                <th class="py-4 px-4 text-center font-bold text-black">Aksi</th>
                            </tr>

                        </thead>

                        <tbody>
                            @forelse ($workOrders as $wo)
                                <tr class="border-b hover:bg-gray-50 transition">


                                    {{-- Nomor --}}
                                    <td class="py-3 px-4 font-semibold">
                                        {{ $wo->nomor_wo }}
                                    </td>

                                    {{-- Status --}}
                                    <td class="py-3 px-4">
                                        @if ($wo->status == 'antrian')
                                            <span class="px-3 py-1 text-xs rounded-full bg-gray-200 text-gray-700">
                                                Antrian
                                            </span>
                                        @elseif($wo->status == 'dikerjakan')
                                            <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                                Dikerjakan
                                            </span>
                                        @elseif($wo->status == 'selesai')
                                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                                Selesai
                                            </span>
                                        @elseif($wo->status == 'ditolak')
                                            <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Keluhan --}}
                                    <td class="py-3 px-4 text-sm text-gray-600">
                                        {{ Str::limit($wo->keluhan, 40) }}
                                    </td>


                                    <td class="py-3 px-4">
                                        @if ($wo->kendaraan && $wo->kendaraan->foto_kendaraan)
                                            <img src="{{ asset('storage/' . $wo->kendaraan->foto_kendaraan) }}"
                                                class="w-16 h-16 object-cover rounded">
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </td>

                                    {{-- Polisi --}}
                                    <td class="py-3 px-4 font-bold text-lg">
                                        {{ $wo->kendaraan->nomor_polisi }}
                                    </td>

                                    {{-- Model --}}
                                    <td class="py-3 px-4">
                                        {{ $wo->kendaraan->model ?? '-' }}
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="py-3 px-4 text-center flex flex-col gap-2 items-center">
                                        <a href="{{ route('mekanik.work-order.detail', $wo->id_wo) }}"
                                            class="bg-blue-500 text-black px-4 py-2 rounded-lg text-sm hover:bg-blue-600 transition shadow w-full text-center">
                                            Detail
                                        </a>

                                        @if ($wo->status == 'antrian')
                                            {{-- Antrian: Setuju | Tolak --}}
                                            <span
                                                class="text-xs text-gray-500 py-2 px-4 rounded-lg bg-gray-100 w-full text-center block font-medium">Tindakan
                                                di Detail</span>
                                        @elseif ($wo->status == 'dikerjakan' && !$wo->servis_completed)
                                            {{-- Dikerjakan (servis belum): Servis --}}
                                            <a href="{{ route('mekanik.work-order.edit', $wo->id_wo) }}"
                                                class="w-full bg-blue-500 text-black px-4 py-2 rounded-lg text-sm hover:bg-blue-600 transition shadow font-bold text-center">
                                                🔧 Servis
                                            </a>
                                        @elseif ($wo->status == 'dikerjakan' && $wo->servis_completed)
                                            {{-- Dikerjakan + servis selesai: [Selesai] clickable → status=selesai --}}
                                            <form action="{{ route('mekanik.work-order.updateStatus', $wo->id_wo) }}"
                                                method="POST" class="w-full">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="selesai">
                                                <button type="submit"
                                                    class="w-full bg-green-500 text-black px-4 py-2 rounded-lg text-sm hover:bg-green-600 transition shadow font-bold">
                                                    ✅ Selesai Servis
                                                </button>
                                            </form>
                                        @elseif ($wo->status == 'ditolak')
                                            {{-- Ditolak: Disabled --}}
                                            <button disabled
                                                class="w-full bg-gray-400 text-gray-200 px-4 py-2 rounded-lg text-sm shadow cursor-not-allowed">
                                                ❌ Ditolak
                                            </button>
                                        @elseif ($wo->status == 'selesai')
                                            {{-- Selesai: Disabled --}}
                                            <button disabled
                                                class="w-full bg-green-400 text-green-100 px-4 py-2 rounded-lg text-sm shadow cursor-not-allowed">
                                                ✅ Selesai
                                            </button>
                                        @endif
                                    </td>


                                </tr>
                            @empty

                                <tr>
                                    <td colspan="9" class="text-center py-10 text-gray-500">
                                        🚀Tidak ada data Kendaraan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="p-4">
                        {{ $workOrders->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
