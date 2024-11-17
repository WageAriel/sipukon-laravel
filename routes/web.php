<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\PeminjamanController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

// Halaman utama
// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//     ]);
// })->name('welcome');


// Halaman login





Route::get('/sign-up', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/sign-up', [RegisterController::class, 'store'])->name('register.store');

// Menampilkan formulir ubah password
Route::get('/change-password', [PasswordChangeController::class, 'showChangePasswordForm'])
->middleware('auth')
->name('password.change');

Route::post('/change-password', [PasswordChangeController::class, 'updatePassword'])
    ->middleware('auth')
    ->name('password.update');
// Mengupdate password
// Rute untuk memperbarui password



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
Route::middleware(['auth', 'verified'])->get('/dashboard/user', function () {
    $user = Auth::user();
    if ($user && $user->role !== 'admin') {
        return redirect()->route('landing')->with('error', 'Unauthorized access.');
    }
    return Inertia::render('UserView');
})->name('user');

Route::get('/home', function () {
    return Inertia::render('HomeView'); // Replace 'HomeView' with the actual Vue component
})->name('home');

Route::get('/library', function () {
    return Inertia::render('LibraryPage'); // Replace 'LibraryView' with the actual Vue component
})->name('library');

Route::post('/lending', [PeminjamanController::class, 'store']); // Menyimpan peminjaman

Route::get('/lending', function () {
    return Inertia::render('FormPeminjaman'); // Replace 'LendingView' with the actual Vue component
})->name('lending');

Route::get('/about', function () {
    return Inertia::render('AboutPage'); // Replace 'AboutView' with the actual Vue component
})->name('about');

Route::middleware([])->get('/', function () {
    return Inertia::render('LandingPage');
})->name('landing');


Route::middleware(['auth:sanctum', 'verified'])->get('/tables', function () {
    return Inertia::render('TablesView');
})->name('tables');

Route::middleware(['auth:sanctum', 'verified'])->get('/users', function () {
    return Inertia::render('UserView');
})->name('users');

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

Route::middleware(['auth:sanctum', 'verified'])->get('/user', function () {
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
require __DIR__.'/UserRoute.php';
require __DIR__.'/ProdiRoute.php';
require __DIR__.'/PeminjamanRoute.php';

