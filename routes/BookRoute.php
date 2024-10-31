<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/buku', [BookController::class, 'index'])->name('buku');
    Route::post('/dashboard/buku', [BookController::class, 'store'])->name('buku.store');
    Route::put('/dashboard/buku/{id}', [BookController::class, 'update'])->name('buku.update');
    Route::delete('/dashboard/buku/{id}', [BookController::class, 'destroy'])->name('buku.destroy');
});

Route::get('/data-buku', [BookController::class, 'getAllBooks']);

require __DIR__ . '/auth.php';
