<?php
use App\Http\Controllers\FakultasController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/fakultas', [FakultasController::class, 'index'])->name('fakultas');
    Route::post('/dashboard/fakultas', [FakultasController::class, 'store'])->name('fakultas.store');
    Route::put('/dashboard/fakultas/{id}', [FakultasController::class, 'update'])->name('fakultas.update');
    Route::delete('/dashboard/fakultas/{id}', [FakultasController::class, 'destroy'])->name('fakultas.destroy');
});
Route::get('/data-fakultas', [FakultasController::class, 'getAllFakultas']);

require __DIR__ . '/auth.php';
