<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LibrarianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;

// --- AUTH ROUTES ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('login');
});

// --- USER/STUDENT ROUTES ---
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {

    // 1. ROUTE WAJIB GANTI PASSWORD (Hanya untuk login pertama)
    // Diletakkan di luar middleware pencegat agar tidak redirect berulang (loop)
    Route::get('/first-login-change-password', [UserController::class, 'showChangePassword'])->name('password.first-login');
    Route::post('/first-login-change-password', [UserController::class, 'updatePasswordFirstTime'])->name('password.update-first');

    // 2. ROUTE PROFIL/GANTI PASSWORD MANDIRI (Bisa diakses kapan saja setelah login pertama)
    // Nama route: user.profile.index dan user.profile.update
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.index');
    Route::patch('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

    // 3. ROUTE FITUR UTAMA (Dibungkus Middleware ForceChangePassword)
    // Siswa tidak bisa buka dashboard, buku, atau history kalau belum melewati tahap 1
    Route::middleware([\App\Http\Middleware\ForceChangePassword::class])->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
        Route::post('/borrow/{id}', [BorrowController::class, 'store'])->name('borrow.store');
        Route::get('/books/{id}', [UserController::class, 'show'])->name('books.detail');
        Route::get('/history', [UserController::class, 'history'])->name('history');
    });
});

// --- LIBRARIAN ROUTES (FIXED) ---
Route::middleware(['auth', 'role:librarian'])->prefix('librarian')->name('librarian.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [LibrarianController::class, 'index'])->name('dashboard');

    // Antrean Persetujuan - SEKARANG JADI librarian.approval
    Route::get('/approval', [LibrarianController::class, 'approvalList'])->name('approval');
    Route::patch('/borrow/{id}/{status}', [LibrarianController::class, 'updateStatus'])->name('borrow.update');

    // Pengembalian - SEKARANG JADI librarian.return
    Route::get('/return', [LibrarianController::class, 'borrowedBooks'])->name('returns');
    Route::patch('/return-process/{id}', [LibrarianController::class, 'returnBook'])->name('return.process');

    // Resource CRUD Buku & Kategori
    Route::resource('books', BookController::class);
    Route::resource('categories', CategoryController::class);
});

// --- ADMIN ROUTES ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Manajemen User
    Route::post('/users/import', [AdminController::class, 'import'])->name('users.import');
    Route::resource('users', AdminController::class)->except(['show']);
});
