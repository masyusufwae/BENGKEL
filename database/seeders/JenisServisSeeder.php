<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisServis;

class JenisServisSeeder extends Seeder
{
    public function run(): void
    {
        JenisServis::create([
            'nama_servis' => 'Ganti Oli',
            'estimasi_waktu' => 30,
            'harga_jasa' => 50000
        ]);

        JenisServis::create([
            'nama_servis' => 'Servis Mesin',
            'estimasi_waktu' => 120,
            'harga_jasa' => 150000
        ]);
    }
}