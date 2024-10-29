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
                'mahasiswa_id' => 1, // Mengacu ke id mahasiswa
            ],
            [
                'name' => 'User1',
                'email' => 'user1@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'mahasiswa_id' => 2,
            ],
        ]);
    }
}
