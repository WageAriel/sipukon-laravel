<?php

use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/peminjaman', function () {
        $user = Auth::user();
        if ($user && $user->role !== 'admin') {
            return redirect()->route('landing')->with('error', 'Unauthorized access.');
        }
        return app()->call('App\Http\Controllers\PeminjamanController@index');
    })->name('peminjamanData');

    Route::delete('/dashboard/peminjaman/{id}', function ($id) {
        $user = Auth::user();
        if ($user && $user->role !== 'admin') {
            return redirect()->route('landing')->with('error', 'Unauthorized access.');
        }
        return app()->call('App\Http\Controllers\PeminjamanController@destroy', ['id' => $id]);
    })->name('peminjaman.destroy');
    Route::put('/dashboard/peminjaman/{id}', function (Request $request, $id) {
    $user = Auth::user();
    if ($user && $user->role !== 'admin') {
        return redirect()->route('landing')->with('error', 'Unauthorized access.');
    }
    return app()->call('App\Http\Controllers\PeminjamanController@update', ['request' => $request, 'id' => $id]);
})->name('peminjaman.update');

});


Route::get('/data-buku', [PeminjamanController::class, 'getAllPeminjaman']);

require __DIR__ . '/auth.php';
