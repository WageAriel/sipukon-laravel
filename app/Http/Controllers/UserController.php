<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required|string',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::user();

    // Cek apakah password saat ini benar
    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json(['error' => 'Current password is incorrect'], 403);
    }

    // Update password
    $user->password = Hash::make($request->new_password);
    $user->save();

    return response()->json(['message' => 'Password updated successfully']);
}

    public function showProfile()
{
    return Inertia::render('ProfilView', [
        'user' => auth()->user() // Mengirimkan data pengguna yang sedang login
    ]);
}
    public function changePassword(Request $request)
{
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:8',
    ]);

    $user = auth()->user();

    // Periksa apakah password lama cocok
    if (!Hash::check($request->old_password, $user->password)) {
        return back()->withErrors(['old_password' => 'Password lama tidak cocok.']);
    }

    // Menggunakan bcrypt untuk mengubah password baru
    $user->password = bcrypt($request->new_password);
    $user->save();

    return back()->with('status', 'Password berhasil diubah.');
}

    public function getAllUsers()
    {
        $users = User::all(); // Fetch all users
        return response()->json([
            'data' => $users
        ], 200);
    }

    public function index()
    {
        $users = User::all();
        return Inertia::render('UserView', ['data' => $users]);
        // return Inertia::render('registerView');
    }
   

    public function store(Request $request)
{
    $validated = $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'nullable|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:8',
        'role' => 'required|string|max:50',
        'nama' => 'nullable|string|max:255',
        
    ]);

    // If validation passes, create the user
    User::create([
        'username' => $validated['username'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'role' =>  'user',
        'nama' => $validated['nama'],
    ]);

    return redirect()->route('user'); // Redirects if successful
}

public function updateStatus(Request $request)
{
    \Log::info('Received request to update status for user_id: ' . $request->user_id);
    $user = User::find($request->user_id);
    
    if ($user) {
        $user->status = 'Meminjam';
        $user->save();
        \Log::info('Successfully updated status to meminjam for user_id: ' . $user->id);
        return response()->json(['message' => 'Status updated successfully']);
    }

    \Log::error('User not found with user_id: ' . $request->user_id);
    return response()->json(['message' => 'User not found'], 404);
}


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); // Fetch user by ID

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $dataToUpdate = [
            'username' => $validated['username'],
            'email' => $validated['email'],
        ];

        $user->update($dataToUpdate); // Update user data

        return redirect()->route('user');
    }

    public function destroy(User $user)
{
    // Pastikan pengguna yang akan dihapus adalah pengguna yang sedang login
    if (auth()->user()->id !== $user->id) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // Hapus akun pengguna
    $user->delete();

    // Logout pengguna setelah akun dihapus
    auth()->logout();

    return redirect('/')->with('status', 'Akun berhasil dihapus.');
}
    
}
