@extends('admin.layouts.app')
@section('title', 'Invoice WO - '.$workOrder->nomor_wo)
@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold">INVOICE</h1>
                <p class="text-gray-600">Bengkel System</p>
                <p class="text-sm">No. WO: {{ $workOrder->nomor_wo }}</p>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p><strong>Customer:</strong> {{ $workOrder->kendaraan->nama_pelanggan ?? '-' }}</p>
                    <p><strong>Kendaraan:</strong> {{ $workOrder->kendaraan->no_plat ?? '-' }} ({{ $workOrder->kendaraan->jenis_kendaraan ?? '' }})</p>
                </div>
                <div>
                    <p><strong>Tanggal Masuk:</strong> {{ $workOrder->tanggal_masuk->format('d/m/Y H:i') }}</p>
                    <p><strong>Mekanik:</strong> {{ $workOrder->mekanik->nama_mekanik ?? '-' }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($workOrder->status) }}</p>
                </div>
            </div>
            <table class="min-w-full border-collapse border border-gray-300 mb-6">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left">Deskripsi</th>
                        <th class="border border-gray-300 px-4 py-2 text-right">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workOrder->jenisServis as $servis)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Servis: {{ $servis->nama_servis }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-right">Rp {{ number_format($servis->pivot->harga_satuan,0,',','.') }}</td>
                    </tr>
                    @endforeach
                    @foreach($workOrder->spareparts as $sp)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">Sparepart: {{ $sp->nama_part }} (x{{ $sp->pivot->jumlah }})</td>
                        <td class="border border-gray-300 px-4 py-2 text-right">Rp {{ number_format($sp->pivot->jumlah * $sp->pivot->harga_satuan,0,',','.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="font-bold">
                        <td class="border border-gray-300 px-4 py-2">Total</td>
                        <td class="border border-gray-300 px-4 py-2 text-right">Rp {{ number_format($workOrder->totalHarga,0,',','.') }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-end space-x-2">
                <button onclick="window.print()" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">Cetak Invoice</button>
                <a href="{{ route('admin.invoice.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection