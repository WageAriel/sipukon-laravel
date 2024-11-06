<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return Inertia::render('registerView'); // Mengarahkan ke registerView.vue
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email', // Set email sebagai wajib
            'password' => 'required|string|min:8|confirmed', // Konfirmasi password
            'nama' => 'required|string|max:255',
        ]);
    
        // Buat user baru dengan role default 'user'
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'user', // Set role default sebagai 'user'
            'nama' => $validated['nama'],
        ]);
    
        // Redirect ke halaman lain atau menampilkan pesan sukses
        return redirect()->route('login')->with('success', 'Registration successful!');
    }
    
}
