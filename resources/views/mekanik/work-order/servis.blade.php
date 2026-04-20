@extends('mekanik.layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-8">

    <h2 class="text-2xl font-bold mb-6">
        Servis WO #{{ $wo->nomor_wo }}
    </h2>

    {{-- INFO KENDARAAN --}}
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <p><b>No Polisi:</b> {{ $wo->kendaraan->nomor_polisi }}</p>
        <p><b>Keluhan:</b> {{ $wo->keluhan }}</p>
    </div>

    <form action="{{ route('mekanik.work-order.servis.store', $wo->id_wo) }}" method="POST">
        @csrf

        {{-- ===================== --}}
        {{-- JENIS SERVIS --}}
        {{-- ===================== --}}
        <div class="bg-white p-6 rounded-xl shadow mb-6">
            <h3 class="font-bold mb-4">Pilih Jenis Servis</h3>

            @foreach ($jenisServis as $servis)
                <label class="flex items-center gap-3 mb-2">
                    <input type="checkbox" name="jenis_servis[]" value="{{ $servis->id_jenis }}">
                    {{ $servis->nama_servis }} (Rp {{ number_format($servis->harga_jasa) }})
                </label>
            @endforeach
        </div>

        {{-- ===================== --}}
        {{-- SPAREPART --}}
        {{-- ===================== --}}
        <div class="bg-white p-6 rounded-xl shadow mb-6">
            <h3 class="font-bold mb-4">Penggunaan Sparepart</h3>

            @foreach ($spareparts as $part)
                <div class="flex justify-between mb-2">
                    <span>{{ $part->nama_part }}</span>
                    <input type="number" name="sparepart[{{ $part->id_part }}]" min="0"
                        class="border px-2 py-1 w-20">
                </div>
            @endforeach
        </div>

        <button class="bg-blue-600 text-white px-6 py-2 rounded-lg">
            Simpan Servis
        </button>

    </form>

    {{-- ===================== --}}
    {{-- RINGKASAN --}}
    {{-- ===================== --}}
    <div class="mt-6 bg-green-50 p-4 rounded-lg">
        <h3 class="font-bold">Total Saat Ini:</h3>
        <p class="text-xl font-bold">
            Rp {{ number_format($wo->total_harga) }}
        </p>
    </div>

</div>

@endsection
