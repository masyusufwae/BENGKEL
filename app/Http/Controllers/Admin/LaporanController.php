<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'dari_tanggal' => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
        ]);

        $dari = Carbon::parse($request->dari_tanggal)->startOfDay();
        $sampai = Carbon::parse($request->sampai_tanggal)->endOfDay();

        $laporan = WorkOrder::with(['mekanik', 'jenisServis', 'spareparts'])
            ->whereBetween('tanggal_masuk', [$dari, $sampai])
            ->orderBy('tanggal_masuk')
            ->get();

        $totalPendapatan = $laporan->where('status', 'diserahkan')->sum(fn($wo) => $wo->totalHarga);
        $totalWO = $laporan->count();
        $totalSelesai = $laporan->where('status', 'selesai')->count();
        $totalDiserahkan = $laporan->where('status', 'diserahkan')->count();

        return view('admin.laporan.generate', compact(
            'laporan', 'dari', 'sampai', 'totalPendapatan', 'totalWO', 'totalSelesai', 'totalDiserahkan'
        ));
    }
}