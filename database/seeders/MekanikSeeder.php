<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class MekanikSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil User yang memiliki role 'mekanik' dari DatabaseSeeder
        $userMekanik1 = User::where('email', 'mekanik@bengkel.com')->first();
        $userMekanik2 = User::where('email', 'mekanik2@bengkel.com')->first();

        // 2. Masukkan ke tabel mekanik menggunakan id_user yang sudah ada
        DB::table('mekanik')->insert([
            [
                'id_user' => $userMekanik1->id,
                'nip' => '19950810202401',
                'nama_mekanik' => $userMekanik1->name, // Budi Mekanik
                'spesialisasi' => 'Tune Up & Kelistrikan',
                'jam_masuk' => '08:00:00',
                'jam_keluar' => '17:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => $userMekanik2->id,
                'nip' => '19970112202402',
                'nama_mekanik' => $userMekanik2->name, // Anto Bengkel
                'spesialisasi' => 'Overhaul Mesin',
                'jam_masuk' => '09:00:00',
                'jam_keluar' => '18:00:00',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
