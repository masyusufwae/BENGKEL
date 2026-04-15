<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use App\Models\Mekanik;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Antrian WO hari ini (status = antrian)
        $antrian_hari_ini = WorkOrder::whereDate('tanggal_masuk', Carbon::today())
            ->where('status', 'antrian')->count();

        // Mekanik aktif
        $mekanik_aktif = Mekanik::where('status', 'aktif')->count();

        // Pendapatan hari ini (dari WO yang sudah diserahkan & sudah dibayar? misal status diserahkan dianggap lunas)
        $pendapatan_hari_ini = WorkOrder::whereDate('tanggal_selesai', Carbon::today())
            ->where('status', 'diserahkan')
            ->get()
            ->sum(function($wo) { return $wo->totalHarga; });

        // Total WO bulan ini
        $total_wo_bulan_ini = WorkOrder::whereMonth('tanggal_masuk', Carbon::now()->month)
            ->whereYear('tanggal_masuk', Carbon::now()->year)
            ->count();

        // Data chart (per bulan)
        $bulan = [];
        $wo_data = [];
        $pendapatan_data = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulan[] = Carbon::create()->month($i)->format('M');
            $wo_data[] = WorkOrder::whereMonth('tanggal_masuk', $i)
                ->whereYear('tanggal_masuk', Carbon::now()->year)
                ->count();
            $pendapatan_data[] = WorkOrder::whereMonth('tanggal_selesai', $i)
                ->whereYear('tanggal_selesai', Carbon::now()->year)
                ->where('status', 'diserahkan')
                ->get()
                ->sum(fn($wo) => $wo->totalHarga);
        }

        $chart_data = [
            'bulan' => $bulan,
            'wo' => $wo_data,
            'pendapatan' => $pendapatan_data
        ];

        // Layanan populer (dari detail_wo_servis)
        $layanan_populer = DB::table('detail_wo_servis')
            ->join('jenis_servis', 'detail_wo_servis.id_jenis', '=', 'jenis_servis.id_jenis')
            ->select('jenis_servis.nama_servis as nama', DB::raw('count(*) as jumlah'))
            ->groupBy('jenis_servis.nama_servis')
            ->orderBy('jumlah', 'desc')
            ->limit(5)
            ->get()
            ->toArray();

        return view('admin.dashboard', compact(
            'antrian_hari_ini', 'mekanik_aktif', 'pendapatan_hari_ini',
            'total_wo_bulan_ini', 'chart_data', 'layanan_populer'
        ));
    }
}