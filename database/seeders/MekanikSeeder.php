<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mekanik;

class MekanikSeeder extends Seeder
{
    public function run(): void
    {
        Mekanik::create([
            'nama_mekanik' => 'Budi',
            'nip' => 'M001',
            'spesialisasi' => 'Mesin',
            'status' => 'aktif'
        ]);

        Mekanik::create([
            'nama_mekanik' => 'Andi',
            'nip' => 'M002',
            'spesialisasi' => 'Kelistrikan',
            'status' => 'aktif'
        ]);
    }
}

?>