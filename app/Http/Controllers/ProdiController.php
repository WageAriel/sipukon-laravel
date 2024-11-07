<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
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
        return Inertia::render('ProdiView', ['data' => $prodis]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_prodi' => 'required|string|max:255',
            ]);

            Prodi::create([
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
            'nama_prodi' => 'nullable|string|max:255',
        ]);

        $dataToUpdate = [];

        if ($request->filled('nama_prodi')) {
            $dataToUpdate['nama_prodi'] = $validated['nama_prodi'];
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
