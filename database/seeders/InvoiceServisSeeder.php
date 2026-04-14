<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceServisSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil Work Order yang sudah ada
        $wo = DB::table('work_order')->where('nomor_wo', 'like', 'WO%')->first();

        if ($wo) {
            // 2. Hitung Total Jasa dari Detail Servis
            $totalJasa = DB::table('detail_servis_wo')
                ->where('id_wo', $wo->id_wo)
                ->sum('harga_jasa');

            // 3. Hitung Total Sparepart dari Penggunaan Sparepart
            $totalPart = DB::table('penggunaan_sparepart')
                ->where('id_wo', $wo->id_wo)
                ->sum('subtotal');

            // 4. Kalkulasi Akhir
            $pajak = ($totalJasa + $totalPart) * 0.1; // Contoh PPN 10%
            $diskon = 0;
            $totalBayar = ($totalJasa + $totalPart + $pajak) - $diskon;

            DB::table('invoice_servis')->insert([
                [
                    'id_wo' => $wo->id_wo,
                    'nomor_invoice' => 'INV-' . date('Ymd') . '-001',
                    'total_jasa' => $totalJasa,
                    'total_part' => $totalPart,
                    'diskon' => $diskon,
                    'pajak' => $pajak,
                    'total_bayar' => $totalBayar,
                    'status_bayar' => 'lunas',
                    'tanggal_bayar' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }
}
