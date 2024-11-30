<?php

namespace App\Http\Controllers;
use App\Models\Denda;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DendaController extends Controller
{
    public function getAllDenda()
    {
        $dendas = Denda::all();
        return response()->json([
            'data' => $dendas
        ], 200);
    }
    
    public function index()
    {
        $dendas = Denda::all();
        return Inertia::render('DendaView', ['data' => $dendas]);
    }
    public function update(Request $request, $id)
{
    $denda = Denda::findOrFail($id);

    // Validasi dan update hanya status denda
    $validated = $request->validate([
        'status_denda' => 'required|in:lunas,belum_lunas',
    ]);

    $denda->update([
        'status_denda' => $validated['status_denda'],
    ]);

    // return response()->json(['message' => 'Status denda berhasil diperbarui']);
}



}
