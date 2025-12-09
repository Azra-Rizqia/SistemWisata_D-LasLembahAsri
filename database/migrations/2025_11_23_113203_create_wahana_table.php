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
            $table->id('id_wahana'); 

            $table->string('nama_wahana');
            $table->text('deskripsi_wahana');
            $table->string('pengelola_wahana')->nullable();
            $table->enum('status_wahana', ['Tersedia', 'Tidak Tersedia'])->default('Tersedia');
            $table->Integer('harga_tiket_wahana')->default(0);
            $table->Integer('jumlah')->default(0);

            $table->foreignId('id_gambar')->nullable()->constrained('gambar')->nullonDelete();
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
