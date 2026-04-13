<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
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
        // Data dummy untuk dashboard pelanggan
        $data = [
            'wo_aktif' => [
                ['id_wo' => 'WO-001', 'kendaraan' => 'Honda Civic (B 1234 ABC)', 'tanggal_masuk' => '2024-04-12 08:00', 'status' => 'dikerjakan', 'estimasi' => '14 April 10:00'],
            ],
            'riwayat_servis' => [
                ['id_wo' => 'WO-501', 'tanggal' => '2024-03-20', 'kendaraan' => 'Honda Civic', 'jenis' => 'Service Berkala', 'total' => 750000, 'status_bayar' => 'lunas'],
                ['id_wo' => 'WO-492', 'tanggal' => '2024-03-10', 'kendaraan' => 'Honda Civic', 'jenis' => 'Ganti Oli', 'total' => 250000, 'status_bayar' => 'lunas'],
                ['id_wo' => 'WO-483', 'tanggal' => '2024-02-28', 'kendaraan' => 'Honda Civic', 'jenis' => 'Perbaikan Mesin', 'total' => 1500000, 'status_bayar' => 'lunas'],
            ],
            'kendaraan_terdaftar' => [
                ['nomor_polisi' => 'B 1234 ABC', 'merek' => 'Honda', 'model' => 'Civic', 'tahun' => 2020],
            ],
            'jadwal_servis_berikutnya' => '2024-05-12 (dalam 29 hari)',
        ];

        return view('dashboard.pelanggan', $data);
    }
}
