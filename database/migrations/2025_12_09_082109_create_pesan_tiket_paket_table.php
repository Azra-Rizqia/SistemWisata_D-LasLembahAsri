<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesan_tiket_paket', function (Blueprint $table) {

            $table->id();

            $table->string('kode_pesan_tiket')->unique();
            $table->text('deskripsi_tiket')->nullable();
            $table->integer('harga_pesanan');
            $table->integer('jumlah_tiket');
            $table->enum('status', ['Proses','Selesai','Dibatalkan'])->default('Proses');
            $table->date('tanggal_pembelian');
            $table->string('qr_tiket');

            $table->foreignId('id_user')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->foreignId('id_tiket_paket')
                  ->constrained('tiket_paket')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesan_tiket_paket');
    }
};
