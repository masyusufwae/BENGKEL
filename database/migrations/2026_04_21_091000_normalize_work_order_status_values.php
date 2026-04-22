<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Normalize historical values before tightening the enum.
        DB::statement("UPDATE `work_order` SET `status` = 'menunggu_part' WHERE `status` = 'menunggu part'");

        // Keep enum values consistent across controllers/views (use snake_case).
        DB::statement(
            "ALTER TABLE `work_order` " .
            "MODIFY `status` ENUM('antrian','dikerjakan','menunggu_part','selesai','diserahkan') NOT NULL"
        );
    }

    public function down(): void
    {
        DB::statement("UPDATE `work_order` SET `status` = 'menunggu part' WHERE `status` = 'menunggu_part'");

        DB::statement(
            "ALTER TABLE `work_order` " .
            "MODIFY `status` ENUM('antrian','dikerjakan','menunggu part','selesai','diserahkan') NOT NULL"
        );
    }
};

