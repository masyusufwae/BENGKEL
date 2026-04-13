<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkOrder;

class WorkOrderSeeder extends Seeder
{
    public function run(): void
    {
        WorkOrder::create([
            'nomor_wo' => 'WO-001',
            'keluhan' => 'Mesin kasar',
            'status' => 'antrian'
        ]);

        WorkOrder::create([
            'nomor_wo' => 'WO-002',
            'keluhan' => 'Ganti oli',
            'status' => 'selesai'
        ]);
    }
}