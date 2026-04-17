@extends('mekanik.layouts.app')
@section('content')
    {{-- Header --}}
    <header class="bg-white py-6 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-bold text-2xl text-black">
                Edit Work Order #{{ $wo->nomor_wo }}
            </h2>
        </div>
    </header>

    {{-- Success Alert --}}
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        </div>
    @endif


    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">



            {{-- ===================== --}}
            {{-- EDIT WORK ORDER DATA --}}
            {{-- ===================== --}}
            <div class="md:col-span-3 bg-white p-6 rounded-xl shadow border">
                <h3 class="font-bold text-lg mb-6">Edit Data Work Order</h3>

                <form action="{{ route('mekanik.work-order.update', $wo->id_wo) }}" method="POST"
                    class="grid grid-cols-1 md:grid-cols-2 gap-6" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WO</label>
                        <input type="text" name="nomor_wo" value="{{ old('nomor_wo', $wo->nomor_wo) }}"
                            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                        @error('nomor_wo')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="antrian" {{ old('status', $wo->status) == 'antrian' ? 'selected' : '' }}>Antrian
                            </option>
                            <option value="dikerjakan" {{ old('status', $wo->status) == 'dikerjakan' ? 'selected' : '' }}>
                                Dikerjakan</option>
                            <option value="menunggu_part"
                                {{ old('status', $wo->status) == 'menunggu_part' ? 'selected' : '' }}>Menunggu Part</option>
                            <option value="selesai" {{ old('status', $wo->status) == 'selesai' ? 'selected' : '' }}>Selesai
                            </option>
                        </select>
                        @error('status')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keluhan</label>
                        <textarea name="keluhan" rows="3" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                            required>{{ old('keluhan', $wo->keluhan) }}</textarea>
                        @error('keluhan')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar</label>
                        <input type="file" name="gambar" class="w-full border rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estimasi Selesai</label>
                        <input type="date" name="estimasi_selesai"
                            value="{{ old('estimasi_selesai', $wo->estimasi_selesai ? $wo->estimasi_selesai->format('Y-m-d') : '') }}"
                            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        @error('estimasi_selesai')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Mekanik</label>
                        <textarea name="catatan_mekanik" rows="4"
                            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">{{ old('catatan_mekanik', $wo->catatan_mekanik) }}</textarea>
                        @error('catatan_mekanik')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="md:col-span-2 flex gap-3">
                        <button type="submit"
                            class="flex-1 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-medium">
                            Update Data WO
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
