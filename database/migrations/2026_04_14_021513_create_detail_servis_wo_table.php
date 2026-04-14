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
        Schema::create('detail_servis_wo', function (Blueprint $table) {
    $table->bigIncrements('id_detail');

    $table->unsignedBigInteger('id_wo');
    $table->unsignedBigInteger('id_jenis');

    $table->decimal('harga_jasa', 12, 2);
    $table->text('keterangan')->nullable();

    $table->timestamps();

    // FIX RELASI
    $table->foreign('id_wo')
          ->references('id_wo')
          ->on('work_order')
          ->onDelete('cascade');

    $table->foreign('id_jenis')
          ->references('id_jenis')
          ->on('jenis_servis')
          ->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_servis_wo');
    }
};
