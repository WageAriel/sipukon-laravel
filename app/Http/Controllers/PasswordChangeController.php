<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class PasswordChangeController extends Controller
{
    public function showChangePasswordForm()
{
    return Inertia::render('ChangePasswordForm');
}
public function updatePassword(Request $request)
{
    $request->validate([
        'old_password' => 'required|string',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::user();

    // Memastikan bahwa password lama cocok
    if (!Hash::check($request->old_password, $user->password)) {
        return back()->withErrors(['old_password' => 'Password lama tidak cocok.']);
    }

    $user->password = bcrypt($request->password);
    $user->save();

    return redirect()->route('profile.show')->with('success', 'Password berhasil diubah!');
}

}
