<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $workOrders = WorkOrder::with([
            'mekanik',
            'kendaraan.user',
            'jenisServis',
            'spareparts',
            'detailServis.jenisServis',
            'penggunaanSparepart.sparepart',
        ])->whereIn('status', ['selesai', 'diserahkan'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.invoice.index', compact('workOrders'));
    }

    public function cetak($id)
    {
        $workOrder = WorkOrder::with([
            'mekanik',
            'kendaraan.user',
            'jenisServis',
            'spareparts',
            'detailServis.jenisServis',
            'penggunaanSparepart.sparepart',
        ])->findOrFail($id);
        return view('admin.invoice.cetak', compact('workOrder'));
    }

    public function kirim($id)
    {
        $workOrder = WorkOrder::with([
            'mekanik',
            'kendaraan.user',
            'jenisServis',
            'spareparts',
            'detailServis.jenisServis',
            'penggunaanSparepart.sparepart',
        ])->findOrFail($id);

        $customer = $workOrder->kendaraan?->user;
        $rawPhone = $customer?->no_telp;

        if (!$customer || !$rawPhone) {
            return back()->with('error', 'Nomor telepon pelanggan belum diisi.');
        }

        // Normalize to WhatsApp format (digits only). Prefer Indonesia defaults if user entered local formats.
        $phone = preg_replace('/\\D+/', '', (string) $rawPhone);
        if ($phone === '') {
            return back()->with('error', 'Nomor telepon pelanggan tidak valid.');
        }
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }

        $kendaraan = $workOrder->kendaraan;
        $nomorPolisi = $kendaraan?->nomor_polisi ?? '-';
        $merekModel = trim(($kendaraan?->merek ?? '') . ' ' . ($kendaraan?->model ?? ''));

        $servisRows = [];
        if ($workOrder->jenisServis->isNotEmpty()) {
            foreach ($workOrder->jenisServis as $servis) {
                $servisRows[] = [
                    'nama' => $servis->nama_servis,
                    'harga' => (float) ($servis->pivot->harga_satuan ?? 0),
                ];
            }
        } elseif ($workOrder->detailServis->isNotEmpty()) {
            foreach ($workOrder->detailServis as $detail) {
                $servisRows[] = [
                    'nama' => $detail->jenisServis?->nama_servis ?? '-',
                    'harga' => (float) ($detail->harga_jasa ?? 0),
                ];
            }
        }

        $partRows = [];
        if ($workOrder->spareparts->isNotEmpty()) {
            foreach ($workOrder->spareparts as $sp) {
                $qty = (int) ($sp->pivot->jumlah ?? 0);
                $unitPrice = (float) ($sp->pivot->harga_satuan ?? 0);
                $partRows[] = [
                    'nama' => $sp->nama_part,
                    'qty' => $qty,
                    'subtotal' => $qty * $unitPrice,
                ];
            }
        } elseif ($workOrder->penggunaanSparepart->isNotEmpty()) {
            foreach ($workOrder->penggunaanSparepart as $row) {
                $qty = (int) ($row->jumlah ?? 0);
                $unitPrice = (float) ($row->harga_satuan ?? 0);
                $partRows[] = [
                    'nama' => $row->sparepart?->nama_part ?? '-',
                    'qty' => $qty,
                    'subtotal' => (float) ($row->subtotal ?? ($qty * $unitPrice)),
                ];
            }
        }

        $lines = [];
        $lines[] = "Halo {$customer->name},";
        $lines[] = "Berikut rincian pesanan servis Anda:";
        $lines[] = "No. WO: {$workOrder->nomor_wo}";
        $lines[] = "Kendaraan: {$nomorPolisi}" . ($merekModel !== '' ? " ({$merekModel})" : '');
        $lines[] = "";

        $lines[] = "Rincian Servis:";
        if (count($servisRows) === 0) {
            $lines[] = "- (tidak ada)";
        } else {
            foreach ($servisRows as $row) {
                $harga = number_format($row['harga'], 0, ',', '.');
                $lines[] = "- {$row['nama']} : Rp {$harga}";
            }
        }
        $lines[] = "";

        $lines[] = "Rincian Sparepart:";
        if (count($partRows) === 0) {
            $lines[] = "- (tidak ada)";
        } else {
            foreach ($partRows as $row) {
                $subtotal = number_format($row['subtotal'], 0, ',', '.');
                $lines[] = "- {$row['nama']} (x{$row['qty']}) : Rp {$subtotal}";
            }
        }
        $lines[] = "";

        $lines[] = "Total: Rp " . number_format($workOrder->totalHarga, 0, ',', '.');
        $lines[] = "Terima kasih.";

        $message = implode("\n", $lines);
        $waUrl = 'https://wa.me/' . $phone . '?text=' . rawurlencode($message);

        return redirect()->away($waUrl);
    }
}
