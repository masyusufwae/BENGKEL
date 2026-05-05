<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\KendaraanPelanggan;
use App\Models\InvoiceServis;
use App\Models\Sparepart;
use App\Helpers\ServiceScheduleHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Redirect berdasarkan role
        return match($user->role) {
            'admin' => $this->adminDashboard(),
            'mekanik' => $this->mekanikDashboard(),
            'pelanggan' => $this->pelangganDashboard(),
            default => redirect('/'),
        };
    }

    private function adminDashboard()
    {
        $today = Carbon::today();
        $monthStart = Carbon::now()->startOfMonth();

        // Real stats
        $antrian_hari_ini = WorkOrder::where('status', 'antrian')
            ->whereDate('tanggal_masuk', $today)
            ->count();
        $mekanik_aktif = WorkOrder::where('status', 'dikerjakan')
            ->distinct('id_mekanik')
            ->count('id_mekanik');
        $pendapatan_hari_ini = InvoiceServis::whereHas('workOrder', fn($q) => $q->whereDate('tanggal_masuk', $today))
            ->where('status_bayar', 'lunas')
            ->sum('total_bayar');
        $total_wo_bulan_ini = WorkOrder::where('status', 'selesai')
            ->whereBetween('tanggal_selesai', [$monthStart, now()])
            ->count();

        // Layanan populer (from detail_servis_wo or jenis_servis)
        $layanan_populer = WorkOrder::whereBetween('tanggal_selesai', [$monthStart, now()])
            ->with('detailServis.jenisServis')
            ->get()
            ->flatMap(fn($wo) => $wo->detailServis)
            ->groupBy('jenis_servis')
            ->map(fn($group) => ['nama' => $group->first()->jenis_servis, 'jumlah' => $group->count()])
            ->sortByDesc('jumlah')
            ->take(4)
            ->values()
            ->toArray();

        // Chart data (last 6 months)
        $months = collect();
        $woData = collect();
        $revenueData = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push($date->format('M'));
            $woData->push(WorkOrder::whereMonth('tanggal_selesai', $date->month)
                ->whereYear('tanggal_selesai', $date->year)
                ->where('status', 'selesai')
                ->count());
            $revenueData->push(InvoiceServis::whereHas('workOrder', fn($q) => $q->whereMonth('tanggal_selesai', $date->month)
                ->whereYear('tanggal_selesai', $date->year))
                ->where('status_bayar', 'lunas')
                ->sum('total_bayar'));
        }

        $data = [
            'antrian_hari_ini' => $antrian_hari_ini,
            'mekanik_aktif' => $mekanik_aktif,
            'pendapatan_hari_ini' => $pendapatan_hari_ini,
            'total_wo_bulan_ini' => $total_wo_bulan_ini,
            'layanan_populer' => $layanan_populer,
            'chart_data' => [
                'bulan' => $months->toArray(),
                'wo' => $woData->toArray(),
                'pendapatan' => $revenueData->toArray(),
            ]
        ];

        return view('dashboard.admin', $data);
    }

