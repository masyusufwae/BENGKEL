-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 06 Bulan Mei 2026 pada 14.18
-- Versi server: 8.0.30
-- Versi PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `bengkel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `chats`
--

CREATE TABLE `chats` (
  `id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `receiver_id` bigint UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_servis_wo`
--

CREATE TABLE `detail_servis_wo` (
  `id_detail` bigint UNSIGNED NOT NULL,
  `id_wo` bigint UNSIGNED NOT NULL,
  `id_jenis` bigint UNSIGNED NOT NULL,
  `harga_jasa` decimal(12,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_servis_wo`
--

INSERT INTO `detail_servis_wo` (`id_detail`, `id_wo`, `id_jenis`, `harga_jasa`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 200000.00, 'Ganti oli rutin', '2026-05-06 00:44:25', '2026-05-06 00:44:25'),
(2, 1, 6, 75000.00, 'Pembersihan filter udara', '2026-05-06 00:44:25', '2026-05-06 00:44:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_wo_servis`
--

CREATE TABLE `detail_wo_servis` (
  `id` bigint UNSIGNED NOT NULL,
  `id_wo` bigint UNSIGNED NOT NULL,
  `id_jenis` bigint UNSIGNED NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_wo_sparepart`
--

CREATE TABLE `detail_wo_sparepart` (
  `id` bigint UNSIGNED NOT NULL,
  `id_wo` bigint UNSIGNED NOT NULL,
  `id_part` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `inventory_movements`
--

CREATE TABLE `inventory_movements` (
  `id_movement` bigint UNSIGNED NOT NULL,
  `id_part` bigint UNSIGNED NOT NULL,
  `id_wo` bigint UNSIGNED DEFAULT NULL,
  `jenis` enum('masuk','keluar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `sumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoice_servis`
--

CREATE TABLE `invoice_servis` (
  `id_invoice` bigint UNSIGNED NOT NULL,
  `id_wo` bigint UNSIGNED NOT NULL,
  `nomor_invoice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jasa` decimal(12,2) NOT NULL,
  `total_part` decimal(12,2) NOT NULL,
  `diskon` decimal(12,2) NOT NULL DEFAULT '0.00',
  `pajak` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total_bayar` decimal(12,2) NOT NULL,
  `status_bayar` enum('lunas','belum') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum',
  `tanggal_bayar` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `invoice_servis`
--

INSERT INTO `invoice_servis` (`id_invoice`, `id_wo`, `nomor_invoice`, `total_jasa`, `total_part`, `diskon`, `pajak`, `total_bayar`, `status_bayar`, `tanggal_bayar`, `created_at`, `updated_at`) VALUES
(1, 1, 'INV-001', 500000.00, 200000.00, 0.00, 0.00, 700000.00, 'lunas', '2026-04-17 07:44:22', '2026-05-06 00:44:22', '2026-05-06 00:44:22'),
(2, 2, 'INV-002', 200000.00, 150000.00, 0.00, 0.00, 350000.00, 'lunas', '2026-04-27 07:44:22', '2026-05-06 00:44:22', '2026-05-06 00:44:22'),
(3, 1, 'INV-20260506-001', 275000.00, 55000.00, 0.00, 33000.00, 363000.00, 'lunas', '2026-05-06 07:44:26', '2026-05-06 00:44:26', '2026-05-06 00:44:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_servis`
--

CREATE TABLE `jenis_servis` (
  `id_jenis` bigint UNSIGNED NOT NULL,
  `nama_servis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `estimasi_waktu` int NOT NULL,
  `harga_jasa` decimal(12,2) NOT NULL,
  `kategori` enum('ringan','sedang','berat') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jenis_servis`
--

INSERT INTO `jenis_servis` (`id_jenis`, `nama_servis`, `deskripsi`, `estimasi_waktu`, `harga_jasa`, `kategori`, `created_at`, `updated_at`) VALUES
(1, 'Service Berkala', 'Service rutin berkala mobil', 120, 500000.00, 'ringan', '2026-05-06 00:44:22', '2026-05-06 00:44:22'),
(2, 'Ganti Oli', 'Penggantian oli mesin', 30, 200000.00, 'ringan', '2026-05-06 00:44:22', '2026-05-06 00:44:22'),
(3, 'Perbaikan Mesin', 'Perbaikan mesin kendaraan', 240, 1000000.00, 'berat', '2026-05-06 00:44:22', '2026-05-06 00:44:22'),
(4, 'Servis Rem', 'Servis dan perbaikan sistem rem', 90, 400000.00, 'sedang', '2026-05-06 00:44:22', '2026-05-06 00:44:22'),
(5, 'Ganti Oli & Cek Rutin', 'Penggantian oli mesin, pembersihan filter udara, dan pengecekan baut-baut.', 30, 35000.00, 'ringan', '2026-05-06 00:44:25', '2026-05-06 00:44:25'),
(6, 'Service CVT / Tune Up', 'Pembersihan bagian transmisi otomatis, pengecekan v-belt, dan setel klep.', 60, 75000.00, 'sedang', '2026-05-06 00:44:25', '2026-05-06 00:44:25'),
(7, 'Turun Mesin (Overhaul)', 'Perbaikan besar pada bagian blok mesin dan penggantian piston.', 300, 500000.00, 'berat', '2026-05-06 00:44:25', '2026-05-06 00:44:25'),
(8, 'Ganti Kampas Rem', 'Penggantian kampas rem depan atau belakang beserta pembersihan kaliper.', 20, 25000.00, 'ringan', '2026-05-06 00:44:25', '2026-05-06 00:44:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kendaraan_pelanggan`
--

CREATE TABLE `kendaraan_pelanggan` (
  `id_kendaraan` bigint UNSIGNED NOT NULL,
  `id_pelanggan` bigint UNSIGNED NOT NULL,
  `nomor_polisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merek` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year DEFAULT NULL,
  `warna` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_rangka` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_mesin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_kendaraan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_bahan_bakar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kendaraan_pelanggan`
--

INSERT INTO `kendaraan_pelanggan` (`id_kendaraan`, `id_pelanggan`, `nomor_polisi`, `merek`, `model`, `tahun`, `warna`, `nomor_rangka`, `nomor_mesin`, `foto_kendaraan`, `jenis_bahan_bakar`, `created_at`, `updated_at`) VALUES
(1, 4, 'B 1234 ABC', 'Honda', 'Civic', '2020', 'Hitam', 'MHESJ5190LM000001', 'R18Z1000001', NULL, 'Bensin', '2026-05-06 00:44:22', '2026-05-06 00:44:22'),
(2, 4, 'B 5678 XYZ', 'Toyota', 'Avanza', '2021', 'Silver', 'WVWZZZ3CZ9E123456', 'K3VE000001', NULL, 'Bensin', '2026-05-06 00:44:22', '2026-05-06 00:44:22'),
(3, 5, 'B 9999 QQQ', 'Suzuki', 'Ertiga', '2019', 'Putih', 'JTHBL5C12K2012345', 'K12B000001', NULL, 'Bensin', '2026-05-06 00:44:22', '2026-05-06 00:44:22'),
(4, 6, 'B 1111 RRR', 'Daihatsu', 'Xenia', '2022', 'Merah', 'FNBSS54WXX0000001', 'K3VE000002', NULL, 'Bensin', '2026-05-06 00:44:22', '2026-05-06 00:44:22'),
(5, 4, 'AB 1234 XY', 'Honda', 'Vario 150', '2021', 'Hitam Dove', 'MHIJFB123456789', 'JFB1E1234567', NULL, 'Pertamax', '2026-05-06 00:44:25', '2026-05-06 00:44:25'),
(6, 5, 'B 9876 ZZZ', 'Yamaha', 'NMAX', '2022', 'Biru', 'MHIYMH987654321', 'YMH2E9876543', NULL, 'Pertamax Turbo', '2026-05-06 00:44:25', '2026-05-06 00:44:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mekanik`
--

CREATE TABLE `mekanik` (
  `id_mekanik` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_mekanik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spesialisasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mekanik`
--

INSERT INTO `mekanik` (`id_mekanik`, `id_user`, `nip`, `nama_mekanik`, `spesialisasi`, `jam_masuk`, `jam_keluar`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'MK001', 'Budi Mekanik', 'Engine & Transmission', '08:00:00', '17:00:00', 'aktif', '2026-05-06 00:44:21', '2026-05-06 00:44:21'),
(2, 3, 'MK002', 'Anto Bengkel', 'Electrical & Air Conditioning', '08:00:00', '17:00:00', 'aktif', '2026-05-06 00:44:21', '2026-05-06 00:44:21'),
(3, 2, '19950810202401', 'Budi Mekanik', 'Tune Up & Kelistrikan', '08:00:00', '17:00:00', 'aktif', '2026-05-06 00:44:25', '2026-05-06 00:44:25'),
(4, 3, '19970112202402', 'Anto Bengkel', 'Overhaul Mesin', '09:00:00', '18:00:00', 'aktif', '2026-05-06 00:44:25', '2026-05-06 00:44:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_04_13_update_users_table', 1),
(5, '2026_04_14_021456_create_mekanik_table', 1),
(6, '2026_04_14_021459_create_kendaraan_pelanggan_table', 1),
(7, '2026_04_14_021503_create_jenis_servis_table', 1),
(8, '2026_04_14_021506_create_sparepart_table', 1),
(9, '2026_04_14_021509_create_work_order_table', 1),
(10, '2026_04_14_021513_create_detail_servis_wo_table', 1),
(11, '2026_04_14_021516_create_penggunaan_sparepart_table', 1),
(12, '2026_04_14_021519_create_invoice_servis_table', 1),
(13, '2026_04_15_024952_create_detail_wo_servis_table', 1),
(14, '2026_04_15_024953_create_detail_wo_sparepart_table', 1),
(15, '2026_04_15_033329_alter_mekanik_make_id_user_nullable', 1),
(16, '2026_04_16_081109_add_gambar_to_work_order_table', 1),
(17, '2026_04_16_083559_add_gambar_to_sparepart_table', 1),
(18, '2026_04_20_024821_add_foto_kendaraan_to_kendaraan_pelanggan_table', 1),
(19, '2026_04_21_035549_alter_work_order_status_enum', 1),
(20, '2026_04_21_040000_remove_diserahkan_add_final_statuses', 1),
(21, '2026_04_21_041500_add_servis_completed_to_work_order', 1),
(22, '2026_04_21_090000_make_work_order_id_sparepart_nullable', 1),
(23, '2026_04_21_091000_normalize_work_order_status_values', 1),
(24, '2026_04_22_023044_create_pesans_table', 1),
(25, '2026_04_22_052544_create_chats_table', 1),
(26, '2026_05_06_000001_create_inventory_movements_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penggunaan_sparepart`
--

CREATE TABLE `penggunaan_sparepart` (
  `id_penggunaan` bigint UNSIGNED NOT NULL,
  `id_wo` bigint UNSIGNED NOT NULL,
  `id_part` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penggunaan_sparepart`
--

INSERT INTO `penggunaan_sparepart` (`id_penggunaan`, `id_wo`, `id_part`, `jumlah`, `harga_satuan`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 55000.00, 55000.00, '2026-05-06 00:44:26', '2026-05-06 00:44:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesans`
--

CREATE TABLE `pesans` (
  `id` bigint UNSIGNED NOT NULL,
  `pengirim_id` bigint UNSIGNED NOT NULL,
  `penerima_id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sudah_dibaca` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Dgh7uw8gMOUEAWAiM4MCcJG9BJWz7aTgjZQoh8Rh', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZnZ0Mjc3d29wSjZhOU8xalBpaGk3T05qWmh2STBJcGFTaGYwMjBEaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vaW52b2ljZSI7czo1OiJyb3V0ZSI7czoxOToiYWRtaW4uaW52b2ljZS5pbmRleCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1778057130);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sparepart`
--

CREATE TABLE `sparepart` (
  `id_part` bigint UNSIGNED NOT NULL,
  `kode_part` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_part` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `stok_minimum` int NOT NULL DEFAULT '0',
  `harga_beli` decimal(12,2) NOT NULL,
  `harga_jual` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sparepart`
--

INSERT INTO `sparepart` (`id_part`, `kode_part`, `nama_part`, `gambar`, `satuan`, `stok`, `stok_minimum`, `harga_beli`, `harga_jual`, `created_at`, `updated_at`) VALUES
(1, 'OIL-MPX1-01', 'Oli MPX1 0.8L', NULL, 'Botol', 20, 5, 45000.00, 55000.00, '2026-05-06 00:44:25', '2026-05-06 00:44:25'),
(2, 'BRK-FR-02', 'Kampas Rem Depan (Disc Pad)', NULL, 'Pcs', 15, 3, 35000.00, 45000.00, '2026-05-06 00:44:25', '2026-05-06 00:44:25'),
(3, 'BLT-V-03', 'V-Belt Kit', NULL, 'Set', 10, 2, 125000.00, 150000.00, '2026-05-06 00:44:25', '2026-05-06 00:44:25'),
(4, 'PLG-NGK-04', 'Busi NGK CPR9', NULL, 'Pcs', 30, 10, 15000.00, 25000.00, '2026-05-06 00:44:25', '2026-05-06 00:44:25'),
(5, 'FLT-AIR-05', 'Filter Udara Vario 150', NULL, 'Pcs', 12, 3, 40000.00, 55000.00, '2026-05-06 00:44:25', '2026-05-06 00:44:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','mekanik','pelanggan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pelanggan',
  `no_telp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `no_telp`, `alamat`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Kepala Bengkel', 'admin@bengkel.com', '2026-05-06 00:44:20', '$2y$12$B/QLX2WRgkZ5mkgrYurUn.zSOhzeI1rfSn2zh4bgObqbKr.Kpsgx2', 'admin', '+62812345678', 'Jl. Merdeka No. 123, Jakarta', NULL, '2026-05-06 00:44:20', '2026-05-06 00:44:20'),
(2, 'Budi Mekanik', 'mekanik@bengkel.com', '2026-05-06 00:44:20', '$2y$12$PRyGaPkmNoth9709FJfzvepLbbxy07xnjkReOn79WvifiGdL1ap4O', 'mekanik', '+62812345679', 'Jl. Setiabudi No. 45, Jakarta', NULL, '2026-05-06 00:44:20', '2026-05-06 00:44:20'),
(3, 'Anto Bengkel', 'mekanik2@bengkel.com', '2026-05-06 00:44:21', '$2y$12$OPbTcF7bPrj0MaHaFId.oOiloi.8e4oMiBJgetCZeedwIfqbOnXhO', 'mekanik', '+62812345680', 'Jl. Gatot Subroto No. 10, Jakarta', NULL, '2026-05-06 00:44:21', '2026-05-06 00:44:21'),
(4, 'Pelanggan Setia', 'pelanggan@bengkel.com', '2026-05-06 00:44:21', '$2y$12$Uh4GSKvww7ueVQwEAHQ9Pey4fTjJZvuGwYqKceZU/2ZhiULGJubKO', 'pelanggan', '+6285892925898', 'Jl. Sudirman No. 888, Jakarta', NULL, '2026-05-06 00:44:21', '2026-05-06 00:44:21'),
(5, 'Bambang Sukendar', 'bambang@bengkel.com', '2026-05-06 00:44:21', '$2y$12$yx/ahedb2qz6eM.AJmdKCO631wFf4bScVif76tgXhaKWGHpb8gRW6', 'pelanggan', '+6285892925898', 'Jl. Thamrin No. 77, Jakarta', NULL, '2026-05-06 00:44:21', '2026-05-06 00:44:21'),
(6, 'Siti Nurhaliza', 'siti@bengkel.com', '2026-05-06 00:44:22', '$2y$12$srbLQ2m3O9lm0EXAKLmiQOM7diIP3wGOxWzBaxBQHQTOrSW9QdL02', 'pelanggan', '+62812345683', 'Jl. Hayam Wuruk No. 50, Jakarta', NULL, '2026-05-06 00:44:22', '2026-05-06 00:44:22'),
(7, 'Test User', 'test@example.com', '2026-05-06 00:44:25', '$2y$12$2xiNXDWGQnW/t0P5yYhWN.m/7/4/GhyArJoIna.divan13S/DggRi', 'pelanggan', NULL, NULL, 'fsJ2cDuHOk', '2026-05-06 00:44:25', '2026-05-06 00:44:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `work_order`
--

CREATE TABLE `work_order` (
  `id_wo` bigint UNSIGNED NOT NULL,
  `id_kendaraan` bigint UNSIGNED NOT NULL,
  `id_mekanik` bigint UNSIGNED NOT NULL,
  `id_sparepart` bigint UNSIGNED DEFAULT NULL,
  `nomor_wo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keluhan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_masuk` datetime NOT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `estimasi_selesai` datetime DEFAULT NULL,
  `status` enum('antrian','dikerjakan','menunggu_part','selesai','diserahkan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `servis_completed` tinyint(1) NOT NULL DEFAULT '0',
  `catatan_mekanik` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `work_order`
--

INSERT INTO `work_order` (`id_wo`, `id_kendaraan`, `id_mekanik`, `id_sparepart`, `nomor_wo`, `keluhan`, `gambar`, `tanggal_masuk`, `tanggal_selesai`, `estimasi_selesai`, `status`, `servis_completed`, `catatan_mekanik`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, 'WO-001', 'Service Berkala', NULL, '2026-04-16 07:44:22', '2026-04-17 07:44:22', '2026-04-17 07:44:22', 'selesai', 0, 'Service rutin selesai dengan lancar', '2026-05-06 00:44:22', '2026-05-06 00:44:22'),
(2, 1, 1, NULL, 'WO-002', 'Ganti Oli', NULL, '2026-04-26 07:44:22', '2026-04-27 07:44:22', '2026-04-27 07:44:22', 'selesai', 0, 'Oli sudah diganti dengan tipe yang sesuai', '2026-05-06 00:44:22', '2026-05-06 00:44:22'),
(3, 1, 1, NULL, 'WO-003', 'Servis Rem - bunyi menggereget', NULL, '2026-05-06 07:44:22', NULL, '2026-05-07 07:44:22', 'dikerjakan', 0, 'Sedang mengalihkan kampas rem depan', '2026-05-06 00:44:22', '2026-05-06 00:44:22'),
(4, 2, 1, NULL, 'WO-004', 'AC tidak dingin', NULL, '2026-05-06 04:44:22', NULL, '2026-05-06 11:44:22', 'dikerjakan', 0, 'Sedang mengisi freon AC', '2026-05-06 00:44:22', '2026-05-06 00:44:22'),
(5, 1, 1, 1, 'WO-20260506-001', 'Ganti oli dan rem belakang bunyi decit', NULL, '2026-05-06 07:44:25', NULL, '2026-05-06 09:44:25', 'dikerjakan', 0, 'Kampas rem belakang sudah tipis, perlu ganti.', '2026-05-06 00:44:25', '2026-05-06 00:44:25'),
(6, 1, 1, 1, 'WO-20260506-002', 'Motor sering mati mendadak saat macet', NULL, '2026-05-05 07:44:25', '2026-05-05 10:44:25', '2026-05-05 09:44:25', 'selesai', 0, 'Setelan stasioner terlalu rendah, sudah diperbaiki.', '2026-05-06 00:44:25', '2026-05-06 00:44:25');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_sender_id_foreign` (`sender_id`),
  ADD KEY `chats_receiver_id_foreign` (`receiver_id`);

--
-- Indeks untuk tabel `detail_servis_wo`
--
ALTER TABLE `detail_servis_wo`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `detail_servis_wo_id_wo_foreign` (`id_wo`),
  ADD KEY `detail_servis_wo_id_jenis_foreign` (`id_jenis`);

--
-- Indeks untuk tabel `detail_wo_servis`
--
ALTER TABLE `detail_wo_servis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_wo_servis_id_wo_foreign` (`id_wo`),
  ADD KEY `detail_wo_servis_id_jenis_foreign` (`id_jenis`);

--
-- Indeks untuk tabel `detail_wo_sparepart`
--
ALTER TABLE `detail_wo_sparepart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_wo_sparepart_id_wo_foreign` (`id_wo`),
  ADD KEY `detail_wo_sparepart_id_part_foreign` (`id_part`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `inventory_movements`
--
ALTER TABLE `inventory_movements`
  ADD PRIMARY KEY (`id_movement`),
  ADD KEY `inventory_movements_id_part_foreign` (`id_part`),
  ADD KEY `inventory_movements_id_wo_foreign` (`id_wo`);

--
-- Indeks untuk tabel `invoice_servis`
--
ALTER TABLE `invoice_servis`
  ADD PRIMARY KEY (`id_invoice`),
  ADD UNIQUE KEY `invoice_servis_nomor_invoice_unique` (`nomor_invoice`),
  ADD KEY `invoice_servis_id_wo_foreign` (`id_wo`);

--
-- Indeks untuk tabel `jenis_servis`
--
ALTER TABLE `jenis_servis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kendaraan_pelanggan`
--
ALTER TABLE `kendaraan_pelanggan`
  ADD PRIMARY KEY (`id_kendaraan`),
  ADD KEY `kendaraan_pelanggan_id_pelanggan_foreign` (`id_pelanggan`);

--
-- Indeks untuk tabel `mekanik`
--
ALTER TABLE `mekanik`
  ADD PRIMARY KEY (`id_mekanik`),
  ADD KEY `mekanik_id_user_foreign` (`id_user`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `penggunaan_sparepart`
--
ALTER TABLE `penggunaan_sparepart`
  ADD PRIMARY KEY (`id_penggunaan`),
  ADD KEY `penggunaan_sparepart_id_wo_foreign` (`id_wo`),
  ADD KEY `penggunaan_sparepart_id_part_foreign` (`id_part`);

--
-- Indeks untuk tabel `pesans`
--
ALTER TABLE `pesans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesans_pengirim_id_foreign` (`pengirim_id`),
  ADD KEY `pesans_penerima_id_foreign` (`penerima_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `sparepart`
--
ALTER TABLE `sparepart`
  ADD PRIMARY KEY (`id_part`),
  ADD UNIQUE KEY `sparepart_kode_part_unique` (`kode_part`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `work_order`
--
ALTER TABLE `work_order`
  ADD PRIMARY KEY (`id_wo`),
  ADD UNIQUE KEY `work_order_nomor_wo_unique` (`nomor_wo`),
  ADD KEY `work_order_id_kendaraan_foreign` (`id_kendaraan`),
  ADD KEY `work_order_id_mekanik_foreign` (`id_mekanik`),
  ADD KEY `work_order_id_sparepart_foreign` (`id_sparepart`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_servis_wo`
--
ALTER TABLE `detail_servis_wo`
  MODIFY `id_detail` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `detail_wo_servis`
--
ALTER TABLE `detail_wo_servis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_wo_sparepart`
--
ALTER TABLE `detail_wo_sparepart`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `inventory_movements`
--
ALTER TABLE `inventory_movements`
  MODIFY `id_movement` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `invoice_servis`
--
ALTER TABLE `invoice_servis`
  MODIFY `id_invoice` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jenis_servis`
--
ALTER TABLE `jenis_servis`
  MODIFY `id_jenis` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kendaraan_pelanggan`
--
ALTER TABLE `kendaraan_pelanggan`
  MODIFY `id_kendaraan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `mekanik`
--
ALTER TABLE `mekanik`
  MODIFY `id_mekanik` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `penggunaan_sparepart`
--
ALTER TABLE `penggunaan_sparepart`
  MODIFY `id_penggunaan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pesans`
--
ALTER TABLE `pesans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sparepart`
--
ALTER TABLE `sparepart`
  MODIFY `id_part` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `work_order`
--
ALTER TABLE `work_order`
  MODIFY `id_wo` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chats_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_servis_wo`
--
ALTER TABLE `detail_servis_wo`
  ADD CONSTRAINT `detail_servis_wo_id_jenis_foreign` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_servis` (`id_jenis`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_servis_wo_id_wo_foreign` FOREIGN KEY (`id_wo`) REFERENCES `work_order` (`id_wo`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_wo_servis`
--
ALTER TABLE `detail_wo_servis`
  ADD CONSTRAINT `detail_wo_servis_id_jenis_foreign` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_servis` (`id_jenis`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_wo_servis_id_wo_foreign` FOREIGN KEY (`id_wo`) REFERENCES `work_order` (`id_wo`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_wo_sparepart`
--
ALTER TABLE `detail_wo_sparepart`
  ADD CONSTRAINT `detail_wo_sparepart_id_part_foreign` FOREIGN KEY (`id_part`) REFERENCES `sparepart` (`id_part`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_wo_sparepart_id_wo_foreign` FOREIGN KEY (`id_wo`) REFERENCES `work_order` (`id_wo`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `inventory_movements`
--
ALTER TABLE `inventory_movements`
  ADD CONSTRAINT `inventory_movements_id_part_foreign` FOREIGN KEY (`id_part`) REFERENCES `sparepart` (`id_part`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_movements_id_wo_foreign` FOREIGN KEY (`id_wo`) REFERENCES `work_order` (`id_wo`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `invoice_servis`
--
ALTER TABLE `invoice_servis`
  ADD CONSTRAINT `invoice_servis_id_wo_foreign` FOREIGN KEY (`id_wo`) REFERENCES `work_order` (`id_wo`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kendaraan_pelanggan`
--
ALTER TABLE `kendaraan_pelanggan`
  ADD CONSTRAINT `kendaraan_pelanggan_id_pelanggan_foreign` FOREIGN KEY (`id_pelanggan`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mekanik`
--
ALTER TABLE `mekanik`
  ADD CONSTRAINT `mekanik_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penggunaan_sparepart`
--
ALTER TABLE `penggunaan_sparepart`
  ADD CONSTRAINT `penggunaan_sparepart_id_part_foreign` FOREIGN KEY (`id_part`) REFERENCES `sparepart` (`id_part`) ON DELETE CASCADE,
  ADD CONSTRAINT `penggunaan_sparepart_id_wo_foreign` FOREIGN KEY (`id_wo`) REFERENCES `work_order` (`id_wo`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesans`
--
ALTER TABLE `pesans`
  ADD CONSTRAINT `pesans_penerima_id_foreign` FOREIGN KEY (`penerima_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesans_pengirim_id_foreign` FOREIGN KEY (`pengirim_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `work_order`
--
ALTER TABLE `work_order`
  ADD CONSTRAINT `work_order_id_kendaraan_foreign` FOREIGN KEY (`id_kendaraan`) REFERENCES `kendaraan_pelanggan` (`id_kendaraan`) ON DELETE CASCADE,
  ADD CONSTRAINT `work_order_id_mekanik_foreign` FOREIGN KEY (`id_mekanik`) REFERENCES `mekanik` (`id_mekanik`) ON DELETE CASCADE,
  ADD CONSTRAINT `work_order_id_sparepart_foreign` FOREIGN KEY (`id_sparepart`) REFERENCES `sparepart` (`id_part`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
