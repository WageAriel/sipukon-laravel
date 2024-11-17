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
        Schema::create('prodi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_prodi')->unique();
            $table->timestamps();
        });
        

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('user');
            $table->string('nama')->nullable();
            $table->string('status')->default('Tidak meminjam');
            $table->string('prodi')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        //data buku
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('isbn')->nullable(); // Tambahkan kolom ISBN
            $table->string('publisher')->nullable(); // Tambahkan kolom Publisher
            $table->year('tahun')->nullable(); // Tambahkan kolom Tahun
            $table->string('cover_image')->nullable();
            $table->integer('banyaknya_dipinjam')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('mahasiswa');
        Schema::dropIfExists('prodi');
        Schema::dropIfExists('buku');
    }
};