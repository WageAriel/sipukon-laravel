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
                                        ->where('status_pengembalian', 'Dipinjam')
                                        ->count();

    if ($jumlahPeminjamanAktif >= 2) {
        return response()->json([], 422);
    }

    $tanggalPeminjaman = Carbon::now();
    $tanggalPengembalian = $tanggalPeminjaman->copy()->addDays(7);

        // Buat peminjaman baru
        Peminjaman::create([
            'judul' => $request->judul,
            'nama_peminjam' => $user->nama,
            'tanggal_peminjaman' => $tanggalPeminjaman,
            'tanggal_pengembalian' => $tanggalPengembalian,
            'metode_pengambilan' => $request->metode_pengambilan,
            'alamat' => $request->alamat,
            'status_pengembalian' => 'Dipinjam',
        ]);

        $book->increment('banyaknya_dipinjam');

        // Ambil pengguna yang sedang login
        $user = User::find(Auth::id());
        if ($user) {
            // Ubah status menjadi "meminjam"
            $user->status = 'Meminjam';
            $user->save();
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

public function update(Request $request, $id)
{
    $request->validate([
        'status_pengembalian' => 'required|string',
    ]);

    $peminjaman = Peminjaman::findOrFail($id);
    $statusBaru = $request->status_pengembalian;

    // Check if the status is 'Dikembalikan'
    if ($statusBaru == 'Dikembalikan') {
        $tanggalSekarang = Carbon::now();
        $tanggalPengembalian = Carbon::parse($peminjaman->tanggal_pengembalian);

        // If the return date is overdue
        if ($tanggalSekarang->gt($tanggalPengembalian)) {
            // Calculate the overdue period in days
            $overdueWeeks = $tanggalSekarang->diffInWeeks($tanggalPengembalian, false);
            $denda = max(0, ceil(abs($overdueWeeks)) * 5000); // Assume 5000 per week
            
            // Add denda to the Denda table
            Denda::create([
                'nama_peminjam' => $peminjaman->nama_peminjam,
                'denda' => $denda,
                'status_denda' => 'Belum Lunas'
            ]);

            // Show a SweetAlert with the overdue fine
            // return response()->json([
            //     'message' => 'Peminjaman dikembalikan terlambat, denda: Rp ' . number_format($denda, 0, ',', '.'),
            //     'denda' => $denda
            // ], 422);
        }
    }

    $peminjaman->status_pengembalian = $request->status_pengembalian;
    $peminjaman->save();

    // return response()->json(['message' => 'Status berhasil diperbarui!'], 200);
}


}


