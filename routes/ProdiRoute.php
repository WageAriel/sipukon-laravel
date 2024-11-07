<?php
use App\Http\Controllers\ProdiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/prodi', [ProdiController::class, 'index'])->name('prodi');
    Route::post('/dashboard/prodi', [ProdiController::class, 'store'])->name('prodi.store');
    Route::put('/dashboard/prodi/{id}', [ProdiController::class, 'update'])->name('prodi.update');
    Route::delete('/dashboard/prodi/{id}', [ProdiController::class, 'destroy'])->name('prodi.destroy');
});
Route::get('/data-prodi', [ProdiController::class, 'getAllProdi']);

require __DIR__ . '/auth.php';
