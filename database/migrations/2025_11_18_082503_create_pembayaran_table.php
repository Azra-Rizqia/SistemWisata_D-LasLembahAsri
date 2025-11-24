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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->foreignId('id_transaksi')->constrained('transaksi')->cascadeOnDelete();
            $table->foreignId('id_user')->constrained('users')->cascadeOnDelete();
            $table->enum('metode_pembayaran', ['tunai', 'qris', 'transfer', 'ewallet']);
            $table->string('provider_payment')->nullable(); // contoh: BCA, Mandiri, OVO, Gopay
            $table->string('payment_gateway_id')->nullable(); // untuk integrasi midtrans
            $table->decimal('total_dibayar', 12, 2);
            $table->enum('status_pembayaran', ['menunggu', 'sukses', 'gagal'])->default('menunggu');
            $table->timestamp('tanggal_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
