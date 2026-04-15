@extends('admin.layouts.app')
@section('title', 'Edit Mekanik')
@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Edit Mekanik</h2>

                    {{-- Tampilkan error umum jika ada --}}
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.mekanik.update', $mekanik->id_mekanik) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Mekanik</label>
                                <input type="text" name="nama_mekanik"
                                    value="{{ old('nama_mekanik', $mekanik->nama_mekanik) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('nama_mekanik') border-red-500 @enderror"
                                    required>
                                @error('nama_mekanik')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">NIP</label>
                                <input type="text" name="nip" value="{{ old('nip', $mekanik->nip) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('nip') border-red-500 @enderror">
                                @error('nip')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Spesialisasi</label>
                                <input type="text" name="spesialisasi"
                                    value="{{ old('spesialisasi', $mekanik->spesialisasi) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('spesialisasi') border-red-500 @enderror">
                                @error('spesialisasi')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jam Masuk</label>
                                <input type="time" name="jam_masuk"
                                    value="{{ old('jam_masuk', $mekanik->jam_masuk ? \Carbon\Carbon::parse($mekanik->jam_masuk)->format('H:i') : '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('jam_masuk') border-red-500 @enderror">
                                @error('jam_masuk')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jam Keluar</label>
                                <input type="time" name="jam_keluar"
                                    value="{{ old('jam_keluar', $mekanik->jam_keluar ? \Carbon\Carbon::parse($mekanik->jam_keluar)->format('H:i') : '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('jam_keluar') border-red-500 @enderror">
                                @error('jam_keluar')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('status') border-red-500 @enderror"
                                    required>
                                    <option value="aktif"
                                        {{ old('status', $mekanik->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif"
                                        {{ old('status', $mekanik->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                                    </option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('admin.mekanik.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded mr-2">Batal</a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
