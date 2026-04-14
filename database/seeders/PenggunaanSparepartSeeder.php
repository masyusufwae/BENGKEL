<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenggunaanSparepartSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil data pendukung
        $wo = DB::table('work_order')->first();
        $part = DB::table('sparepart')->where('kode_part', 'OIL-MPX1-01')->first();

        if ($wo && $part) {
            $jumlah = 1;
            $hargaSatuan = $part->harga_jual;
            $subtotal = $jumlah * $hargaSatuan;

            DB::table('penggunaan_sparepart')->insert([
                [
                    'id_wo' => $wo->id_wo,
                    'id_part' => $part->id_part,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $hargaSatuan,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }
}
