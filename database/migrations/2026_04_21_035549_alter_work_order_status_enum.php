<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Convert any 'menunggu part' or 'menunggu_part' to 'dikerjakan'
        DB::table('work_order')
            ->where('status', 'menunggu part')
            ->orWhere('status', 'menunggu_part')
            ->update(['status' => 'dikerjakan']);

        // Drop existing enum column
        Schema::table('work_order', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Recreate with new enum values
        Schema::table('work_order', function (Blueprint $table) {
            $table->enum('status', ['antrian', 'dikerjakan', 'selesai', 'diserahkan', 'ditolak'])->after('estimasi_selesai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse: recreate old enum
        Schema::table('work_order', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('work_order', function (Blueprint $table) {
            $table->enum('status', ['antrian', 'dikerjakan', 'menunggu part', 'selesai', 'diserahkan'])->after('estimasi_selesai');
        });
    }
};

