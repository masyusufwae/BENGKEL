@extends('admin.layouts.app')
@section('title', 'Detail Work Order')
@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">Detail Work Order</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><strong>No WO:</strong> {{ $workOrder->nomor_wo }}</div>
                    <div><strong>Status:</strong> {{ ucfirst($workOrder->status) }}</div>
                    <div><strong>Customer:</strong> {{ $workOrder->kendaraan->nama_pelanggan ?? '-' }}</div>
                    <div><strong>Kendaraan:</strong> {{ $workOrder->kendaraan->no_plat ?? '-' }} ({{ $workOrder->kendaraan->jenis_kendaraan ?? '' }})</div>
                    <div><strong>Mekanik:</strong> {{ $workOrder->mekanik->nama_mekanik ?? '-' }}</div>
                    <div><strong>Tanggal Masuk:</strong> {{ $workOrder->tanggal_masuk->format('d/m/Y H:i') }}</div>
                    <div><strong>Tanggal Selesai:</strong> {{ $workOrder->tanggal_selesai ? $workOrder->tanggal_selesai->format('d/m/Y H:i') : '-' }}</div>
                    <div><strong>Estimasi Selesai:</strong> {{ $workOrder->estimasi_selesai ? $workOrder->estimasi_selesai->format('d/m/Y H:i') : '-' }}</div>
                    <div class="md:col-span-2"><strong>Keluhan:</strong> {{ $workOrder->keluhan }}</div>
                    <div class="md:col-span-2"><strong>Catatan Mekanik:</strong> {{ $workOrder->catatan_mekanik ?? '-' }}</div>
                </div>

                <h3 class="text-lg font-semibold mt-6 mb-2">Detail Servis</h3>
                <table class="min-w-full border mb-4">
                    <thead><tr class="bg-gray-100"><th class="py-1 px-2 border">Nama Servis</th><th class="py-1 px-2 border">Harga</th></tr></thead>
                    <tbody>
                        @foreach($workOrder->jenisServis as $servis)
                        <tr><td class="py-1 px-2 border">{{ $servis->nama_servis }}</td><td class="py-1 px-2 border">Rp {{ number_format($servis->pivot->harga_satuan,0,',','.') }}</td></tr>
                        @endforeach
                    </tbody>
                </table>

                <h3 class="text-lg font-semibold mb-2">Sparepart yang Digunakan</h3>
                <table class="min-w-full border mb-4">
                    <thead><tr class="bg-gray-100"><th class="py-1 px-2 border">Nama Part</th><th class="py-1 px-2 border">Jumlah</th><th class="py-1 px-2 border">Harga Satuan</th><th class="py-1 px-2 border">Subtotal</th></tr></thead>
                    <tbody>
                        @foreach($workOrder->spareparts as $sp)
                        <tr>
                            <td class="py-1 px-2 border">{{ $sp->nama_part }}</td>
                            <td class="py-1 px-2 border">{{ $sp->pivot->jumlah }}</td>
                            <td class="py-1 px-2 border">Rp {{ number_format($sp->pivot->harga_satuan,0,',','.') }}</td>
                            <td class="py-1 px-2 border">Rp {{ number_format($sp->pivot->jumlah * $sp->pivot->harga_satuan,0,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-right font-bold text-xl">Total: Rp {{ number_format($workOrder->totalHarga,0,',','.') }}</div>
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.work-order.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection