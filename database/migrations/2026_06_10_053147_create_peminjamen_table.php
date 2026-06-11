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
        Schema::create('peminjamen', function (Blueprint $table) {
        $table->id();
            $table->date('tanggal_pinjam');
            $table->string('lama_pinjam');
            $table->string('keterangan');
            $table->enum('status', ['dipinjam','sudah dikembalikan']);
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('anggota_id')->constrained()->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};