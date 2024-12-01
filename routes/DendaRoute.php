<?php
use App\Http\Controllers\DendaController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/denda', [DendaController::class, 'index'])->name('denda');
    Route::put('/dashboard/denda/{id}', [DendaController::class, 'update'])->name('denda.update');
});
Route::get('/data-denda', [DendaController::class, 'getAllDenda']);

require __DIR__ . '/auth.php';