private function mekanikDashboard()
    {
        $today = Carbon::today();

        $wo_antrian = WorkOrder::where('status', 'antrian')->count();
        $wo_diproses = WorkOrder::where('status', 'dikerjakan')
            ->with('kendaraan')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($wo) {
                return [
                    'id_wo' => $wo->nomor_wo,
                    'kendaraan' => $wo->kendaraan->merek . ' ' . $wo->kendaraan->model . ' (' . $wo->kendaraan->nomor_polisi . ')',
                    'status' => $wo->status,
                    'estimasi' => $wo->estimasi_selesai?->format('d M Y H:i') ?? 'Belum ditentukan',
                ];
            });
        $wo_menunggu = WorkOrder::where('status', 'antrian')
            ->with('kendaraan')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($wo) {
                return [
                    'id_wo' => $wo->nomor_wo,
                    'kendaraan' => $wo->kendaraan->merek . ' ' . $wo->kendaraan->model,
                    'keluhan' => Str::limit($wo->keluhan, 50),
                    'tanggal' => $wo->tanggal_masuk->format('d/m'),
                ];
            });
        $sparepart_kosong = Sparepart::whereColumn('stok', '<=', 'stok_minimum')
            ->take(5)
            ->get()
            ->map(function ($part) {
                return [
                    'nama' => $part->nama_part,
                    'stok' => $part->stok,
                    'minimum' => $part->stok_minimum,
                ];
            });
        $total_wo_hari_ini = WorkOrder::whereDate('tanggal_masuk', $today)->count();
        $wo_selesai_hari_ini = WorkOrder::where('status', 'selesai')
            ->whereDate('tanggal_selesai', $today)
            ->count();

        $data = [
            'wo_antrian_count' => $wo_antrian,
            'wo_diproses' => $wo_diproses,
            'wo_menunggu' => $wo_menunggu,
            'sparepart_kosong' => $sparepart_kosong,
            'total_wo_hari_ini' => $total_wo_hari_ini,
            'wo_selesai_hari_ini' => $wo_selesai_hari_ini,
        ];

        return view('dashboard.mekanik', $data);
    }

    private function pelangganDashboard()
    {
        $user = Auth::user();

        // Ambil data Work Order aktif pelanggan dari database
        $wo_aktif = WorkOrder::where(function($query) use ($user) {
            // Ambil WO untuk kendaraan pelanggan ini yang masih aktif
            $query->whereHas('kendaraan', function($q) use ($user) {
                $q->where('id_pelanggan', $user->id);
            })->whereIn('status', ['antrian', 'dikerjakan', 'menunggu_part']);
        })->with(['kendaraan', 'mekanik'])
        ->orderBy('tanggal_masuk', 'desc')
        ->get()
        ->map(function($wo) {
            return [
                'id_wo' => $wo->nomor_wo,
                'kendaraan' => $wo->kendaraan->merek . ' ' . $wo->kendaraan->model . ' (' . $wo->kendaraan->nomor_polisi . ')',
                // Tambahkan ?-> dan fallback string jika kosong
                'tanggal_masuk' => $wo->tanggal_masuk?->format('Y-m-d H:i') ?? '-',
                'status' => $wo->status,
                'estimasi' => $wo->estimasi_selesai ? $wo->estimasi_selesai->format('d M Y H:i') : 'Belum ditentukan',
            ];
        })->toArray();

        // Ambil riwayat servis (Work Order yang sudah selesai)
        $riwayat_servis = WorkOrder::where(function($query) use ($user) {
            $query->whereHas('kendaraan', function($q) use ($user) {
                $q->where('id_pelanggan', $user->id);
            })->where('status', 'selesai');
        })->with(['kendaraan', 'invoice'])
        ->orderBy('tanggal_selesai', 'desc')
        ->limit(10)
        ->get()
        ->map(function($wo) {
            $invoice = $wo->invoice->first();
            return [
                'id_wo' => $wo->nomor_wo,
                // Tambahkan ?-> dan fallback string jika kosong
                'tanggal' => $wo->tanggal_selesai?->format('Y-m-d') ?? 'Belum Selesai',
                'kendaraan' => $wo->kendaraan->merek . ' ' . $wo->kendaraan->model,
                'jenis' => $wo->keluhan,
                'total' => $invoice ? $invoice->total_bayar : 0,
                'status_bayar' => $invoice ? $invoice->status_bayar : 'belum',
            ];
        })->toArray();

        // Ambil kendaraan terdaftar milik pelanggan
        $kendaraan_terdaftar = KendaraanPelanggan::where('id_pelanggan', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($kendaraan) {
                // Ambil service terakhir yang selesai untuk kendaraan ini
                $lastService = WorkOrder::where('id_kendaraan', $kendaraan->id_kendaraan)
                    ->where('status', 'selesai')
                    ->orderBy('tanggal_selesai', 'desc')
                    ->first();

                // Hitung jadwal servis berikutnya
                $nextServiceDate = $lastService?->tanggal_selesai ?? $kendaraan->created_at ?? now();

                $scheduleInfo = ServiceScheduleHelper::calculateNextService($kendaraan->merek, $nextServiceDate);

                return [
                    'id_kendaraan' => $kendaraan->id_kendaraan,
                    'nomor_polisi' => $kendaraan->nomor_polisi,
                    'merek' => $kendaraan->merek,
                    'model' => $kendaraan->model,
                    'tahun' => $kendaraan->tahun,
                    'jadwal_servis' => $scheduleInfo['text'],
                    'jadwal_tanggal' => $scheduleInfo['date']->format('Y-m-d'),
                    'jadwal_status' => $scheduleInfo['status'],
                    'jadwal_is_overdue' => $scheduleInfo['is_overdue'],
                    'jadwal_icon' => ServiceScheduleHelper::getStatusIcon($scheduleInfo['status']),
                    'days_remaining' => $scheduleInfo['days_remaining'],
                ];
            })
            // Sort berdasarkan urgency (overdue/urgent/warning/normal) dan days remaining
            ->sortBy(function($item) {
                $priority = ['overdue' => 0, 'urgent' => 1, 'warning' => 2, 'normal' => 3];
                return [$priority[$item['jadwal_status']] ?? 99, $item['days_remaining']];
            })
            // Ambil hanya 2 kendaraan yang paling urgent
            ->slice(0, 2)
            ->toArray();

        // Hitung total kendaraan
        $total_kendaraan = count($kendaraan_terdaftar);

        // Hitung total servis
        $total_servis = WorkOrder::whereHas('kendaraan', function($q) use ($user) {
            $q->where('id_pelanggan', $user->id);
        })->count();

        // Jadwal servis berikutnya (dari semua kendaraan, cari yang paling urgent)
        $allNextServices = [];
        $vehicles = KendaraanPelanggan::where('id_pelanggan', $user->id)->get();

        foreach ($vehicles as $vehicle) {
            $lastService = WorkOrder::where('id_kendaraan', $vehicle->id_kendaraan)
                ->where('status', 'selesai')
                ->orderBy('tanggal_selesai', 'desc')
                ->first();

            $serviceDate = $lastService?->tanggal_selesai ?? $vehicle->created_at ?? now();
            $scheduleInfo = ServiceScheduleHelper::calculateNextService($vehicle->merek, $serviceDate);

            $allNextServices[] = [
                'vehicle' => $vehicle->merek . ' ' . $vehicle->model,
                'next_date' => $scheduleInfo['date'],
                'text' => $scheduleInfo['text'],
                'status' => $scheduleInfo['status'],
            ];
        }

        // Urutkan berdasarkan tanggal (paling dekat dulu)
        usort($allNextServices, function($a, $b) {
            return $a['next_date'] <=> $b['next_date'];
        });

        $jadwal_servis_berikutnya = count($allNextServices) > 0
            ? $allNextServices[0]['text'] . ' (' . $allNextServices[0]['vehicle'] . ')'
            : 'Belum ada data kendaraan';

        $data = [
            'wo_aktif' => $wo_aktif,
            'riwayat_servis' => $riwayat_servis,
            'kendaraan_terdaftar' => $kendaraan_terdaftar,
            'jadwal_servis_berikutnya' => $jadwal_servis_berikutnya,
            'total_kendaraan' => $total_kendaraan,
            'total_servis' => $total_servis,
            'total_wo_aktif' => count($wo_aktif),
        ];

        return view('customer.dashboard.index', $data);
    }
}
