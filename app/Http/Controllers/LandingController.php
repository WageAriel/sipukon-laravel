<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Book;


class LandingController extends Controller
{
    public function index()
{
    $books = Book::where('banyaknya_dipinjam', '>=', 10)->get();

    return Inertia::render('LandingPage', [
        'books' => $books->toArray(),
    ]);
}

}

