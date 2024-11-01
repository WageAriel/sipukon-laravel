<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

// Halaman utama
Route::get('/landing', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('welcome');

// Halaman login
Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');

// Proses login
Route::post('/login', [AuthController::class, 'login']);

// Halaman dashboard
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = Auth::user();
    if ($user && $user->role !== 'admin') {
        return redirect()->route('landing')->with('error', 'Unauthorized access.');
    }
    return Inertia::render('HomeView');
})->name('dashboard');


Route::middleware([])->get('/landing', function () {
    return Inertia::render('LandingPage');
})->name('landing');


Route::middleware(['auth:sanctum', 'verified'])->get('/tables', function () {
    return Inertia::render('TablesView');
})->name('tables');

Route::middleware(['auth:sanctum', 'verified'])->get('/books', function () {
    return Inertia::render('BukuView');
})->name('books');

Route::middleware(['auth:sanctum', 'verified'])->get('/forms', function () {
    return Inertia::render('FormsView');
})->name('forms');

Route::middleware(['auth:sanctum', 'verified'])->get('/ui', function () {
    return Inertia::render('UiView');
})->name('ui');

Route::middleware(['auth:sanctum', 'verified'])->get('/responsive', function () {
    return Inertia::render('ResponsiveView');
})->name('responsive');

// Halaman landing

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Include auth routes
require __DIR__.'/auth.php';
require __DIR__.'/BookRoute.php';

