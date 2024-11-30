<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Peminjaman;

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
        $user = auth()->user();

        // Ambil peminjaman yang statusnya "Dipinjam" dan nama peminjam sesuai dengan user yang login
        $peminjaman = Peminjaman::where('nama_peminjam', $user->nama)
            ->where('status_pengembalian', 'Dipinjam')
            ->get();

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'peminjaman' => $peminjaman,
            ],
        ];
    }
}
