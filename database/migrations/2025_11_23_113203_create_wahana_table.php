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
        Schema::create('wahana', function (Blueprint $table) {
            $table->id();

            $table->string('nama_wahana');
            $table->text('deskripsi_wahana');
            $table->string('pengelola_wahana')->nullable();
            $table->enum('status_wahana', ['Tersedia', 'Tidak Tersedia'])->default('Tersedia');
            $table->integer('harga_tiket_wahana_wd')->default(0);
            $table->integer('harga_tiket_wahana_we')->default(0);
            $table->foreignId('id_gambar')->nullable()->constrained('daftar_gambar')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wahana');
    }
};
