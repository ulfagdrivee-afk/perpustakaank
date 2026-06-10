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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku', 10);
            $table->string('judul', 255);
            $table->foreignId('kategori_id')->constrained()->cascade('onDelete');
            $table->foreignId('penerbit_id')->constrained()->cascade('onDelete');
            $table->string('isbn', 255);
            $table->string('pengarang', 255);
            $table->integer('jumlah_halaman');
            $table->integer('jumlah_stok');
            $table->integer('tahun_terbit');
            $table->string('text');
            $table->string('gambar', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
