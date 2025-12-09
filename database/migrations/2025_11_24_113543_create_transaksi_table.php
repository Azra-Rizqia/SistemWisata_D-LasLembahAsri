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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->unsignedBigInteger('id_user');
            // Info referensi (jenis pesanan apa yg dibayar)
            $table->unsignedBigInteger('reference_id');       // ID primary dari tabel asal
            $table->string('reference_type', 40);             // nama tabel / jenis booking
            $table->string('reference_code', 30);             // kode unik pesanan untuk tampilan
            $table->decimal('total_tagihan', 12, 2);
            $table->enum('status_transaksi', ['menunggu', 'sukses', 'gagal'])->default('menunggu');
            $table->timestamp('tanggal_transaksi')->useCurrent();
            $table->timestamps();
            $table->index(['reference_type', 'reference_id']);
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
