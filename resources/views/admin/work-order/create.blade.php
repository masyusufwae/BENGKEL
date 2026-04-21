@extends('admin.layouts.app')
@section('title', 'Buat Work Order')
@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">Buat Work Order Baru</h2>
                <form action="{{ route('admin.work-order.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kendaraan (ID)</label>
                            <input type="number" name="id_kendaraan" value="{{ old('id_kendaraan') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <p class="text-xs text-gray-500">Masukkan ID kendaraan dari tabel kendaraan_pelanggan</p>
                            @error('id_kendaraan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mekanik</label>
                            <select name="id_mekanik" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">Pilih Mekanik</option>
                                @foreach($mekaniks as $m)
                                <option value="{{ $m->id_mekanik }}" {{ old('id_mekanik') == $m->id_mekanik ? 'selected' : '' }}>{{ $m->nama_mekanik }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Masuk</label>
                            <input type="datetime-local" name="tanggal_masuk" value="{{ old('tanggal_masuk', now()->format('Y-m-d\TH:i')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estimasi Selesai</label>
                            <input type="datetime-local" name="estimasi_selesai" value="{{ old('estimasi_selesai') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Keluhan</label>
                            <textarea name="keluhan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('keluhan') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="antrian">Antrian</option>
                                <option value="dikerjakan">Dikerjakan</option>
                                <option value="menunggu_part">Menunggu Part</option>
                                <option value="selesai">Selesai</option>
                                <option value="diserahkan">Diserahkan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Catatan Mekanik</label>
                            <textarea name="catatan_mekanik" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('catatan_mekanik') }}</textarea>
                        </div>

                        <!-- Pilih Jenis Servis (multiple) -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Jenis Servis</label>
                            <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-2">
                                @foreach($jenisServis as $js)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="servis_ids[]" value="{{ $js->id_jenis }}" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300">
                                    <span class="ml-2">{{ $js->nama_servis }} (Rp {{ number_format($js->harga_jasa,0,',','.') }})</span>
                                </label>
                                @endforeach
                            </div>
                            @error('servis_ids') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Pilih Sparepart (dynamic) -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Sparepart (Opsional)</label>
                            <div id="sparepart-container">
                                <div class="flex gap-2 mb-2">
                                    <select name="sparepart_ids[]" class="rounded-md border-gray-300 shadow-sm w-1/2">
                                        <option value="">Pilih Sparepart</option>
                                        @foreach($spareparts as $sp)
                                        <option value="{{ $sp->id_part }}">{{ $sp->nama_part }} (Stok: {{ $sp->stok }})</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="jumlah_sparepart[]" placeholder="Jumlah" class="rounded-md border-gray-300 shadow-sm w-1/4" min="1">
                                    <button type="button" class="text-red-600 remove-sparepart">Hapus</button>
                                </div>
                            </div>
                            <button type="button" id="add-sparepart" class="mt-2 text-sm text-blue-600">+ Tambah Sparepart</button>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('admin.work-order.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded mr-2">Batal</a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan WO</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.getElementById('add-sparepart').addEventListener('click', function() {
        let container = document.getElementById('sparepart-container');
        let newDiv = document.createElement('div');
        newDiv.className = 'flex gap-2 mb-2';
        newDiv.innerHTML = `
            <select name="sparepart_ids[]" class="rounded-md border-gray-300 shadow-sm w-1/2">
                <option value="">Pilih Sparepart</option>
                @foreach($spareparts as $sp)
                <option value="{{ $sp->id_part }}">{{ $sp->nama_part }} (Stok: {{ $sp->stok }})</option>
                @endforeach
            </select>
            <input type="number" name="jumlah_sparepart[]" placeholder="Jumlah" class="rounded-md border-gray-300 shadow-sm w-1/4" min="1">
            <button type="button" class="text-red-600 remove-sparepart">Hapus</button>
        `;
        container.appendChild(newDiv);
    });
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-sparepart')) {
            e.target.parentElement.remove();
        }
    });
</script>
@endpush
@endsection
