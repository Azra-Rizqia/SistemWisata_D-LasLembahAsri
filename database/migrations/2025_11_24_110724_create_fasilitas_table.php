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
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id('id_fasilitas');
            $table->string('nama_fasilitas', 150);
            $table->string('deskripsi_singkat', 255)->nullable();
            $table->text('tentang_fasilitas')->nullable();
            $table->integer('harga_fasilitas')->default(0);
            $table->enum('status_fasilitas', ['tersedia', 'tidak_tersedia'])->default('tersedia');
            $table->json('fasilitas_tersedia')->nullable();
            $table->json('fasilitas_tambahan')->nullable();
            $table->string('gambar_fasilitas')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};
