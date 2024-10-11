<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
route::get('/', function () {
    return view('welcome');
});
// Route untuk menampilkan halaman login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Route untuk menangani proses login
Route::post('/login', [AuthController::class, 'login']);

// Route untuk dashboard admin (hanya diakses oleh admin)
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth', 'role:admin')->name('admin.dashboard');

// Route untuk halaman index (untuk selain admin)
Route::get('/index', function () {
    return view('index');
})->middleware('auth')->name('index');

// Route untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
