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
        Schema::create('reservasi_penginapan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_reservasi')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_penginapan')->nullable()->constrained('penginapan')->nullOnDelete();
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar');
            $table->text('catatan_user_reservasi')->nullable();
            $table->dateTime('tanggal_pemesanan')->useCurrent();
            $table->enum('status_reservasi', ['Proses', 'Selesai', 'Dibatalkan'])->default('Proses');
            $table->string('metode_pembayaran')->nullable();
            $table->decimal('base_harga', 12, 2)->default(0); 
            $table->decimal('pajak', 12, 2)->default(0); 
            $table->decimal('total_pembayaran', 12, 2)->default(0); 

            // UI: Checkbox konfirmasi tamu tidak > 2 orang
            $table->boolean('is_guest_count_confirmed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi_penginapan');
    }
};
