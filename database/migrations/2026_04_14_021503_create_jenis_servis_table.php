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
       Schema::create('jenis_servis', function (Blueprint $table) {
    $table->bigIncrements('id_jenis');
    $table->string('nama_servis');
    $table->text('deskripsi')->nullable();
    $table->integer('estimasi_waktu'); // menit
    $table->decimal('harga_jasa', 12, 2);
    $table->enum('kategori', ['ringan', 'sedang', 'berat']);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_servis');
    }
};
