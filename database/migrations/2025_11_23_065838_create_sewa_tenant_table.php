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
        Schema::create('sewa_tenant', function (Blueprint $table) {
            $table->id('id_sewa_tenant');
            $table->date('tanggal_mulai_sewa');
            $table->enum('status_pembayaran_tenant', ['Menunggu', 'Dibayar', 'Dibatalkan'])->default('Menunggu');
            $table->text('catatan_publik')->nullable();
            $table->integer('harga_sewa_tenant');
            // FK
            $table->foreignId('id_tenant')->constrained('tenant')->nullOnDelete();
            $table->foreignId('id_user')->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewa_tenant');
    }
};
