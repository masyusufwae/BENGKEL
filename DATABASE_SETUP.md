# SETUP DATABASE - DASHBOARD PELANGGAN DINAMIS

## Langkah-Langkah Setup

### 1. Kembali ke MySQL Configuration
Edit file `.env` dan pastikan:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bengkel
DB_USERNAME=root
DB_PASSWORD=
```

###  2. Start Laragon Services
- Buka Laragon dari Start Menu atau double-click `c:\laragon\Laragon.exe`
- Klik tombol START ALL (pastikan Apache, MySQL, dan PHP semua berwarna hijau)
- Atau log in ke phpMyAdmin di `http://localhost/phpmyadmin` untuk verify koneksi

### 3. Create Database (jika belum ada)
```bash
# Method 1: Via phpMyAdmin
- Buka http://localhost/phpmyadmin
- Klik "Databases" 
- Create database dengan nama "bengkel" (UTF-8: utf8mb4_unicode_ci)

# Method 2: Via Command Line
mysql -u root -e "CREATE DATABASE bengkel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 4. Run Migration & Seed
```bash
cd c:\laragon\www\BENGKEL

# Drop semua tabel (jika sudah ada) dan buat baru dengan data seeder
php artisan migrate:fresh --seed

# Atau jika ingin lebih aman (tanpa drop):
php artisan migrate --seed
```

### 5. Test Dashboard
- Login dengan akun pelanggan:
  - Email: `pelanggan@bengkel.com`
  - Password: `password123`

- Atau email lain:
  - `bambang@bengkel.com` (Pelanggan)
  - `siti@bengkel.com` (Pelanggan)

## Data yang Sudah Ditambahkan

### Users
- **Admin**: admin@bengkel.com
- **Mekanik**: mekanik@bengkel.com, mekanik2@bengkel.com
- **Pelanggan**: pelanggan@bengkel.com, bambang@bengkel.com, siti@bengkel.com

### Kendaraan (untuk pelanggan1)
- Honda Civic (B 1234 ABC) - Tahun 2020
- Toyota Avanza (B 5678 XYZ) - Tahun 2021

### Kendaraan (untuk pelanggan2)
- Suzuki Ertiga (B 9999 QQQ) - Tahun 2019

### Kendaraan (untuk pelanggan3)
- Daihatsu Xenia (B 1111 RRR) - Tahun 2022

### Work Orders (Pekerjaan)
- 2 Work Order yang SELESAI (dengan invoice sudah lunas)
- 2 Work Order yang AKTIF (dikerjakan - akan tampil di dashboard)

## Model & Relasi yang Ditambahkan

### Model Baru:
- `KendaraanPelanggan` - Tabel kendaraan pelanggan
- `InvoiceServis` - Tabel invoice/tagihan service

### Model yang Diupdate:
- `User` - Relasi dalam dashboard: `kendaraan()`, `mekanik()` 
- `WorkOrder` - Relasi lengkap: `kendaraan()`, `mekanik()`, `invoice()`
- `Mekanik` - Relasi: `user()`, `workOrders()`

### Key Features Dashboard Pelanggan:
✅ Menampilkan Work Order AKTIF (antrian, dikerjakan, menunggu part)
✅ Menampilkan riwayat servis (WO yang sudah selesai)
✅ List kendaraan terdaftar
✅ Hitung total kendaraan & total servis
✅ Jadwal servis berikutnya (otomatis hitung dari WO)
✅ Invoice info dari setiap pekerjaan
✅ Status pembayaran (lunas/belum)

## Troubleshooting

### Error: "Access denied for user 'root'@'localhost'"
→ Pastikan password di `.env` sesuai dengan MySQL installation Anda

### Error: "Database 'bengkel' doesn't exist"
→ Run: `mysql -u root -e "CREATE DATABASE bengkel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"`

### Error: "No connection could be made"
→ Pastikan MySQL service sudah running di Laragon
→ Buka Terminal dan test: `mysqladmin -u root ping` (harusnya return `mysqld is alive`)

### PHP PDO Driver Error
→ Pastikan php.ini di Laragon enable extension:
  - `extension=pdo_mysql` 
  - `extension=php_pdo.dll`

## Files Changed/Created

### Models Created:
- `app/Models/KendaraanPelanggan.php` - Model untuk tabel kendaraan pelanggan
- `app/Models/InvoiceServis.php` - Model untuk tabel invoice service

### Models Updated:
- `app/Models/User.php` - Tambah relasi kendaraan & mekanik
- `app/Models/WorkOrder.php` - Tambah relasi dengan kendaraan, mekanik, invoice
- `app/Models/Mekanik.php` - Tambah relasi dengan user & workorder

### Controllers Updated:
- `app/Http/Controllers/DashboardController.php` - Update `pelangganDashboard()` dengan query database real-time

### Seeders Updated:
- `database/seeders/DatabaseSeeder.php` - Tambah seeding untuk:
  - Mekanik records
  - Kendaraan pelanggan (4 kendaraan)
  - Work Orders (2 selesai + 2 aktif)
  - Invoices (2 untuk WO selesai)
  - Jenis Servis(4 jenis)

### Config Updated:
- `.env` - Database configuration

## Next Steps (Optional)

1. **Implement Work Order Creation** - Form untuk pelanggan membuat service request
2. **Real-time Status Update** - WebSocket/Polling untuk update status WO
3. **Payment Integration** - Gateway untuk pembayaran invoice
4. **Notification** - Email/SMS notifikasi untuk pelanggan saat status berubah
5. **Mobile App** - Build mobile version dari dashboard

