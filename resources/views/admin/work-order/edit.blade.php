@extends('admin.layouts.app')
@section('title', 'Edit Work Order')
@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">Edit Work Order</h2>
                <form action="{{ route('admin.work-order.update', $workOrder->id_wo) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kendaraan (ID)</label>
                            <input type="number" name="id_kendaraan" value="{{ old('id_kendaraan', $workOrder->id_kendaraan) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mekanik</label>
                            <select name="id_mekanik" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @foreach($mekaniks as $m)
                                <option value="{{ $m->id_mekanik }}" {{ $workOrder->id_mekanik == $m->id_mekanik ? 'selected' : '' }}>{{ $m->nama_mekanik }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Masuk</label>
                            <input type="datetime-local" name="tanggal_masuk" value="{{ old('tanggal_masuk', $workOrder->tanggal_masuk->format('Y-m-d\TH:i')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                            <input type="datetime-local" name="tanggal_selesai" value="{{ old('tanggal_selesai', $workOrder->tanggal_selesai ? $workOrder->tanggal_selesai->format('Y-m-d\TH:i') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estimasi Selesai</label>
                            <input type="datetime-local" name="estimasi_selesai" value="{{ old('estimasi_selesai', $workOrder->estimasi_selesai ? $workOrder->estimasi_selesai->format('Y-m-d\TH:i') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="antrian" {{ $workOrder->status == 'antrian' ? 'selected' : '' }}>Antrian</option>
                                <option value="dikerjakan" {{ $workOrder->status == 'dikerjakan' ? 'selected' : '' }}>Dikerjakan</option>
                                <option value="menunggu_part" {{ $workOrder->status == 'menunggu_part' ? 'selected' : '' }}>Menunggu Part</option>
                                <option value="selesai" {{ $workOrder->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="diserahkan" {{ $workOrder->status == 'diserahkan' ? 'selected' : '' }}>Diserahkan</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Keluhan</label>
                            <textarea name="keluhan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('keluhan', $workOrder->keluhan) }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Catatan Mekanik</label>
                            <textarea name="catatan_mekanik" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('catatan_mekanik', $workOrder->catatan_mekanik) }}</textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('admin.work-order.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded mr-2">Batal</a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Update WO</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
