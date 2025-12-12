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
        Schema::create('reservasi_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_reservasi_fasilitas', 20)->unique();
            $table->string('kategori_reservasi');
            $table->date('tanggal_reservasi');
            $table->integer('total_harga_reservasi');
            $table->string('status_reservasi');
            $table->string('metode_pembayaran_reservasi');
            $table->text('catatan_user_reservasi')->nullable();
            $table->foreignId('id_fasilitas')->nullable()->constrained('fasilitas')->nullOnDelete();
            $table->foreignId('id_user')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi_fasilitas');
    }
};
