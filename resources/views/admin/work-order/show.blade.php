@extends('admin.layouts.app')
@section('title', 'Detail Work Order')
@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">Detail Work Order</h2>
                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4">{{ session('error') }}</div>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><strong>No WO:</strong> {{ $workOrder->nomor_wo }}</div>
                    <div><strong>Status:</strong> {{ ucwords(str_replace('_', ' ', $workOrder->status)) }}</div>
                    <div><strong>Customer:</strong> {{ $workOrder->kendaraan?->user?->name ?? '-' }}</div>
                    <div><strong>Kendaraan:</strong> {{ $workOrder->kendaraan?->nomor_polisi ?? '-' }} ({{ $workOrder->kendaraan?->merek ?? '' }} {{ $workOrder->kendaraan?->model ?? '' }})</div>
                    <div><strong>Mekanik:</strong> {{ $workOrder->mekanik?->nama_mekanik ?? '-' }}</div>
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
                        @if($workOrder->jenisServis->isNotEmpty())
                            @foreach($workOrder->jenisServis as $servis)
                                <tr>
                                    <td class="py-1 px-2 border">{{ $servis->nama_servis }}</td>
                                    <td class="py-1 px-2 border">Rp {{ number_format($servis->pivot->harga_satuan,0,',','.') }}</td>
                                </tr>
                            @endforeach
                        @elseif($workOrder->detailServis->isNotEmpty())
                            @foreach($workOrder->detailServis as $detail)
                                <tr>
                                    <td class="py-1 px-2 border">{{ $detail->jenisServis?->nama_servis ?? '-' }}</td>
                                    <td class="py-1 px-2 border">Rp {{ number_format($detail->harga_jasa,0,',','.') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="py-2 px-2 border text-center" colspan="2">Tidak ada data servis</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <h3 class="text-lg font-semibold mb-2">Sparepart yang Digunakan</h3>
                <table class="min-w-full border mb-4">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-1 px-2 border">Nama Part</th>
                            <th class="py-1 px-2 border">Jumlah</th>
                            <th class="py-1 px-2 border">Satuan</th>
                            <th class="py-1 px-2 border">Harga Satuan</th>
                            <th class="py-1 px-2 border">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($workOrder->spareparts->isNotEmpty())
                            @foreach($workOrder->spareparts as $sp)
                                <tr>
                                    <td class="py-1 px-2 border">{{ $sp->nama_part }}</td>
                                    <td class="py-1 px-2 border">{{ $sp->pivot->jumlah }}</td>
                                    <td class="py-1 px-2 border">{{ $sp->satuan ?? '-' }}</td>
                                    <td class="py-1 px-2 border">Rp {{ number_format($sp->pivot->harga_satuan,0,',','.') }}</td>
                                    <td class="py-1 px-2 border">Rp {{ number_format($sp->pivot->jumlah * $sp->pivot->harga_satuan,0,',','.') }}</td>
                                </tr>
                            @endforeach
                        @elseif($workOrder->penggunaanSparepart->isNotEmpty())
                            @foreach($workOrder->penggunaanSparepart as $row)
                                <tr>
                                    <td class="py-1 px-2 border">{{ $row->sparepart?->nama_part ?? '-' }}</td>
                                    <td class="py-1 px-2 border">{{ $row->jumlah }}</td>
                                    <td class="py-1 px-2 border">{{ $row->sparepart?->satuan ?? '-' }}</td>
                                    <td class="py-1 px-2 border">Rp {{ number_format($row->harga_satuan,0,',','.') }}</td>
                                    <td class="py-1 px-2 border">Rp {{ number_format($row->subtotal ?? ($row->jumlah * $row->harga_satuan),0,',','.') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="py-2 px-2 border text-center" colspan="5">Tidak ada sparepart</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="text-right font-bold text-xl">Total: Rp {{ number_format($workOrder->totalHarga,0,',','.') }}</div>
                <div class="mt-6 flex justify-end">
                    @if(in_array($workOrder->status, ['selesai', 'diserahkan'], true))
                        <a href="{{ route('admin.invoice.kirim', $workOrder->id_wo) }}" target="_blank" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded mr-2">Kirim ke Pelanggan</a>
                        <a href="{{ route('admin.invoice.cetak', $workOrder->id_wo) }}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded mr-2">Cetak Invoice</a>
                    @endif
                    <a href="{{ route('admin.work-order.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
