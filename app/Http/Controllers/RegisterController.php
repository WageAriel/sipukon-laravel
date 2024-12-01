<?php

namespace App\Http\Controllers;
use App\Models\Prodi;
use App\Models\Fakultas;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $fakultas = Fakultas::all();

    // Ambil semua prodi
    $prodi = Prodi::all();

    return Inertia::render('registerView', [
        'fakultas' => $fakultas,
        'prodi' => $prodi
    ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nama' => 'required|string|max:255',
            'fakultas' => 'required|string|exists:fakultas,nama_fakultas',
            'prodi' => 'required|string|exists:prodi,nama_prodi',
        ]);
    
        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'user',
            'nama' => $validated['nama'],
            'fakultas' => $validated['fakultas'],
            'prodi' => $validated['prodi']
        ]);
        return redirect()->route('login')->with('success', 'Registration successful!');
    }
    
}
