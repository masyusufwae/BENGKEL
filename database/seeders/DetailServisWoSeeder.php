<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailServisWoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil data Work Order dan Jenis Servis yang sudah ada
        $wo = DB::table('work_order')->first();
        $servisGantiOli = DB::table('jenis_servis')->where('nama_servis', 'like', '%Oli%')->first();
        $servisTuneUp = DB::table('jenis_servis')->where('nama_servis', 'like', '%Tune Up%')->first();

        if ($wo && $servisGantiOli) {
            DB::table('detail_servis_wo')->insert([
                [
                    'id_wo' => $wo->id_wo,
                    'id_jenis' => $servisGantiOli->id_jenis,
                    'harga_jasa' => $servisGantiOli->harga_jasa, // Mengambil harga default dari master jenis_servis
                    'keterangan' => 'Ganti oli rutin',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id_wo' => $wo->id_wo,
                    'id_jenis' => $servisTuneUp->id_jenis,
                    'harga_jasa' => $servisTuneUp->harga_jasa,
                    'keterangan' => 'Pembersihan filter udara',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }
}
