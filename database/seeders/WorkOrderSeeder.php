<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Mekanik;
use App\Models\KendaraanPelanggan;

class WorkOrderSeeder extends Seeder
{
    public function run(): void
{
    $kendaraan = DB::table('kendaraan_pelanggan')->first();
    $mekanik = DB::table('mekanik')->first();
    $sparepart = DB::table('sparepart')->first();


    if ($kendaraan && $mekanik) {
        // sparepart primary key is id_part (not id_sparepart).
        $idSparepart = $sparepart?->id_part;

        DB::table('work_order')->insert([
            [
                'nomor_wo' => 'WO-' . date('Ymd') . '-001',
                'id_kendaraan' => $kendaraan->id_kendaraan,
                'id_mekanik' => $mekanik->id_mekanik,
                'id_sparepart' => $idSparepart, // boleh null (WO bisa punya sparepart via tabel penggunaan_sparepart)
                'keluhan' => 'Ganti oli dan rem belakang bunyi decit',
                'tanggal_masuk' => now(),
                'estimasi_selesai' => now()->addHours(2), // Ini ada
                'tanggal_selesai' => null,
                'status' => 'dikerjakan',
                'catatan_mekanik' => 'Kampas rem belakang sudah tipis, perlu ganti.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_wo' => 'WO-' . date('Ymd') . '-002',
                'id_kendaraan' => $kendaraan->id_kendaraan,
                'id_mekanik' => $mekanik->id_mekanik,
                'id_sparepart' => $idSparepart,
                'keluhan' => 'Motor sering mati mendadak saat macet',
                'tanggal_masuk' => now()->subDay(),
                'estimasi_selesai' => now()->subDay()->addHours(2), // TAMBAHKAN INI AGAR STRUKTUR SAMA
                'tanggal_selesai' => now()->subDay()->addHours(3),
                'status' => 'selesai',
                'catatan_mekanik' => 'Setelan stasioner terlalu rendah, sudah diperbaiki.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
}
