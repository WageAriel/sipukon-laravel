<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function getAllBooks()
    {
        $books = Book::all();
        return response()->json([
            'data' => $books
        ], 200);
    }

    public function index()
    {
        $books = Book::all();
        return Inertia::render('BukuView', ['data' => $books]);
    }

    public function library()
    {
        $books = Book::all();
        return Inertia::render('LibraryPage', ['data' => $books]);
    }

    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20', // Validasi untuk ISBN
            'publisher' => 'nullable|string|max:255', // Validasi untuk Publisher
            'tahun' => 'nullable|integer|digits:4', // Validasi untuk Tahun
            'cover_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:10240'
        ]);

        $dataToStore = [
            'title' => $validated['title'],
            'author' => $validated['author'],
            'isbn' => $validated['isbn'] ?? null,
            'publisher' => $validated['publisher'] ?? null,
            'tahun' => $validated['tahun'] ?? null,
        ];

        if (isset($validated['cover_image'])) {
            $path = $validated['cover_image']->storeAs('public/book_covers', $validated['cover_image']->hashName());
            $dataToStore['cover_image'] = $validated['cover_image']->hashName();
        }

        Book::create($dataToStore);

        return redirect()->route('buku');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}


public function update(Request $request, $id)
{
    $book = Book::findOrFail($id); // Mengambil model Book berdasarkan ID

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'isbn' => 'nullable|string|max:20', // Validasi untuk ISBN
        'publisher' => 'nullable|string|max:255', // Validasi untuk Publisher
        'tahun' => 'nullable|integer|digits:4', // Validasi untuk Tahun
        'cover_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:10240'
    ]);

    $dataToUpdate = [
        'title' => $validated['title'],
        'author' => $validated['author'],
        'isbn' => $validated['isbn'] ?? null,
        'publisher' => $validated['publisher'] ?? null,
        'tahun' => $validated['tahun'] ?? null,
    ];

    if (isset($validated['cover_image'])) {
        $fileName = $validated['cover_image']->hashName();
        $validated['cover_image']->storeAs('public/book_covers', $fileName);
        $dataToUpdate['cover_image'] = $fileName;
    }

    $book->update($dataToUpdate); // Update data buku

    return redirect()->route('buku');
}


    public function destroy($id)
    {
        Book::destroy($id);

        return redirect()->route('buku');
    }
}
