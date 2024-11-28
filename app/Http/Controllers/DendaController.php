<?php

namespace App\Http\Controllers;
use App\Models\Denda;

use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function bayar($id)
{
    try {
        $denda = Denda::findOrFail($id);
        $denda->update([
            'status' => 'lunas', // Update status menjadi lunas
        ]);

        return response()->json(['message' => 'Denda berhasil dibayar.'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Gagal membayar denda.', 'message' => $e->getMessage()], 500);
    }
}


}
