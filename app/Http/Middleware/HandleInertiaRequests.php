<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Peminjaman;
use App\Models\Fakultas;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
{
    // Periksa apakah pengguna sudah login
    $user = auth()->user();
    $fakultas = Fakultas::all();

    // Jika pengguna belum login, kirimkan respons array dengan informasi status atau kesalahan
    if (!$user) {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => null,  // Pengguna null jika belum login
                'peminjaman' => [],
                'error' => 'User is not logged in',  // Pesan kesalahan atau status
            ],
            'fakultass' => $fakultas,
        ];
    }

    // Ambil peminjaman yang statusnya "Dipinjam" dan nama peminjam sesuai dengan user yang login
    $peminjaman = Peminjaman::where('nama_peminjam', $user->nama)
        ->where('status_pengembalian', 'Dipinjam')
        ->get();

    return [
        ...parent::share($request),
        'auth' => [
            'user' => $user,
            'peminjaman' => $peminjaman,
        ],
        'fakultass' => $fakultas,
    ];
}


}
