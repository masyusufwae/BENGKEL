<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_wo_servis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_wo');
            $table->unsignedBigInteger('id_jenis');
            $table->decimal('harga_satuan', 12, 2);
            $table->timestamps();

            $table->foreign('id_wo')->references('id_wo')->on('work_order')->onDelete('cascade');
            $table->foreign('id_jenis')->references('id_jenis')->on('jenis_servis')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_wo_servis');
    }
};