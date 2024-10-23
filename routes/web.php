<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SertifikatController;



route::get('/', function () {
    return view('welcome');
});
// Route untuk menampilkan halaman login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// route unutk register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');


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

//route Sertifikat
route::get('sertifikat', [SertifikatController::class, 'index'])->name('sertifikat.index');
Route::get('sertifikat/data', [SertifikatController::class, 'getData'])->name('sertifikat.data');
Route::get('sertifikat/download/{id}', [SertifikatController::class, 'download'])->name('sertifikat.download');
Route::get('/sertifikat/create', [SertifikatController::class, 'create'])->name('sertifikat.create');
Route::post('/sertifikat/store', [SertifikatController::class, 'store'])->name('sertifikat.store');
