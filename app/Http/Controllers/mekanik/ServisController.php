<?php

namespace App\Http\Controllers;

use App\Models\JenisServis;
use App\Models\Sparepart;
use App\Models\WorkOrder;
use Illuminate\Http\Request;

class ServisController extends Controller
{
    public function show($id)
{
    $wo = WorkOrder::with([
        'kendaraan.user',
        'detailServis.jenisServis',
        'penggunaanSparepart.sparepart'
    ])->findOrFail($id);

    $jenisServis = JenisServis::all();
    $sparepart = Sparepart::all();

    return view('mekanik.work-order.detail', compact(
        'wo',
        'jenisServis',
        'sparepart'
    ));
}
}
