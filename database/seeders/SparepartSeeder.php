<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SparepartSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sparepart')->insert([
            [
                'kode_part' => 'OIL-MPX1-01',
                'nama_part' => 'Oli MPX1 0.8L',
                'satuan' => 'Botol',
                'stok' => 20,
                'stok_minimum' => 5,
                'harga_beli' => 45000.00,
                'harga_jual' => 55000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_part' => 'BRK-FR-02',
                'nama_part' => 'Kampas Rem Depan (Disc Pad)',
                'satuan' => 'Pcs',
                'stok' => 15,
                'stok_minimum' => 3,
                'harga_beli' => 35000.00,
                'harga_jual' => 45000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_part' => 'BLT-V-03',
                'nama_part' => 'V-Belt Kit',
                'satuan' => 'Set',
                'stok' => 10,
                'stok_minimum' => 2,
                'harga_beli' => 125000.00,
                'harga_jual' => 150000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_part' => 'PLG-NGK-04',
                'nama_part' => 'Busi NGK CPR9',
                'satuan' => 'Pcs',
                'stok' => 30,
                'stok_minimum' => 10,
                'harga_beli' => 15000.00,
                'harga_jual' => 25000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_part' => 'FLT-AIR-05',
                'nama_part' => 'Filter Udara Vario 150',
                'satuan' => 'Pcs',
                'stok' => 12,
                'stok_minimum' => 3,
                'harga_beli' => 40000.00,
                'harga_jual' => 55000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
