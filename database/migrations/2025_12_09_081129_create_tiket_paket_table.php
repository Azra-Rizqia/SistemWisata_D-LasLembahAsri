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
        Schema::create('tiket_paket', function (Blueprint $table) {
            $table->id('id');
            $table->string('nama_tiket_paket');
            $table->text('deskripsi_tiket');
            $table->string('pengelola_wahana');
            $table->integer('harga_tiket_weekday');
            $table->integer('harga_tiket_weekend');
            $table->enum('status_tiket', allowed: ['Tersedia','Tidak Tersedia'])->default('Tersedia');
            $table->string('qr_tiket');
            $table->timestamps();

            // Fk
            $table->foreignId('id_wahana')
                ->nullable()
                ->constrained('wahana')
                ->nullOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiket_paket');
    }
};
