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
            'isbn' => '978-3-16-148410-0',
            'publisher' => 'Publisher XYZ',
            'tahun' => 2021,
            'cover_image' => null,
        ]);

        Book::create([
            'title' => 'Pemrograman PHP',
            'author' => 'Jane Smith',
            'isbn' => '978-1-23-456789-7',
            'publisher' => 'Publisher ABC',
            'tahun' => 2020,
            'cover_image' => null,
        ]);
    }
}

