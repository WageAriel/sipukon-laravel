<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\HomeViewController;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

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
Route::middleware(['auth', 'verified'])->get('/dashboard', [HomeViewController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'verified'])->get('/dashboard/user', function () {
    $user = Auth::user();
    if ($user && $user->role !== 'admin') {
        return redirect()->route('landing')->with('error', 'Unauthorized access.');
    }
    return Inertia::render('UserView');
})->name('user');

// Route::get('/home', function () {
//     return Inertia::render('HomeView');
// })->name('home');

Route::get('/library', 
    [BookController::class, 'library'])
->name('library');

Route::post('/lending', [PeminjamanController::class, 'store']);

Route::get('/lending', function (Request $request) {
    return Inertia::render('FormPeminjaman', [
        'judul' => $request->query('judul', ''),
    ]);
})->name('lending');



Route::get('/about', function () {
    return Inertia::render('AboutPage'); 
})->name('about');

Route::middleware([])->get('/', function () {
    return Inertia::render('LandingPage');
})->name('landing');

Route::middleware([])->get('/', [LandingController::class, 'index'])->name('landing');


Route::middleware(['auth:sanctum', 'verified'])->get('/books', function () {
    return Inertia::render('BukuView');
})->name('books');

Route::middleware(['auth:sanctum', 'verified'])->get('/fakultas', function () {
    return Inertia::render('FakultasView');
})->name('fakultas');

Route::middleware(['auth:sanctum', 'verified'])->get('/denda', function () {
    return Inertia::render('DendaView');
})->name('denda');

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
require __DIR__.'/FakultasRoute.php';
require __DIR__.'/DendaRoute.php';

