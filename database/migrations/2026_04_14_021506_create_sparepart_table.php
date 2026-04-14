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
       Schema::create('sparepart', function (Blueprint $table) {
    $table->bigIncrements('id_part');
    $table->string('kode_part')->unique();
    $table->string('nama_part');
    $table->string('satuan');
    $table->integer('stok')->default(0);
    $table->integer('stok_minimum')->default(0);
    $table->decimal('harga_beli', 12, 2);
    $table->decimal('harga_jual', 12, 2);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sparepart');
    }
};
