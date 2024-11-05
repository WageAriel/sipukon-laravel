<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Group all user routes under auth and verified middleware
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/user', [UserController::class, 'index'])->name('user');
    Route::post('/dashboard/user', [UserController::class, 'store'])->name('user.store');
    Route::put('/dashboard/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/dashboard/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/dashboard/user/json', [UserController::class, 'getAllUsers'])->name('user.json');
});


require __DIR__ . '/auth.php';
