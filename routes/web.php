<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LspController;
use App\Http\Controllers\AuthController;;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\UmumAdminController;
use App\Http\Controllers\DosenAdminController;
use App\Http\Controllers\MahasiswaAdminController;
use App\Http\Controllers\KategoriPelatihanController;
use App\Http\Controllers\SertifikatController;


route::get('/', function () {
    return view('welcome');
});
// Route untuk menampilkan halaman login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// route unutk register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register/masyarakat', [MasyarakatController::class, 'register'])->name('register.masyarakat');


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

//route sertifikat
Route::middleware(['auth'])->group(function () {
    Route::get('/sertifikat', [SertifikatController::class, 'index'])->name('sertifikat.index');
    Route::get('/sertifikat/data', [SertifikatController::class, 'getData'])->name('sertifikat.data');
    Route::get('/sertifikat/download/{id}', [SertifikatController::class, 'download'])->name('sertifikat.download');
    Route::delete('/sertifikat/{id}', [SertifikatController::class, 'destroy'])->name('sertifikat.destroy');
    Route::post('/sertifikat', [SertifikatController::class, 'store'])->name('sertifikat.store');
    Route::get('/sertifikat/create', [SertifikatController::class, 'create'])->name('sertifikat.create');

});

//Grfik
Route::get('/grafik', [SertifikatController::class, 'chart'])->name('grafik.grafik');
Route::get('/grafik/mahasiswa', [SertifikatController::class, 'PresentaseMahasiswa'])->name('grafik.mahasiswa');

//Testing
route::get('/Deskripsi', [PelatihanController::class, 'deskripsi'])->name('pelatihan.deskripsi');
route::get('/DaftarPelatihan', [PelatihanController::class, 'daftarPelatihan'])->name('pelatihan.daftar');


//Route Admin
//User
//  Dosen
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('dosen', [DosenAdminController::class, 'index'])->name('admin.dosen.index');
    Route::get('dosen/create', [DosenAdminController::class, 'create'])->name('admin.dosen.create');
    Route::post('dosen/store', [DosenAdminController::class, 'store'])->name('admin.dosen.store'); 
    Route::get('dosen/edit/{id}', [DosenAdminController::class, 'edit'])->name('admin.dosen.edit'); 
    Route::put('dosen/{id}', [DosenAdminController::class, 'update'])->name('admin.dosen.update');
    Route::delete('dosen/{id}', [DosenAdminController::class, 'destroy'])->name('admin.dosen.destroy');
});

//  Mahasiswa
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('mahasiswa', action: [MahasiswaAdminController::class, 'index'])->name('admin.mahasiswa.index');
    Route::get('mahasiswa/create', [MahasiswaAdminController::class, 'create'])->name('admin.mahasiswa.create');
    Route::post('mahasiswa/store', [MahasiswaAdminController::class, 'store'])->name('admin.mahasiswa.store'); 
    Route::get('mahasiswa/edit/{id}', [MahasiswaAdminController::class, 'edit'])->name('admin.mahasiswa.edit'); 
    Route::put('mahasiswa/{id}', [MahasiswaAdminController::class, 'update'])->name('admin.mahasiswa.update');
    Route::delete('mahasiswa/{id}', [MahasiswaAdminController::class, 'destroy'])->name('admin.mahasiswa.destroy');
});

//  Mahasiswa
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('umum', action: [UmumAdminController::class, 'index'])->name('admin.umum.index');
    Route::get('umum/create', [UmumAdminController::class, 'create'])->name('admin.umum.create');
    Route::post('umum/store', [UmumAdminController::class, 'store'])->name('admin.umum.store'); 
    Route::get('umum/edit/{id}', [UmumAdminController::class, 'edit'])->name('admin.umum.edit'); 
    Route::put('umum/{id}', [UmumAdminController::class, 'update'])->name('admin.umum.update');
    Route::delete('umum/{id}', [UmumAdminController::class, 'destroy'])->name('admin.umum.destroy');
});

