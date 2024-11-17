<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'author' => $this->faker->name(),
            'isbn' => $this->faker->isbn13(), // Menambahkan ISBN dengan data acak
            'publisher' => $this->faker->company(), // Menambahkan Publisher
            'tahun' => $this->faker->year(),
            'cover_image' => UploadedFile::fake()->image('cover.jpg')->store('book_covers', 'public'),
        ];
    }
}
