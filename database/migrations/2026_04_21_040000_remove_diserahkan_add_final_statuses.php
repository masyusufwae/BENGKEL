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
        // Convert 'diserahkan' to 'selesai'
        DB::table('work_order')
            ->where('status', 'diserahkan')
            ->update(['status' => 'selesai']);

        // Drop existing enum column
        Schema::table('work_order', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Recreate with new enum: remove diserahkan
        Schema::table('work_order', function (Blueprint $table) {
            $table->enum('status', ['antrian', 'dikerjakan', 'selesai', 'ditolak'])->after('estimasi_selesai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse: recreate previous enum
        Schema::table('work_order', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('work_order', function (Blueprint $table) {
            $table->enum('status', ['antrian', 'dikerjakan', 'selesai', 'diserahkan', 'ditolak'])->after('estimasi_selesai');
        });
    }
};

