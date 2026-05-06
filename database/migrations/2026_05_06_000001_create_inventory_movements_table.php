<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->bigIncrements('id_movement');
            $table->unsignedBigInteger('id_part');
            $table->unsignedBigInteger('id_wo')->nullable();
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->string('sumber')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_part')->references('id_part')->on('sparepart')->onDelete('cascade');
            $table->foreign('id_wo')->references('id_wo')->on('work_order')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
