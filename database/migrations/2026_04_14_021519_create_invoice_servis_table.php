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
        Schema::create('invoice_servis', function (Blueprint $table) {
    $table->bigIncrements('id_invoice');

    $table->unsignedBigInteger('id_wo');

    $table->string('nomor_invoice')->unique();
    $table->decimal('total_jasa', 12, 2);
    $table->decimal('total_part', 12, 2);
    $table->decimal('diskon', 12, 2)->default(0);
    $table->decimal('pajak', 12, 2)->default(0);
    $table->decimal('total_bayar', 12, 2);
    $table->enum('status_bayar', ['lunas', 'belum'])->default('belum');
    $table->dateTime('tanggal_bayar')->nullable();

    $table->timestamps();

    // FIX RELASI
    $table->foreign('id_wo')
          ->references('id_wo')
          ->on('work_order')
          ->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_servis');
    }
};
