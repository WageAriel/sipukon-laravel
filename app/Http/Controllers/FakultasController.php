<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class FakultasController extends Controller
{
    public function getAllFakultas()
    {
        $fakultass = Fakultas::orderBy('nama_fakultas')->get();
        return response()->json(['data' => $fakultass], 200);
    }

    public function index()
    {
        $fakultass = Fakultas::orderBy('nama_fakultas')->get();
        return Inertia::render('FakultasView', ['data' => $fakultass]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_fakultas' => 'required|string|max:255',
            ]);

            Fakultas::create([
                'nama_fakultas' => $validated['nama_fakultas'],
            ]);

            return redirect()->route('fakultas');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, Fakultas $id)
    {
        $validated = $request->validate([
            'nama_fakultas' => 'nullable|string|max:255',
        ]);

        $dataToUpdate = [];

        if ($request->filled('nama_fakultas')) {
            $dataToUpdate['nama_fakultas'] = $validated['nama_fakultas'];
        }

        $id->update($dataToUpdate);

        return redirect()->route('fakultas');
    }

    public function destroy($id)
    {
        Fakultas::destroy($id);
        return redirect()->route('fakultas');
    }
}
