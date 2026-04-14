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
        Schema::create('work_order', function (Blueprint $table) {
    $table->bigIncrements('id_wo');

    $table->unsignedBigInteger('id_kendaraan');
    $table->unsignedBigInteger('id_mekanik');

    $table->string('nomor_wo')->unique();
    $table->text('keluhan');
    $table->dateTime('tanggal_masuk');
    $table->dateTime('tanggal_selesai')->nullable();
    $table->dateTime('estimasi_selesai')->nullable();
    $table->enum('status', ['antrian','dikerjakan','menunggu part','selesai','diserahkan']);
    $table->text('catatan_mekanik')->nullable();

    $table->timestamps();

    // FOREIGN KEY FIX
    $table->foreign('id_kendaraan')
          ->references('id_kendaraan')
          ->on('kendaraan_pelanggan')
          ->onDelete('cascade');

    $table->foreign('id_mekanik')
          ->references('id_mekanik')
          ->on('mekanik')
          ->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order');
    }
};
