@extends('mekanik.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold">WO #{{ $wo->nomor_wo }}</h1>
        <p class="text-gray-500">{{ $wo->keluhan }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- ========================= --}}
        {{-- 1. INFO WO + STATUS --}}
        {{-- ========================= --}}
        <div class="bg-white p-5 rounded-xl shadow border">
            <h3 class="font-bold mb-4">Info Kendaraan</h3>

            <p><b>No Polisi:</b> {{ $wo->kendaraan->nomor_polisi }}</p>
            <p><b>Pelanggan:</b> {{ $wo->kendaraan->user->name }}</p>
            <p><b>Status:</b>
                <span class="px-2 py-1 rounded text-sm bg-gray-100">
                    {{ $wo->status }}
                </span>
            </p>

            {{-- STATUS BUTTON --}}
            <div class="mt-4 space-y-2">

                <form method="POST" action="{{ route('mekanik.wo.updateStatus', $wo->id_wo) }}">
                    @csrf
                    <input type="hidden" name="status" value="dikerjakan">
                    <button class="w-full bg-blue-600 text-white py-2 rounded">Mulai Kerja</button>
                </form>

                <form method="POST" action="{{ route('mekanik.wo.updateStatus', $wo->id_wo) }}">
                    @csrf
                    <input type="hidden" name="status" value="menunggu_part">
                    <button class="w-full bg-yellow-500 text-white py-2 rounded">Menunggu Part</button>
                </form>

                <form method="POST" action="{{ route('mekanik.wo.updateStatus', $wo->id_wo) }}">
                    @csrf
                    <input type="hidden" name="status" value="selesai">
                    <button class="w-full bg-green-600 text-white py-2 rounded">Selesai</button>
                </form>

            </div>
        </div>

        {{-- ========================= --}}
        {{-- 2. JASA SERVIS --}}
        {{-- ========================= --}}
        <div class="bg-white p-5 rounded-xl shadow border">
            <h3 class="font-bold mb-4">Jasa Servis</h3>

            {{-- LIST --}}
            @foreach ($wo->detailServis as $item)
                <div class="border-b py-2">
                    {{ $item->jenisServis->nama_servis }} - Rp{{ $item->harga_jasa }}
                </div>
            @endforeach

            {{-- FORM TAMBAH --}}
            <form method="POST" action="{{ route('mekanik.wo.tambahJasa') }}" class="mt-4">
                @csrf
                <input type="hidden" name="id_wo" value="{{ $wo->id_wo }}">

                <select name="id_jenis" class="w-full border rounded p-2 mb-2">
                    @foreach ($jenisServis as $js)
                        <option value="{{ $js->id_jenis }}">
                            {{ $js->nama_servis }} - {{ $js->harga_jasa }}
                        </option>
                    @endforeach
                </select>

                <button class="w-full bg-blue-600 text-white py-2 rounded">
                    + Tambah Jasa
                </button>
            </form>
        </div>

        {{-- ========================= --}}
        {{-- 3. SPAREPART --}}
        {{-- ========================= --}}
        <div class="bg-white p-5 rounded-xl shadow border">
            <h3 class="font-bold mb-4">Sparepart</h3>

            {{-- LIST --}}
            @foreach ($wo->penggunaanSparepart as $item)
                <div class="border-b py-2">
                    {{ $item->sparepart->nama_part }} ({{ $item->jumlah }})
                </div>
            @endforeach

            {{-- FORM TAMBAH --}}
            <form method="POST" action="{{ route('mekanik.wo.tambahSparepart') }}" class="mt-4">
                @csrf
                <input type="hidden" name="id_wo" value="{{ $wo->id_wo }}">

                <select name="id_part" class="w-full border rounded p-2 mb-2">
                    @foreach ($sparepart as $sp)
                        <option value="{{ $sp->id_part }}">
                            {{ $sp->nama_part }} (stok: {{ $sp->stok }})
                        </option>
                    @endforeach
                </select>

                <input type="number" name="jumlah" placeholder="Jumlah"
                    class="w-full border rounded p-2 mb-2" required>

                <button class="w-full bg-green-600 text-white py-2 rounded">
                    + Tambah Sparepart
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
