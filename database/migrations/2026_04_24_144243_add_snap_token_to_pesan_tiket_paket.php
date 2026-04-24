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
        Schema::table('pesan_tiket_paket', function (Blueprint $table) {
            $table->string('snap_token')->nullable();
        });
    }
    public function down(): void
    {
        Schema::table('pesan_tiket_paket', function (Blueprint $table) {
            //
        });
    }
};
