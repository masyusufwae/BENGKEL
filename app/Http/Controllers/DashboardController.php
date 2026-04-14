<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\KendaraanPelanggan;
use App\Models\InvoiceServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Data dummy untuk dashboard admin/kepala bengkel
        $data = [
            'antrian_hari_ini' => 5,
            'mekanik_aktif' => 8,
            'pendapatan_hari_ini' => 2500000,
            'total_wo_bulan_ini' => 45,
            'layanan_populer' => [
                ['nama' => 'Service Berkala', 'jumlah' => 15],
                ['nama' => 'Perbaikan Mesin', 'jumlah' => 12],
                ['nama' => 'Ganti Oli', 'jumlah' => 10],
                ['nama' => 'Servis Rem', 'jumlah' => 8],
            ],
            'chart_data' => [
                'bulan' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                'wo' => [28, 32, 35, 42, 45, 38],
                'pendapatan' => [45000000, 52000000, 58000000, 68000000, 72000000, 65000000],
            ]
        ];

        return view('dashboard.admin', $data);
    }

    private function mekanikDashboard()
    {
        // Data dummy untuk dashboard mekanik
        $data = [
            'wo_diproses' => [
                ['id_wo' => 'WO-001', 'kendaraan' => 'Honda Civic (B 1234 ABC)', 'status' => 'dikerjakan', 'estimasi' => '2 jam'],
                ['id_wo' => 'WO-005', 'kendaraan' => 'Toyota Avanza (B 5678 XYZ)', 'status' => 'dikerjakan', 'estimasi' => '1 jam'],
            ],
            'wo_menunggu' => [
                ['id_wo' => 'WO-003', 'kendaraan' => 'Daihatsu Xenia', 'keluhan' => 'Rem bunyi', 'tanggal' => '2024-04-13'],
                ['id_wo' => 'WO-004', 'kendaraan' => 'Suzuki Ertiga', 'keluhan' => 'Radiator panas', 'tanggal' => '2024-04-13'],
            ],
            'sparepart_kosong' => [
                ['nama' => 'Kampas Rem (Depan)', 'stok' => 0, 'minimum' => 5],
                ['nama' => 'Filter Oli', 'stok' => 2, 'minimum' => 10],
            ],
            'total_wo_hari_ini' => 4,
            'wo_selesai_hari_ini' => 3,
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
            })->whereIn('status', ['antrian', 'dikerjakan', 'menunggu part']);
        })->with(['kendaraan', 'mekanik'])
        ->orderBy('tanggal_masuk', 'desc')
        ->get()
        ->map(function($wo) {
            return [
                'id_wo' => $wo->nomor_wo,
                'kendaraan' => $wo->kendaraan->merek . ' ' . $wo->kendaraan->model . ' (' . $wo->kendaraan->nomor_polisi . ')',
                'tanggal_masuk' => $wo->tanggal_masuk->format('Y-m-d H:i'),
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
                'tanggal' => $wo->tanggal_selesai->format('Y-m-d'),
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
                return [
                    'nomor_polisi' => $kendaraan->nomor_polisi,
                    'merek' => $kendaraan->merek,
                    'model' => $kendaraan->model,
                    'tahun' => $kendaraan->tahun,
                ];
            })->toArray();

        // Hitung total kendaraan
        $total_kendaraan = count($kendaraan_terdaftar);

        // Hitung total servis
        $total_servis = WorkOrder::whereHas('kendaraan', function($q) use ($user) {
            $q->where('id_pelanggan', $user->id);
        })->count();

        // Jadwal servis berikutnya (estimasi dari WO terdekat)
        $jadwal_berikutnya = WorkOrder::whereHas('kendaraan', function($q) use ($user) {
            $q->where('id_pelanggan', $user->id);
        })->where('estimasi_selesai', '>', now())
        ->orderBy('estimasi_selesai', 'asc')
        ->first();

        $jadwal_servis_berikutnya = $jadwal_berikutnya
            ? $jadwal_berikutnya->estimasi_selesai->format('Y-m-d') . ' (dalam ' . now()->diffInDays($jadwal_berikutnya->estimasi_selesai) . ' hari)'
            : 'Belum ada jadwal';

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
