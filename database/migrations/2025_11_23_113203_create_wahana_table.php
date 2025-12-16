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
            $table->string('tentang_wahana');
            $table->string('pengelola_wahana')->nullable();
            $table->enum('status_wahana', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->Integer('harga_tiket_wahana')->default(0);
            $table->Integer('jumlah')->default(0);
            $table->string('url_gambar_wahana')->nullable();
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
