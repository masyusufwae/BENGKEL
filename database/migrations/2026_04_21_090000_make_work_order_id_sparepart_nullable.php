<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Schema builder would require doctrine/dbal for ->change().
        // Use raw SQL to keep migrations dependency-free.
        DB::statement('ALTER TABLE `work_order` DROP FOREIGN KEY `work_order_id_sparepart_foreign`');
        DB::statement('ALTER TABLE `work_order` MODIFY `id_sparepart` BIGINT UNSIGNED NULL');
        DB::statement(
            'ALTER TABLE `work_order` ' .
            'ADD CONSTRAINT `work_order_id_sparepart_foreign` ' .
            'FOREIGN KEY (`id_sparepart`) REFERENCES `sparepart`(`id_part`) ' .
            'ON DELETE SET NULL'
        );
    }

    public function down(): void
    {
        // Note: this will fail if rows exist with id_sparepart = NULL.
        DB::statement('ALTER TABLE `work_order` DROP FOREIGN KEY `work_order_id_sparepart_foreign`');
        DB::statement('ALTER TABLE `work_order` MODIFY `id_sparepart` BIGINT UNSIGNED NOT NULL');
        DB::statement(
            'ALTER TABLE `work_order` ' .
            'ADD CONSTRAINT `work_order_id_sparepart_foreign` ' .
            'FOREIGN KEY (`id_sparepart`) REFERENCES `sparepart`(`id_part`) ' .
            'ON DELETE CASCADE'
        );
    }
};

