@extends('mekanik.layouts.app')

@section('content')

{{-- Header --}}
<header class="bg-white py-6 border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-bold text-2xl text-black">
            Tambah Work Order
        </h2>
    </div>
</header>

{{-- Error Alert --}}
@if ($errors->any())
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white p-6 rounded-xl shadow border">
            <h3 class="font-bold text-lg mb-6">Form Tambah Work Order</h3>
            <form action="{{ route('mekanik.work-order.store') }}" method="POST"
                  class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                {{-- Nomor WO --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WO</label>
                    <input type="text" name="nomor_wo" value="{{ old('nomor_wo') }}"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                </div>
                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                        <option value="antrian">Antrian</option>
                        <option value="dikerjakan">Dikerjakan</option>
                        <option value="menunggu_part">Menunggu Part</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
                {{-- Kendaraan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kendaraan</label>
                    <select name="id_kendaraan"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih Kendaraan</option>
                        @foreach($kendaraans as $k)
                            <option value="{{ $k->id_kendaraan }}">
                                {{ $k->nomor_polisi }} - {{ $k->model }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- Estimasi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estimasi Selesai</label>
                    <input type="date" name="estimasi_selesai" value="{{ old('estimasi_selesai') }}"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                </div>
                {{-- Keluhan --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keluhan</label>
                    <textarea name="keluhan" rows="3"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>{{ old('keluhan') }}</textarea>
                </div>
                {{-- Catatan --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Mekanik</label>
                    <textarea name="catatan_mekanik" rows="4"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">{{ old('catatan_mekanik') }}</textarea>
                </div>
                {{-- Button --}}
                <div class="md:col-span-2 flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-medium">
                        Simpan Work Order
                    </button>
                    <a href="{{ route('mekanik.work-order.index') }}"
                        class="flex-1 bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 font-medium text-center">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
