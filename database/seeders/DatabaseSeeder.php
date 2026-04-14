<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User - Kepala Bengkel
        User::create([
            'name' => 'Kepala Bengkel',
            'email' => 'admin@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'no_telp' => '+62812345678',
            'alamat' => 'Jl. Merdeka No. 123, Jakarta',
            'email_verified_at' => now(),
        ]);

        // 2. Create Mekanik Users
        User::create([
            'name' => 'Budi Mekanik',
            'email' => 'mekanik@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'mekanik',
            'no_telp' => '+62812345679',
            'alamat' => 'Jl. Setiabudi No. 45, Jakarta',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Anto Bengkel',
            'email' => 'mekanik2@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'mekanik',
            'no_telp' => '+62812345680',
            'alamat' => 'Jl. Gatot Subroto No. 10, Jakarta',
            'email_verified_at' => now(),
        ]);

        // 3. Create Customer Users
        User::create([
            'name' => 'Pelanggan Setia',
            'email' => 'pelanggan@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
            'no_telp' => '+62812345681',
            'alamat' => 'Jl. Sudirman No. 888, Jakarta',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Bambang Sukendar',
            'email' => 'bambang@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
            'no_telp' => '+62812345682',
            'alamat' => 'Jl. Thamrin No. 77, Jakarta',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
            'no_telp' => '+62812345683',
            'alamat' => 'Jl. Hayam Wuruk No. 50, Jakarta',
            'email_verified_at' => now(),
        ]);

        // 4. Test User untuk keperluan debugging sistem
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'pelanggan', // Pastikan role ini ada agar tidak error
        ]);


        $this->call([
            // Master
            JenisServisSeeder::class,
            SparepartSeeder::class,

            // Relasi User
            MekanikSeeder::class,
            KendaraanPelangganSeeder::class,

            // Transaksi
            WorkOrderSeeder::class,
            DetailServisWoSeeder::class,
            PenggunaanSparepartSeeder::class,

            // Final Document
            InvoiceServisSeeder::class, // Tambahkan ini
        ]);
    }
}
