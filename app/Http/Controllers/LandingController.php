<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Book;


class LandingController extends Controller
{
    public function index()
{
    $books = Book::where('banyaknya_dipinjam', '>=', 10)->orderBy('banyaknya_dipinjam', 'desc')->get();

    return Inertia::render('LandingPage', [
        'books' => $books->toArray(),
    ]);
}

}

