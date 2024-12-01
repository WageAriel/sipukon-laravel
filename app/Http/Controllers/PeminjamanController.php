<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Denda;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Psy\Command\WhereamiCommand;

class PeminjamanController extends Controller
{
    public function getAllPeminjaman()
    {
        $peminjaman = Peminjaman::all();
        return response()->json([
            'data' => $peminjaman
        ], 200);
    }
    
    public function index()
    {
        $peminjaman = Peminjaman::all();
        return Inertia::render('PeminjamanView', ['data' => $peminjaman]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'metode_pengambilan' => 'required|string',
            'alamat' => 'nullable|string',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'User not logged in.'], 403);
        }


        $book = Book::where('title', $request->judul)->first();
        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan.'], 404);
        }

        $status_buku = Book::where('title', $request->judul)
                            ->where('status_buku', 'tersedia')
                            ->count();
        if (!$status_buku){
            return response()->json(['message' => 'Buku tidak tersedia.'], 404);
        }
        
        $jumlahPeminjamanAktif = Peminjaman::where('nama_peminjam', $user->nama)
                                        ->where('status_pengembalian', 'Dipinjam')
                                        ->count();

        if ($jumlahPeminjamanAktif >= 2) {
            return response()->json([], 422);
        }

        $tanggalPeminjaman = Carbon::now();
        $tanggalPengembalian = $tanggalPeminjaman->copy()->addDays(7);
        $status = $request->metode_pengambilan === 'delivery' ? 'Disiapkan' : 'Dipinjam';

        Peminjaman::create([
            'judul' => $request->judul,
            'nama_peminjam' => $user->nama,
            'tanggal_peminjaman' => $tanggalPeminjaman,
            'tanggal_pengembalian' => $tanggalPengembalian,
            'metode_pengambilan' => $request->metode_pengambilan,
            'alamat' => $request->alamat,
            'status_pengembalian' => $status,
        ]);
        $book->increment('banyaknya_dipinjam');

        $user = User::find(Auth::id());
        if ($user) {
            $user->status = 'Meminjam';
            $user->save();
        }

        if($book){
            $book->status_buku = 'tidak tersedia';
            $book->save();
        }
        return response()->json([
        'message' => 'Peminjaman berhasil dilakukan!'
    ], 200);
    }

    public function destroy($id)
{
    try {
        $peminjaman = Peminjaman::findOrFail($id);
        $user = User::where('nama', $peminjaman->nama_peminjam)->first();

        if ($user) {
            $peminjaman->delete();
            $jumlahPeminjamanAktif = Peminjaman::where('nama_peminjam', $user->nama)
                                                ->where('status_pengembalian', 'dipinjam')
                                                ->count();
            if ($jumlahPeminjamanAktif === 0) {
                $user->status = 'Tidak meminjam';
                $user->save();
            }
        }
        session()->flash('success', 'Peminjaman berhasil dihapus dan status pengguna diperbarui.');

        return redirect()->route('peminjamanData');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}

public function update(Request $request, $id)
{
    $request->validate([
        'status_pengembalian' => 'required|string',
    ]);
    
    $peminjaman = Peminjaman::findOrFail($id);
    $statusBaru = $request->status_pengembalian;
    $peminjaman->status_pengembalian = $request->status_pengembalian;
    $peminjaman->save();

    if ($statusBaru == 'Dikembalikan') {
        $tanggalSekarang = Carbon::now();
        $tanggalPengembalian = Carbon::parse($peminjaman->tanggal_pengembalian);

        if ($tanggalSekarang->gt($tanggalPengembalian)) {
            $overdueWeeks = $tanggalSekarang->diffInWeeks($tanggalPengembalian, false);
            $denda = max(0, ceil(abs($overdueWeeks)) * 5000); // Assume 5000 per week
            
            Denda::create([
                'nama_peminjam' => $peminjaman->nama_peminjam,
                'judul_buku' => $peminjaman->judul,
                'denda' => $denda,
                'status_denda' => 'Belum Lunas'
            ]);
            $peminjaman->status_pengembalian = 'Dikembalikan terlambat';
        }
        $book = Book::where('title', $peminjaman->judul)->first();
        if($book){
            $book->status_buku = 'tersedia';
            $book->save();
        }        
    }
    $peminjaman->save();

    $user = User::where('nama', $peminjaman->nama_peminjam)->first();
    
    if ($user) {
        $peminjamanAktif = Peminjaman::where('nama_peminjam', $user->nama)
            ->whereNotIn('status_pengembalian', ['Dikembalikan', 'Dikembalikan terlambat'])
            ->count();
        if ($peminjamanAktif == 0) {
            $user->status = 'Tidak meminjam';
            $user->save();
        }
    }
}


}
