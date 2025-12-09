<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('reference_id');
            $table->string('reference_type', 40);
            $table->string('reference_code', 30);
            $table->decimal('total_tagihan', 12, 2);
            $table->enum('status_transaksi', ['menunggu', 'sukses', 'gagal'])->default('menunggu');
            $table->timestamp('tanggal_transaksi')->useCurrent();
            $table->timestamps();
            $table->index(['reference_type', 'reference_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
