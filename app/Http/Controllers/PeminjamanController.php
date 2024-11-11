<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Book;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'nama_peminjam' => 'required|string',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date',
            'metode_pengambilan' => 'required|string',
            'alamat' => 'nullable|string',
        ]);

        $book = Book::where('title', $request->judul)->first();
        if (!$book) {
            // Jika buku tidak ditemukan, kembalikan pesan error
            return response()->json(['message' => 'Buku tidak ditemukan.'], 404); // Status 404
        }
        
        Peminjaman::create([
            'judul' => $request->judul,
            'nama_peminjam' => $request->nama_peminjam,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'metode_pengambilan' => $request->metode_pengambilan,
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Peminjaman berhasil dilakukan!');
    }
}
