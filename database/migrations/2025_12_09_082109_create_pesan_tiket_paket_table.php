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
        Schema::create('pesan_tiket_paket', function (Blueprint $table) {
            $table->id();
            $table->text('deskripsi_tiket');
            $table->integer('harga_pesanan');
            $table->integer('jumlah_tiket');
            $table->boolean('status_pesanan')->default(true);;
            $table->string('qr_tiket');
            //fk
            $table->foreignId('id_user')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('id_tiket_paket')->nullable()->constrained('tiket_paket')->nullOnDelete();

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesan_tiket_paket');
    }
};
