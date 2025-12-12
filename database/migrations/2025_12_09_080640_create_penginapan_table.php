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
        Schema::create('penginapan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penginapan');
            $table->text('deskripsi_penginapan')->nullable();
            $table->integer('harga_weekend');
            $table->integer('harga_weekday');
            $table->json('fasilitas_tersedia')->nullable();
            $table->boolean('status_tersedia')->default(true);
            $table->string('url_gambar_penginapan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penginapan');
    }
};
