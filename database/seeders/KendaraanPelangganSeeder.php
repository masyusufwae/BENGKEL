<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class KendaraanPelangganSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil User yang memiliki role 'pelanggan' dari DatabaseSeeder
        $pelanggan1 = User::where('email', 'pelanggan@bengkel.com')->first();
        $pelanggan2 = User::where('email', 'bambang@bengkel.com')->first();

        // 2. Masukkan data kendaraan yang terhubung ke id_pelanggan tersebut
        DB::table('kendaraan_pelanggan')->insert([
            [
                'id_pelanggan' => $pelanggan1->id,
                'nomor_polisi' => 'AB 1234 XY',
                'merek' => 'Honda',
                'model' => 'Vario 150',
                'tahun' => 2021,
                'warna' => 'Hitam Dove',
                'nomor_rangka' => 'MHIJFB123456789',
                'nomor_mesin' => 'JFB1E1234567',
                'jenis_bahan_bakar' => 'Pertamax',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pelanggan' => $pelanggan2->id,
                'nomor_polisi' => 'B 9876 ZZZ',
                'merek' => 'Yamaha',
                'model' => 'NMAX',
                'tahun' => 2022,
                'warna' => 'Biru',
                'nomor_rangka' => 'MHIYMH987654321',
                'nomor_mesin' => 'YMH2E9876543',
                'jenis_bahan_bakar' => 'Pertamax Turbo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
