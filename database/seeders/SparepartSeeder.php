<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sparepart;

class SparepartSeeder extends Seeder
{
    public function run(): void
    {
        Sparepart::create([
            'nama_part' => 'Oli Mesin',
            'stok' => 50,
            'harga_jual' => 75000
        ]);

        Sparepart::create([
            'nama_part' => 'Busi',
            'stok' => 30,
            'harga_jual' => 25000
        ]);
    }
}