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
            // 'nama_peminjam' => 'required|string',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date',
            'metode_pengambilan' => 'required|string',
            'alamat' => 'nullable|string',
        ]);

        $user = Auth::user();
    if (!$user) {
        return response()->json(['message' => 'User not logged in.'], 403);
    }


        // Cek apakah buku tersedia
        $book = Book::where('title', $request->judul)->first();
        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan.'], 404);
        }
        
        $jumlahPeminjamanAktif = Peminjaman::where('nama_peminjam', $user->nama)
                                        ->where('status_pengembalian', 'dipinjam')
                                        ->count();

    if ($jumlahPeminjamanAktif >= 2) {
        return response()->json([], 422);
    }

        // Buat peminjaman baru
        Peminjaman::create([
            'judul' => $request->judul,
            'nama_peminjam' => $user->nama,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'metode_pengambilan' => $request->metode_pengambilan,
            'alamat' => $request->alamat,
            'status_pengembalian' => 'dipinjam',
        ]);

        $book->increment('banyaknya_dipinjam');

        // Ambil pengguna yang sedang login
        $user = User::find(Auth::id());
        if ($user) {
            // Ubah status menjadi "meminjam"
            $user->status = 'Meminjam';
            $user->save();
        }

        $tanggalPengembalian = Carbon::parse($request->tanggal_pengembalian);
    $tanggalSekarang = Carbon::now();

    if ($tanggalSekarang->gt($tanggalPengembalian)) { // Jika sekarang > tanggal pengembalian
        $denda = 5000;

        // Cari atau buat data denda untuk pengguna ini
        $dendaRecord = Denda::firstOrCreate(
            ['nama_peminjam' => $user->nama],
            ['denda' => 0]
        );

        // Tambahkan denda
        $dendaRecord->denda += $denda;
        $dendaRecord->save();
    }
        // Kembalikan respon atau redirect sesuai kebutuhan
        return response()->json([
        'message' => 'Peminjaman berhasil dilakukan!'
    ], 200);
    }

    public function destroy($id)
{
    try {
        $peminjaman = Peminjaman::findOrFail($id);

        // Ambil pengguna berdasarkan nama peminjam
        $user = User::where('nama', $peminjaman->nama_peminjam)->first();

        if ($user) {
            // Hapus data peminjaman
            $peminjaman->delete();

            // Cek jumlah peminjaman aktif setelah penghapusan
            $jumlahPeminjamanAktif = Peminjaman::where('nama_peminjam', $user->nama)
                                                ->where('status_pengembalian', 'dipinjam')
                                                ->count();

            // Jika tidak ada lagi peminjaman aktif, perbarui status pengguna menjadi "tidak meminjam"
            if ($jumlahPeminjamanAktif === 0) {
                $user->status = 'Tidak meminjam';
                $user->save();
            }
        }

        // Set flash message untuk notifikasi swal di frontend
        session()->flash('success', 'Peminjaman berhasil dihapus dan status pengguna diperbarui.');

        return redirect()->route('peminjamanData');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}


}


