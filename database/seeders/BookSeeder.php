<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run()
    {
        Book::create([
            'title' => 'Belajar Laravel',
            'author' => 'John Doe',
            'description' => 'Buku panduan lengkap untuk belajar Laravel dari dasar hingga mahir.',
            'cover_image' => null,
        ]);

        Book::create([
            'title' => 'Pemrograman PHP',
            'author' => 'Jane Smith',
            'description' => 'Memahami konsep pemrograman PHP dengan contoh nyata.',
            'cover_image' => null,
        ]);

        // Tambahkan data lainnya sesuai kebutuhan
    }
}
