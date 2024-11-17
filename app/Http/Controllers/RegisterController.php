<?php

namespace App\Http\Controllers;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showProfile()
{
    return Inertia::render('profileView', [
        'auth' => [
            'user' => Auth::user() // Mengambil data pengguna yang sedang login
        ]
    ]);
}
    public function showRegisterForm()
    {
        $prodi = Prodi::all();
        return Inertia::render('registerView', [
            'prodi' => $prodi
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email', // Set email sebagai wajib
            'password' => 'required|string|min:8|confirmed', // Konfirmasi password
            'nama' => 'required|string|max:255',
            'prodi' => 'required|string|exists:prodi,nama_prodi',
        ]);
    
        // Buat user baru dengan role default 'user'
        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'user', // Set role default sebagai 'user'
            'nama' => $validated['nama'],
            'prodi' => $validated['prodi']
        ]);
    
        // Redirect ke halaman lain atau menampilkan pesan sukses
        return redirect()->route('login')->with('success', 'Registration successful!');
    }
    
}
