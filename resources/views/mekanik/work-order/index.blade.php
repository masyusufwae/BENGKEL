@extends('mekanik.layouts.app')
@section('content')
    {{-- Header --}}
    <header class="bg-white py-6 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h2 class="font-bold text-2xl text-black">
                Work Order (Pusat Kerja)
            </h2>

            <div class="flex items-center gap-2">
                {{-- Search --}}
                <form method="GET" action="" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="Cari Plat Nomor..."
                        class="border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Cari
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
                                <th class="py-4 px-4 font-bold text-black">Gambar</th>
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
                                        @elseif($wo->status == 'menunggu_part')
                                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                                Menunggu Part
                                            </span>
                                        @elseif($wo->status == 'selesai')
                                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                                Selesai
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Keluhan --}}
                                    <td class="py-3 px-4 text-sm text-gray-600">
                                        {{ Str::limit($wo->keluhan, 40) }}
                                    </td>


                                    <td class="py-3 px-4">
                                        @if ($wo->gambar)
                                            <img src="{{ asset('storage/' . $wo->gambar) }}"
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
                                            <a href="{{ route('mekanik.work-order.detail', $wo->id_wo) }}"
                                                class="bg-blue-100 text-blue-700 px-4 py-2 rounded-lg text-sm hover:bg-blue-200 transition shadow w-full text-center">
                                                Mulai Kerjakan
                                            </a>
                                        @else
                                            <a href="{{ route('mekanik.work-order.edit', $wo->id_wo) }}"
                                                class="bg-blue-50 text-blue-700 px-4 py-2 rounded-lg text-sm hover:bg-blue-100 transition shadow w-full text-center">
                                                Lanjutkan
                                            </a>
                                            <a href="{{ route('mekanik.work-order.servis', $wo->id_wo) }}"
    class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-600 transition w-full text-center">
    Servis
</a>
                                        @endif
                                        <form action="{{ route('mekanik.work-order.updateStatus', $wo->id_wo) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="hidden" name="status" value="selesai">

    <button class="bg-green-600 text-white px-4 py-2 rounded">
        Selesaikan Servis
    </button>
</form>
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

                    {{-- Pagination --}}
                    <div class="p-4">
                        {{ $workOrders->links() }}
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
