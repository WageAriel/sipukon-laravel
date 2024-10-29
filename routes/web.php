<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('HomeView');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('HomeView');
})->name('dashboard');

// Route::middleware(['auth:sanctum', 'verified'])->get('/tables', function () {
//     return Inertia::render('TablesView');
// })->name('tables');

// Route::middleware(['auth:sanctum', 'verified'])->get('/forms', function () {
//     return Inertia::render('FormsView');
// })->name('forms');

// Route::middleware(['auth:sanctum', 'verified'])->get('/ui', function () {
//     return Inertia::render('UiView');
// })->name('ui');

// Route::middleware(['auth:sanctum', 'verified'])->get('/responsive', function () {
//     return Inertia::render('ResponsiveView');
// })->name('responsive');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
