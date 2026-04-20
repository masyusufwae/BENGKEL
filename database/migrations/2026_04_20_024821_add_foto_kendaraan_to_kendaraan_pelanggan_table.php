<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kendaraan_pelanggan', function (Blueprint $table) {
            $table->string('foto_kendaraan')->nullable()->after('nomor_mesin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kendaraan_pelanggan', function (Blueprint $table) {
            $table->dropColumn('foto_kendaraan');
        });
    }
};
