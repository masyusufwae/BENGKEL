<p>Yth. {{ $workOrder->kendaraan?->user?->name ?? 'Pelanggan' }},</p>
<p>Berikut kami lampirkan invoice untuk Work Order No. {{ $workOrder->nomor_wo }}.</p>
<p>Total tagihan: Rp {{ number_format($workOrder->totalHarga, 0, ',', '.') }}</p>
<p>Terima kasih.</p>
