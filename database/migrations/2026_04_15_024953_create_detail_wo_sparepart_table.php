<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_wo_sparepart', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_wo');
            $table->unsignedBigInteger('id_part');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 12, 2);
            $table->timestamps();

            $table->foreign('id_wo')->references('id_wo')->on('work_order')->onDelete('cascade');
            $table->foreign('id_part')->references('id_part')->on('sparepart')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_wo_sparepart');
    }
};