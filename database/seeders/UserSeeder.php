<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'), // Password yang di-hash
                'role' => 'admin',
                'nama' => 'arel', // Mengacu ke id mahasiswa
                'is_active' => true,  // Mengatur akun sebagai aktif
            ],
            [
                'name' => 'User1',
                'email' => 'user1@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'nama' => 'mek',
                'is_active' => true,  // Mengatur akun sebagai aktif
            ],
            // Jika ada pengguna lain, bisa ditambahkan di sini
        ]);
    }
}
