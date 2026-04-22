@extends('admin.layouts.app')
@section('title', 'Invoice WO - '.$workOrder->nomor_wo)
@section('content')
@php
    $customerName = $workOrder->kendaraan?->user?->name ?? '-';
    $customerPhone = $workOrder->kendaraan?->user?->no_telp ?? null;
    $nomorPolisi = $workOrder->kendaraan?->nomor_polisi ?? '-';
    $merekModel = trim(($workOrder->kendaraan?->merek ?? '') . ' ' . ($workOrder->kendaraan?->model ?? ''));

    $servisRows = collect();
    if ($workOrder->jenisServis->isNotEmpty()) {
        $servisRows = $workOrder->jenisServis->map(fn ($s) => [
            'nama' => $s->nama_servis,
            'harga' => (float) ($s->pivot->harga_satuan ?? 0),
        ]);
    } elseif ($workOrder->detailServis->isNotEmpty()) {
        $servisRows = $workOrder->detailServis->map(fn ($d) => [
            'nama' => $d->jenisServis?->nama_servis ?? '-',
            'harga' => (float) ($d->harga_jasa ?? 0),
        ]);
    }

    $partRows = collect();
    if ($workOrder->spareparts->isNotEmpty()) {
        $partRows = $workOrder->spareparts->map(function ($p) {
            $qty = (int) ($p->pivot->jumlah ?? 0);
            $harga = (float) ($p->pivot->harga_satuan ?? 0);
            return [
                'nama' => $p->nama_part,
                'qty' => $qty,
                'subtotal' => $qty * $harga,
            ];
        });
    } elseif ($workOrder->penggunaanSparepart->isNotEmpty()) {
        $partRows = $workOrder->penggunaanSparepart->map(function ($row) {
            $qty = (int) ($row->jumlah ?? 0);
            $harga = (float) ($row->harga_satuan ?? 0);
            return [
                'nama' => $row->sparepart?->nama_part ?? '-',
                'qty' => $qty,
                'subtotal' => (float) ($row->subtotal ?? ($qty * $harga)),
            ];
        });
    }
@endphp
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold">INVOICE</h1>
                <p class="text-gray-600">Bengkel System</p>
                <p class="text-sm">No. WO: {{ $workOrder->nomor_wo }}</p>
            </div>
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4">{{ session('error') }}</div>
            @endif
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p><strong>Customer:</strong> {{ $customerName }}</p>
                    @if($customerPhone)
                        <p><strong>No. Telp:</strong> {{ $customerPhone }}</p>
                    @endif
                    <p><strong>Kendaraan:</strong> {{ $nomorPolisi }}{{ $merekModel !== '' ? " ({$merekModel})" : '' }}</p>
                </div>
                <div>
                    <p><strong>Tanggal Masuk:</strong> {{ $workOrder->tanggal_masuk->format('d/m/Y H:i') }}</p>
                    <p><strong>Mekanik:</strong> {{ $workOrder->mekanik?->nama_mekanik ?? '-' }}</p>
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
                    @forelse($servisRows as $row)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">Servis: {{ $row['nama'] }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">Rp {{ number_format($row['harga'],0,',','.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">Servis: -</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">Rp 0</td>
                        </tr>
                    @endforelse

                    @forelse($partRows as $row)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">Sparepart: {{ $row['nama'] }} (x{{ $row['qty'] }})</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">Rp {{ number_format($row['subtotal'],0,',','.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">Sparepart: -</td>
                            <td class="border border-gray-300 px-4 py-2 text-right">Rp 0</td>
                        </tr>
                    @endforelse
                    <tr class="font-bold">
                        <td class="border border-gray-300 px-4 py-2">Total</td>
                        <td class="border border-gray-300 px-4 py-2 text-right">Rp {{ number_format($workOrder->totalHarga,0,',','.') }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-end space-x-2">
                <button onclick="window.print()" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">Cetak Invoice</button>
                <a href="{{ route('admin.invoice.kirim', $workOrder->id_wo) }}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Kirim ke Pelanggan</a>
                <a href="{{ route('admin.invoice.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
