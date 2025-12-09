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
        Schema::create('tiket_satuan', function (Blueprint $table) {
            $table->id();

            $table->string('nama_tiket');
            $table->text('deskripsi_tiket');
            $table->Integer('harga_tiket');

            $table->foreignId('id_wahana')->nullable()->constrained('wahana')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiket_satuan');
    }
};
