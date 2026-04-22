<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;

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

    /**
     * Cetak invoice sebagai PDF (download)
     */
    public function cetak($id)
    {
        $workOrder = WorkOrder::with([
            'kendaraan.user',
            'mekanik',
            'jenisServis' => function($q) {
                $q->withPivot('harga_satuan');
            },
            'detailServis.jenisServis',
            'spareparts' => function($q) {
                $q->withPivot('jumlah', 'harga_satuan');
            },
            'penggunaanSparepart.sparepart'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('admin.invoice.invoice_pdf', compact('workOrder'));
        return $pdf->download('invoice_' . $workOrder->nomor_wo . '.pdf');
    }

    /**
     * Kirim invoice ke email pelanggan (lampiran PDF)
     */
    public function kirim($id)
    {
        $workOrder = WorkOrder::with([
            'kendaraan.user',
            'mekanik',
            'jenisServis',
            'detailServis.jenisServis',
            'spareparts',
            'penggunaanSparepart.sparepart'
        ])->findOrFail($id);

        $customerEmail = $workOrder->kendaraan?->user?->email;
        if (!$customerEmail) {
            return redirect()->back()->with('error', 'Email pelanggan tidak ditemukan.');
        }

        $pdf = Pdf::loadView('admin.invoice.invoice_pdf', compact('workOrder'));
        Mail::to($customerEmail)->send(new InvoiceMail($workOrder, $pdf));

        return redirect()->back()->with('success', 'Invoice berhasil dikirim ke email pelanggan.');
    }
}