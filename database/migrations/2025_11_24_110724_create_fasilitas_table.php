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
            $table->string('nama_fasilitas');
            $table->text('deskripsi_fasilitas')->nullable();
            $table->integer('harga_fasilitas');
            $table->boolean('status_fasilitas')->default(true);
            $table->foreignId('id_gambar')->nullable()->constrained('gambar')->nullOnDelete();
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
