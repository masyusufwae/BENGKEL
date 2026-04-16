<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $workOrders = WorkOrder::where('status', 'diserahkan')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.invoice.index', compact('workOrders'));
    }

    public function cetak($id)
    {
        $workOrder = WorkOrder::with(['mekanik', 'jenisServis', 'spareparts', 'kendaraan'])->findOrFail($id);
        return view('admin.invoice.cetak', compact('workOrder'));
    }
}