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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('nama_peminjam');
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian');
            $table->string('metode_pengambilan');
            $table->string('alamat')->nullable();
            $table->string('status_pengembalian')->default('Dipinjam');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
