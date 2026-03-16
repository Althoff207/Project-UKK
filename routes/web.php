<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\LibrarianController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;

// Route Auth (Bisa diakses tanpa login)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman utama (Jika belum login ke login, jika sudah ke dashboard)
Route::get('/', function () {
    return redirect()->route('login');
});

// Route yang butuh login
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::post('/borrow/{id}', [BorrowController::class, 'store'])->name('borrow.store');
    Route::get('/history', [UserController::class, 'history'])->name('user.history');
});

Route::middleware(['auth', 'role:librarian'])->group(function () {
    Route::get('/librarian/dashboard', [LibrarianController::class, 'index'])->name('librarian.dashboard');
    // Route untuk setuju/tolak
    Route::patch('/librarian/borrow/{id}/{status}', [LibrarianController::class, 'updateStatus'])->name('librarian.borrow.update');

    Route::get('/librarian/returns', [LibrarianController::class, 'borrowedBooks'])->name('librarian.returns');
    Route::patch('/librarian/return/{id}', [LibrarianController::class, 'returnBook'])->name('librarian.return.process');

    Route::resource('/librarian/books', BookController::class)->names([
        'index' => 'librarian.books.index',
        'create' => 'librarian.books.create',
        'store' => 'librarian.books.store',
        'edit' => 'librarian.books.edit',
        'update' => 'librarian.books.update',
        'destroy' => 'librarian.books.destroy',
    ]);

    Route::resource('/librarian/categories', CategoryController::class)->names([
        'index' => 'librarian.categories.index',
        'create' => 'librarian.categories.create',
        'store' => 'librarian.categories.store',
        'edit' => 'librarian.categories.edit',
        'update' => 'librarian.categories.update',
        'destroy' => 'librarian.categories.destroy',
    ]);
});