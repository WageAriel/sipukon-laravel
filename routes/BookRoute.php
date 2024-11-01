<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/buku', function () {
        $user = Auth::user();
        if ($user && $user->role !== 'admin') {
            return redirect()->route('landing')->with('error', 'Unauthorized access.');
        }
        return app()->call('App\Http\Controllers\BookController@index');
    })->name('buku');

    Route::post('/dashboard/buku', function () {
        $user = Auth::user();
        if ($user && $user->role !== 'admin') {
            return redirect()->route('landing')->with('error', 'Unauthorized access.');
        }
        return app()->call('App\Http\Controllers\BookController@store');
    })->name('buku.store');

    Route::put('/dashboard/buku/{id}', function ($id) {
        $user = Auth::user();
        if ($user && $user->role !== 'admin') {
            return redirect()->route('landing')->with('error', 'Unauthorized access.');
        }
        return app()->call('App\Http\Controllers\BookController@update', ['id' => $id]);
    })->name('buku.update');

    Route::delete('/dashboard/buku/{id}', function ($id) {
        $user = Auth::user();
        if ($user && $user->role !== 'admin') {
            return redirect()->route('landing')->with('error', 'Unauthorized access.');
        }
        return app()->call('App\Http\Controllers\BookController@destroy', ['id' => $id]);
    })->name('buku.destroy');
});


Route::get('/data-buku', [BookController::class, 'getAllBooks']);

require __DIR__ . '/auth.php';
