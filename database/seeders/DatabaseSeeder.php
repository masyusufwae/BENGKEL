<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mekanik;
use App\Models\KendaraanPelanggan;
use App\Models\WorkOrder;
use App\Models\InvoiceServis;
use App\Models\JenisServis;
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
        $admin = User::create([
            'name' => 'Kepala Bengkel',
            'email' => 'admin@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'no_telp' => '+62812345678',
            'alamat' => 'Jl. Merdeka No. 123, Jakarta',
            'email_verified_at' => now(),
        ]);

        // 2. Create Mekanik Users
        $mekanik1 = User::create([
            'name' => 'Budi Mekanik',
            'email' => 'mekanik@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'mekanik',
            'no_telp' => '+62812345679',
            'alamat' => 'Jl. Setiabudi No. 45, Jakarta',
            'email_verified_at' => now(),
        ]);

        $mekanik2 = User::create([
            'name' => 'Anto Bengkel',
            'email' => 'mekanik2@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'mekanik',
            'no_telp' => '+62812345680',
            'alamat' => 'Jl. Gatot Subroto No. 10, Jakarta',
            'email_verified_at' => now(),
        ]);

        // Create Mekanik records linked to User
        Mekanik::create([
            'id_user' => $mekanik1->id,
            'nama_mekanik' => 'Budi Mekanik',
            'nip' => 'MK001',
            'spesialisasi' => 'Engine & Transmission',
            'jam_masuk' => '08:00',
            'jam_keluar' => '17:00',
            'status' => 'aktif',
        ]);

        Mekanik::create([
            'id_user' => $mekanik2->id,
            'nama_mekanik' => 'Anto Bengkel',
            'nip' => 'MK002',
            'spesialisasi' => 'Electrical & Air Conditioning',
            'jam_masuk' => '08:00',
            'jam_keluar' => '17:00',
            'status' => 'aktif',
        ]);

        // 3. Create Customer Users
        $pelanggan1 = User::create([
            'name' => 'Pelanggan Setia',
            'email' => 'pelanggan@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
            'no_telp' => '+62812345681',
            'alamat' => 'Jl. Sudirman No. 888, Jakarta',
            'email_verified_at' => now(),
        ]);

        $pelanggan2 = User::create([
            'name' => 'Bambang Sukendar',
            'email' => 'bambang@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
            'no_telp' => '+62812345682',
            'alamat' => 'Jl. Thamrin No. 77, Jakarta',
            'email_verified_at' => now(),
        ]);

        $pelanggan3 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
            'no_telp' => '+62812345683',
            'alamat' => 'Jl. Hayam Wuruk No. 50, Jakarta',
            'email_verified_at' => now(),
        ]);

        // 4. Create Jenis Servis
        $servis1 = JenisServis::create([
            'nama_servis' => 'Service Berkala',
            'deskripsi' => 'Service rutin berkala mobil',
            'estimasi_waktu' => 120,
            'harga_jasa' => 500000,
            'kategori' => 'ringan',
        ]);

        $servis2 = JenisServis::create([
            'nama_servis' => 'Ganti Oli',
            'deskripsi' => 'Penggantian oli mesin',
            'estimasi_waktu' => 30,
            'harga_jasa' => 200000,
            'kategori' => 'ringan',
        ]);

        $servis3 = JenisServis::create([
            'nama_servis' => 'Perbaikan Mesin',
            'deskripsi' => 'Perbaikan mesin kendaraan',
            'estimasi_waktu' => 240,
            'harga_jasa' => 1000000,
            'kategori' => 'berat',
        ]);

        $servis4 = JenisServis::create([
            'nama_servis' => 'Servis Rem',
            'deskripsi' => 'Servis dan perbaikan sistem rem',
            'estimasi_waktu' => 90,
            'harga_jasa' => 400000,
            'kategori' => 'sedang',
        ]);

        // 5. Create Kendaraan Pelanggan
        $kendaraan1 = KendaraanPelanggan::create([
            'id_pelanggan' => $pelanggan1->id,
            'nomor_polisi' => 'B 1234 ABC',
            'merek' => 'Honda',
            'model' => 'Civic',
            'tahun' => 2020,
            'warna' => 'Hitam',
            'nomor_rangka' => 'MHESJ5190LM000001',
            'nomor_mesin' => 'R18Z1000001',
            'jenis_bahan_bakar' => 'Bensin',
        ]);

        $kendaraan2 = KendaraanPelanggan::create([
            'id_pelanggan' => $pelanggan1->id,
            'nomor_polisi' => 'B 5678 XYZ',
            'merek' => 'Toyota',
            'model' => 'Avanza',
            'tahun' => 2021,
            'warna' => 'Silver',
            'nomor_rangka' => 'WVWZZZ3CZ9E123456',
            'nomor_mesin' => 'K3VE000001',
            'jenis_bahan_bakar' => 'Bensin',
        ]);

        $kendaraan3 = KendaraanPelanggan::create([
            'id_pelanggan' => $pelanggan2->id,
            'nomor_polisi' => 'B 9999 QQQ',
            'merek' => 'Suzuki',
            'model' => 'Ertiga',
            'tahun' => 2019,
            'warna' => 'Putih',
            'nomor_rangka' => 'JTHBL5C12K2012345',
            'nomor_mesin' => 'K12B000001',
            'jenis_bahan_bakar' => 'Bensin',
        ]);

        $kendaraan4 = KendaraanPelanggan::create([
            'id_pelanggan' => $pelanggan3->id,
            'nomor_polisi' => 'B 1111 RRR',
            'merek' => 'Daihatsu',
            'model' => 'Xenia',
            'tahun' => 2022,
            'warna' => 'Merah',
            'nomor_rangka' => 'FNBSS54WXX0000001',
            'nomor_mesin' => 'K3VE000002',
            'jenis_bahan_bakar' => 'Bensin',
        ]);

        // 6. Create Work Orders (history dan aktif)
        $mekanikData = Mekanik::first();

        // Riwayat selesai
        $wo1 = WorkOrder::create([
            'id_kendaraan' => $kendaraan1->id_kendaraan,
            'id_mekanik' => $mekanikData->id_mekanik,
            'nomor_wo' => 'WO-001',
            'keluhan' => 'Service Berkala',
            'tanggal_masuk' => now()->subDays(20),
            'tanggal_selesai' => now()->subDays(19),
            'estimasi_selesai' => now()->subDays(19),
            'status' => 'selesai',
            'catatan_mekanik' => 'Service rutin selesai dengan lancar',
        ]);

        $wo2 = WorkOrder::create([
            'id_kendaraan' => $kendaraan1->id_kendaraan,
            'id_mekanik' => $mekanikData->id_mekanik,
            'nomor_wo' => 'WO-002',
            'keluhan' => 'Ganti Oli',
            'tanggal_masuk' => now()->subDays(10),
            'tanggal_selesai' => now()->subDays(9),
            'estimasi_selesai' => now()->subDays(9),
            'status' => 'selesai',
            'catatan_mekanik' => 'Oli sudah diganti dengan tipe yang sesuai',
        ]);

        // Work order aktif
        $wo3 = WorkOrder::create([
            'id_kendaraan' => $kendaraan1->id_kendaraan,
            'id_mekanik' => $mekanikData->id_mekanik,
            'nomor_wo' => 'WO-003',
            'keluhan' => 'Servis Rem - bunyi menggereget',
            'tanggal_masuk' => now(),
            'tanggal_selesai' => null,
            'estimasi_selesai' => now()->addDays(1),
            'status' => 'dikerjakan',
            'catatan_mekanik' => 'Sedang mengalihkan kampas rem depan',
        ]);

        $wo4 = WorkOrder::create([
            'id_kendaraan' => $kendaraan2->id_kendaraan,
            'id_mekanik' => $mekanikData->id_mekanik,
            'nomor_wo' => 'WO-004',
            'keluhan' => 'AC tidak dingin',
            'tanggal_masuk' => now()->subHours(3),
            'tanggal_selesai' => null,
            'estimasi_selesai' => now()->addHours(4),
            'status' => 'dikerjakan',
            'catatan_mekanik' => 'Sedang mengisi freon AC',
        ]);

        // 7. Create Invoices untuk Work Order yang selesai
        InvoiceServis::create([
            'id_wo' => $wo1->id_wo,
            'nomor_invoice' => 'INV-001',
            'total_jasa' => 500000,
            'total_part' => 200000,
            'diskon' => 0,
            'pajak' => 0,
            'total_bayar' => 700000,
            'status_bayar' => 'lunas',
            'tanggal_bayar' => now()->subDays(19),
        ]);

        InvoiceServis::create([
            'id_wo' => $wo2->id_wo,
            'nomor_invoice' => 'INV-002',
            'total_jasa' => 200000,
            'total_part' => 150000,
            'diskon' => 0,
            'pajak' => 0,
            'total_bayar' => 350000,
            'status_bayar' => 'lunas',
            'tanggal_bayar' => now()->subDays(9),
        ]);

        // 4. Test User untuk keperluan debugging sistem
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'pelanggan',
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
