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
        Schema::create('pesan_tiket_satuan', function (Blueprint $table) {
            $table->id('id_pesan_tiket_satuan'); 

            $table->Integer('jumlah_tiket')->default(1);
            $table->Integer('harga_pesanan')->default(0);
            $table->enum('status_pesanan', ['Pending', 'Dibayar', 'Dibatalkan', 'Gagal'])->default('Pending');      
            $table->string('qr_tiket')->nullable()->unique();

            $table->foreignId('id_tiket_satuan')->constrained('tiket_satuan')->nullonDelete(); 
            $table->foreignId('id_user')->constrained('pengunjung')->nullonDelete(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesan_tiket_satuan');
    }
};
