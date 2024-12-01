<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Fakultas;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ProdiController extends Controller
{
    public function getAllProdi()
    {
        $prodis = Prodi::orderBy('nama_prodi')->get();
        return response()->json(['data' => $prodis], 200);
    }

    public function index()
{
    $prodis = Prodi::orderBy('nama_prodi')->get();
    $fakultass = Fakultas::orderBy('nama_fakultas')->get(); 

    return Inertia::render('ProdiView', [
        'data' => $prodis,
        'fakultass' => $fakultass
    ]);
}


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_fakultas' => 'required|exists:fakultas,nama_fakultas', 
                'nama_prodi' => 'required|string|max:255',
            ]);

            Prodi::create([
                'nama_fakultas' => $validated['nama_fakultas'],  
                'nama_prodi' => $validated['nama_prodi'],
            ]);

            return redirect()->route('prodi');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, Prodi $id)
    {
        $validated = $request->validate([
            'nama_fakultas' => 'nullable|string|max:255|exists:fakultas,nama_fakultas',
            'nama_prodi' => 'nullable|string|max:255',
        ]);

        $dataToUpdate = [];

        if ($request->filled('nama_prodi')) {
            $dataToUpdate['nama_prodi'] = $validated['nama_prodi'];
        }
        if ($request->filled('nama_fakultas')) {
            $dataToUpdate['nama_fakultas'] = $validated['nama_fakultas'];
        }

        $id->update($dataToUpdate);

        return redirect()->route('prodi');
    }

    public function destroy($id)
    {
        Prodi::destroy($id);
        return redirect()->route('prodi');
    }
}
