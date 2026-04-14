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
       Schema::create('kendaraan_pelanggan', function (Blueprint $table) {
    $table->bigIncrements('id_kendaraan');
    $table->foreignId('id_pelanggan')->constrained('users')->onDelete('cascade');
    $table->string('nomor_polisi');
    $table->string('merek');
    $table->string('model');
    $table->year('tahun')->nullable();
    $table->string('warna')->nullable();
    $table->string('nomor_rangka')->nullable();
    $table->string('nomor_mesin')->nullable();
    $table->string('jenis_bahan_bakar')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraan_pelanggan');
    }
};
