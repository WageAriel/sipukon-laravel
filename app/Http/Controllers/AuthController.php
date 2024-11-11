<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AuthController extends Controller
{
//     public function login(Request $request)
//     {
//         $credentials = $request->only('email', 'password');
    
//         // Validasi input
//         $request->validate([
//             'email' => 'required|email',
//             'password' => 'required',
//         ]);
    
//         // Cek kredensial
//         $user = Auth::user();
// if ($user && $user->role === 'admin') {
//     return response()->json(['redirect' => route('dashboard')]);
// } elseif ($user && $user->role === 'user') {
//     return response()->json(['redirect' => route('landing')]);
// }

    
//         return response()->json(['error' => 'Unauthorized'], 401);
//     }

public function login(Request $request)
{
    // Validasi input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Mengambil kredensial dari permintaan
    $credentials = $request->only('email', 'password');

    // Cek kredensial dan lakukan login
    if (Auth::attempt($credentials)) {
        $user = Auth::user(); // Ambil pengguna yang sedang login

        // Arahkan berdasarkan role pengguna
        if ($user->role === 'admin') {
            return redirect()->route('dashboard'); // Ganti dengan route dashboard yang sesuai
        } elseif ($user->role === 'user') {
            return redirect()->route('landing'); // Ganti dengan route landing yang sesuai
        }
    }

    // Jika login gagal
    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
}

    

    



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }
}
