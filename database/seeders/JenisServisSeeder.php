<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisServisSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jenis_servis')->insert([
            [
                'nama_servis' => 'Ganti Oli & Cek Rutin',
                'deskripsi' => 'Penggantian oli mesin, pembersihan filter udara, dan pengecekan baut-baut.',
                'estimasi_waktu' => 30,
                'harga_jasa' => 35000.00,
                'kategori' => 'ringan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_servis' => 'Service CVT / Tune Up',
                'deskripsi' => 'Pembersihan bagian transmisi otomatis, pengecekan v-belt, dan setel klep.',
                'estimasi_waktu' => 60,
                'harga_jasa' => 75000.00,
                'kategori' => 'sedang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_servis' => 'Turun Mesin (Overhaul)',
                'deskripsi' => 'Perbaikan besar pada bagian blok mesin dan penggantian piston.',
                'estimasi_waktu' => 300,
                'harga_jasa' => 500000.00,
                'kategori' => 'berat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_servis' => 'Ganti Kampas Rem',
                'deskripsi' => 'Penggantian kampas rem depan atau belakang beserta pembersihan kaliper.',
                'estimasi_waktu' => 20,
                'harga_jasa' => 25000.00,
                'kategori' => 'ringan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
