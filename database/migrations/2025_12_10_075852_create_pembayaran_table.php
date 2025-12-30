<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->foreignId('id_transaksi')->nullable()->constrained('transaksi')->nullonDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('metode_pembayaran', ['tunai', 'qris', 'transfer', 'ewallet']);
            $table->string('provider_payment')->nullable();
            $table->string('payment_gateway_id')->nullable();
            $table->decimal('total_dibayar', 12, 2);
            $table->enum('status_pembayaran', ['menunggu', 'sukses', 'gagal'])->default('menunggu');
            $table->timestamp('tanggal_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
