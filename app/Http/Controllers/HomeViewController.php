<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Prodi;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class HomeViewController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user && $user->role !== 'admin') {
            return redirect()->route('landing')->with('error', 'Unauthorized access.');
        }
        
        $user = User::all();
        $books = Book::all();
        $prodi = Prodi::all();

        return Inertia::render('HomeView', [
            'user' => $user,
            'books' => $books,
            'prodi' => $prodi,
        ]);
    }
}