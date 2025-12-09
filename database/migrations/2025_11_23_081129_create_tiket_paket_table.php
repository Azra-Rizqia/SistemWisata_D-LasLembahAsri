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
        Schema::create('tiket_paket', function (Blueprint $table) {
            $table->id('id_tiket_paket');
            $table->string('nama_tiket_paket');
            $table->text('deskripsi_tiket');
            $table->integer('harga_tiket_weekday');
            $table->integer('harga_tiket_weekend');
            $table->boolean('status_tiket')->default(true);
            $table->string('qr_tiket');
            $table->timestamps();
            //fk
            $table->foreignId('id_wahana')->nullable()->constrained('wahana')->nullOnDelete();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiket_paket');
    }
};