//Jurusan
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('jurusan', [JurusanController::class, 'index'])->name('admin.jurusan.index');
    Route::get('jurusan/create', [JurusanController::class, 'create'])->name('admin.jurusan.create');
    Route::post('jurusan/store', [JurusanController::class, 'store'])->name('admin.jurusan.store'); 
    Route::get('jurusan/edit/{id}', [JurusanController::class, 'edit'])->name('admin.jurusan.edit'); 
    Route::put('jurusan/{id}', [JurusanController::class, 'update'])->name('admin.jurusan.update');
    Route::delete('jurusan/{id}', [JurusanController::class, 'destroy'])->name('admin.jurusan.destroy');
});

//Prodi
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('prodi', [ProdiController::class, 'index'])->name('admin.prodi.index');
    Route::get('prodi/create', [ProdiController::class, 'create'])->name('admin.prodi.create');
    Route::post('prodi/store', [ProdiController::class, 'store'])->name('admin.prodi.store'); 
    Route::get('prodi/edit/{id}', [ProdiController::class, 'edit'])->name('admin.prodi.edit'); 
    Route::put('prodi/{id}', [ProdiController::class, 'update'])->name('admin.prodi.update');
    Route::delete('prodi/{id}', [ProdiController::class, 'destroy'])->name('admin.prodi.destroy');
});

//Kelas
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('kelas', [KelasController::class, 'index'])->name('admin.kelas.index');
    Route::get('kelas/create', [KelasController::class, 'create'])->name('admin.kelas.create');
    Route::post('kelas/store', [KelasController::class, 'store'])->name('admin.kelas.store'); 
    Route::get('kelas/edit/{id}', [KelasController::class, 'edit'])->name('admin.kelas.edit'); 
    Route::put('kelas/{id}', [KelasController::class, 'update'])->name('admin.kelas.update');
    Route::delete('kelas/{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');
});

//Data
// Route untuk lsp 
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('lsp', [LspController::class, 'index'])->name('admin.lsp.index');
    Route::get('lsp/create', [LspController::class, 'create'])->name('admin.lsp.create'); 
    Route::post('lsp/store', [LspController::class, 'store'])->name('admin.lsp.store'); 
    Route::get('lsp/edit/{id}', [LspController::class, 'edit'])->name('admin.lsp.edit'); 
    Route::put('lsp/{id}', [LspController::class, 'update'])->name('admin.lsp.update');
    Route::delete('lsp/{id}', [LspController::class, 'destroy'])->name('admin.lsp.destroy'); 
});

// Route untuk kategori
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('kategori', [KategoriPelatihanController::class, 'index'])->name('admin.kategori.index');
    Route::get('kategori/create', [KategoriPelatihanController::class, 'create'])->name('admin.kategori.create');
    Route::post('kategori/store', [KategoriPelatihanController::class, 'store'])->name('admin.kategori.store'); 
    Route::get('kategori/edit/{id}', [KategoriPelatihanController::class, 'edit'])->name('admin.kategori.edit'); 
    Route::put('kategori/{id}', [KategoriPelatihanController::class, 'update'])->name('admin.kategori.update');
    Route::delete('kategori/{id}', [KategoriPelatihanController::class, 'destroy'])->name('admin.kategori.destroy');
});

// Route untuk pelatihan (hanya untuk admin)
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('pelatihan', [PelatihanController::class, 'index'])->name('admin.pelatihan.index');
    Route::get('pelatihan/create', [PelatihanController::class, 'create'])->name('admin.pelatihan.create'); 
    Route::post('pelatihan/store', [PelatihanController::class, 'store'])->name('admin.pelatihan.store'); 
    Route::get('pelatihan/edit/{id}', [PelatihanController::class, 'edit'])->name('admin.pelatihan.edit'); 
    Route::put('pelatihan/{id}', [PelatihanController::class, 'update'])->name('admin.pelatihan.update');
    Route::delete('pelatihan/{id}', [PelatihanController::class, 'destroy'])->name('admin.pelatihan.destroy'); 
    Route::get('detail/{id}', [PelatihanController::class, 'destroy'])->name('admin.pelatihan.detail'); 
});