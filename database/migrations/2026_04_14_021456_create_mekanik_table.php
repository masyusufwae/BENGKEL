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
       Schema::create('mekanik', function (Blueprint $table) {
    $table->bigIncrements('id_mekanik');
    $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
    $table->string('nip')->nullable();
    $table->string('nama_mekanik');
    $table->string('spesialisasi')->nullable();
    $table->time('jam_masuk')->nullable();
    $table->time('jam_keluar')->nullable();
    $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mekanik');
    }
};
