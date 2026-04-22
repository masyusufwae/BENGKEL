{{-- resources/views/admin/invoice/invoice_pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $workOrder->nomor_wo }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
            background: #fff;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            color: #4CAF50;
        }
        .header p {
            margin: 5px 0;
            color: #777;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .info-col {
            width: 48%;
        }
        .info-col p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #aaa;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
<div class="invoice-box">
    <div class="header">
        <h1>INVOICE</h1>
        <p>Bengkel System – Layanan Servis Kendaraan</p>
        <p><strong>No. WO:</strong> {{ $workOrder->nomor_wo }}</p>
    </div>

    @php
        $customerName = $workOrder->kendaraan?->user?->name ?? '-';
        $customerPhone = $workOrder->kendaraan?->user?->no_telp ?? null;
        $nomorPolisi = $workOrder->kendaraan?->nomor_polisi ?? '-';
        $merekModel = trim(($workOrder->kendaraan?->merek ?? '') . ' ' . ($workOrder->kendaraan?->model ?? ''));

        // Ambil data servis
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

        // Ambil data sparepart
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

    <div class="info-row">
        <div class="info-col">
            <p><strong>Pelanggan:</strong> {{ $customerName }}</p>
            @if($customerPhone)
                <p><strong>No. Telp:</strong> {{ $customerPhone }}</p>
            @endif
            <p><strong>Kendaraan:</strong> {{ $nomorPolisi }} {{ $merekModel ? "($merekModel)" : '' }}</p>
        </div>
        <div class="info-col">
            <p><strong>Tanggal Masuk:</strong> {{ $workOrder->tanggal_masuk->format('d/m/Y H:i') }}</p>
            <p><strong>Mekanik:</strong> {{ $workOrder->mekanik?->nama_mekanik ?? '-' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($workOrder->status) }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th class="text-right">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($servisRows as $row)
                <tr>
                    <td>Servis: {{ $row['nama'] }}</td>
                    <td class="text-right">{{ number_format($row['harga'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td>Servis: -</td>
                    <td class="text-right">0</td>
                </tr>
            @endforelse

            @forelse($partRows as $row)
                <tr>
                    <td>Sparepart: {{ $row['nama'] }} (x{{ $row['qty'] }})</td>
                    <td class="text-right">{{ number_format($row['subtotal'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td>Sparepart: -</td>
                    <td class="text-right">0</td>
                </tr>
            @endforelse

            <tr class="total-row">
                <td><strong>TOTAL</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($workOrder->totalHarga, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Terima kasih atas kepercayaan Anda.<br>
        Invoice ini dibuat secara otomatis.
    </div>
</div>
</body>
</html>