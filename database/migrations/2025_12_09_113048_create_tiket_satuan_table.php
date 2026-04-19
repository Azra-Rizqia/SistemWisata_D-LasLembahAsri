<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tiket_satuan', function (Blueprint $table) {
            $table->id();

            $table->string('nama_pemesan');
            $table->string('nama_tiket');
            $table->date('tanggal_pembelian');

            $table->integer('jumlah_tiket');
            $table->integer('harga_satuan');
            $table->integer('total_pembayaran');

            $table->enum('status_pembayaran', ['pending', 'selesai'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiket_satuan');
    }
};
