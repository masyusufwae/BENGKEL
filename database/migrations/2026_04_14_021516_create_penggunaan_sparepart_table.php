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
      Schema::create('penggunaan_sparepart', function (Blueprint $table) {
    $table->bigIncrements('id_penggunaan');

    $table->unsignedBigInteger('id_wo');
    $table->unsignedBigInteger('id_part');

    $table->integer('jumlah');
    $table->decimal('harga_satuan', 12, 2);
    $table->decimal('subtotal', 12, 2);

    $table->timestamps();

    // FIX RELASI
    $table->foreign('id_wo')
          ->references('id_wo')
          ->on('work_order')
          ->onDelete('cascade');

    $table->foreign('id_part')
          ->references('id_part')
          ->on('sparepart')
          ->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggunaan_sparepart');
    }
};
