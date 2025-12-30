<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tiket_satuan', function (Blueprint $table) {

            // =============================
            // DROP FOREIGN KEY DULU
            // =============================
            if (Schema::hasColumn('tiket_satuan', 'id_wahana')) {
                $table->dropForeign(['id_wahana']);
            }

            // =============================
            // TAMBAH KOLOM BARU
            // =============================
            $table->string('nama_pemesan')->after('id');
            $table->date('tanggal_pembelian')->after('nama_tiket');
            $table->integer('jumlah_tiket')->after('tanggal_pembelian');
            $table->integer('harga_satuan')->after('jumlah_tiket');
            $table->integer('total_pembayaran')->after('harga_satuan');
            $table->enum('status_pembayaran', ['pending', 'selesai'])
                  ->default('pending')
                  ->after('total_pembayaran');

            // =============================
            // HAPUS KOLOM LAMA
            // =============================
            $table->dropColumn([
                'deskripsi_tiket',
                'harga_tiket',
                'url_gambar_wahana',
                'id_wahana'
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('tiket_satuan', function (Blueprint $table) {

            // =============================
            // KEMBALIKAN KOLOM LAMA
            // =============================
            $table->text('deskripsi_tiket')->nullable();
            $table->integer('harga_tiket')->nullable();
            $table->string('url_gambar_wahana')->nullable();
            $table->unsignedBigInteger('id_wahana')->nullable();

            // =============================
            // HAPUS KOLOM BARU
            // =============================
            $table->dropColumn([
                'nama_pemesan',
                'tanggal_pembelian',
                'jumlah_tiket',
                'harga_satuan',
                'total_pembayaran',
                'status_pembayaran'
            ]);

            // =============================
            // BALIKIN FOREIGN KEY
            // =============================
            $table->foreign('id_wahana')
                  ->references('id')
                  ->on('wahana')
                  ->onDelete('cascade');
        });
    }
};

