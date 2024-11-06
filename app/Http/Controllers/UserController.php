<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
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
        'name' => 'required|string|max:255',
        'email' => 'nullable|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:8',
        'role' => 'required|string|max:50',
        'nama' => 'nullable|string|max:255',
        
    ]);

    // If validation passes, create the user
    User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'role' =>  'user',
        'nama' => $validated['nama'],
    ]);

    return redirect()->route('user'); // Redirects if successful
}


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); // Fetch user by ID

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $dataToUpdate = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        $user->update($dataToUpdate); // Update user data

        return redirect()->route('user');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'User deleted successfully']);
    }
    
}
