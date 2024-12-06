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
use App\Http\Controllers\SertifikatAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\ChartController;

Route::get('/chart', [ChartController::class, 'index'])->name('grafik.presentase');





route::get('/', function () {
    return view('welcome');
});
// Route untuk menampilkan halaman login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// route unutk register
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register/mahasiswa', [RegisterController::class, 'registerMahasiswa'])->name('register.mahasiswa');
Route::post('/register/dosen', [RegisterController::class, 'registerDosen'])->name('register.dosen');

// Route untuk menangani proses login
Route::post('/login', [AuthController::class, 'login']);

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

//Register


//singkronisasi
Route::get('/sync-data', [SyncController::class, 'syncData'])->name('sync.data');
Route::get('/sync-data-User', [SyncController::class, 'syncDataUser'])->name('sync.data.User');


// Route untuk halaman index (untuk selain admin)
Route::get('/index', [AuthController::class, 'index'])->middleware('auth')->name('index');

// Route untuk logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

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

//Pelatihan
Route::get('/user/pelatihan', [PelatihanController::class, 'index_user'])->name('user.pelatihan.index');
Route::get('/user/pelatihan/deskripsi/{id}', [PelatihanController::class, 'deskripsi'])->name('user.pelatihan.deskripsi');
Route::get('/pelatihan/{id}/daftar', [PelatihanController::class, 'showDaftarForm'])->name('user.pelatihan.daftar');
Route::post('/pelatihan/{id}/daftar', [PelatihanController::class, 'submitDaftar'])->name('user.pelatihan.daftar.submit');
Route::get('/user/pelatihan/{id}/detail', [PelatihanController::class, 'detail_pelatihan'])->name('user.pelatihan.detail');

//Testing
// User routes
Route::middleware(['auth'])->group(function () {
    Route::get('/pelatihan-saya', [PelatihanController::class, 'pelatihanSaya'])->name('pelatihan.saya');
});

// Admin

// Route untuk dashboard admin (hanya diakses oleh admin)
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});
;

// Akademik

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

//Prodi
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('kelas', [KelasController::class, 'index'])->name('admin.kelas.index');
    Route::get('kelas/create', [KelasController::class, 'create'])->name('admin.kelas.create');
    Route::post('kelas/store', [KelasController::class, 'store'])->name('admin.kelas.store');
    Route::get('kelas/edit/{id}', [KelasController::class, 'edit'])->name('admin.kelas.edit');
    Route::put('kelas/{id}', [KelasController::class, 'update'])->name('admin.kelas.update');
    Route::delete('kelas/{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');
});


//Data

//Grafik
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('grafik', [GrafikController::class, 'index'])->name('admin.grafik.index');
});

//Lsp
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('lsp', [LspController::class, 'index'])->name('admin.lsp.index');
    Route::get('lsp/create', [LspController::class, 'create'])->name('admin.lsp.create');
    Route::post('lsp/store', [LspController::class, 'store'])->name('admin.lsp.store');
    Route::get('lsp/edit/{id}', [LspController::class, 'edit'])->name('admin.lsp.edit');
    Route::put('lsp/{id}', [LspController::class, 'update'])->name('admin.lsp.update');
    Route::delete('lsp/{id}', [LspController::class, 'destroy'])->name('admin.lsp.destroy');
});

//Pelatihan
//kategori pelatihan
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('kategori', [KategoriPelatihanController::class, 'index'])->name('admin.kategori.index');
    Route::get('kategori/create', [KategoriPelatihanController::class, 'create'])->name('admin.kategori.create');
    Route::post('kategori/store', [KategoriPelatihanController::class, 'store'])->name('admin.kategori.store');
    Route::get('kategori/edit/{id}', [KategoriPelatihanController::class, 'edit'])->name('admin.kategori.edit');
    Route::put('kategori/{id}', [KategoriPelatihanController::class, 'update'])->name('admin.kategori.update');
    Route::delete('kategori/{id}', [KategoriPelatihanController::class, 'destroy'])->name('admin.kategori.destroy');
});

//Pelatihan
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('pelatihan', [PelatihanController::class, 'index'])->name('admin.pelatihan.index');
    Route::get('pelatihan/detail/{id}', [PelatihanController::class, 'detail'])->name('admin.pelatihan.detail');
    Route::get('pelatihan/create', [PelatihanController::class, 'create'])->name('admin.pelatihan.create');
    Route::post('pelatihan/store', [PelatihanController::class, 'store'])->name('admin.pelatihan.store');
    Route::get('pelatihan/edit/{id}', [PelatihanController::class, 'edit'])->name('admin.pelatihan.edit');
    Route::put('pelatihan/{id}', [PelatihanController::class, 'update'])->name('admin.pelatihan.update');
    Route::delete('pelatihan/{id}', [PelatihanController::class, 'destroy'])->name('admin.pelatihan.destroy');
    Route::get('pelatihan/{pelatihanId}/participants', [PelatihanController::class, 'getParticipants'])->name('admin.pelatihan.participants');
    Route::post('pelatihan/update-status', [PelatihanController::class, 'updateStatus'])->name('admin.pelatihan.updateStatus');
});

//Sertifikat
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('sertifikat', [SertifikatAdminController::class, 'index'])->name('admin.sertifikat.index');
    Route::get('sertifikat/detail/{userId}', [SertifikatAdminController::class, 'detail'])->name('admin.sertifikat.detail');
    Route::get('sertifikat/create/{userId}', [SertifikatAdminController::class, 'create'])->name('admin.sertifikat.create');
    Route::post('sertifikat/store/{userId}', [SertifikatAdminController::class, 'store'])->name('admin.sertifikat.store');
    Route::get('sertifikat/{userId}/edit/{id}', [SertifikatAdminController::class, 'edit'])->name('admin.sertifikat.edit');
    Route::put('sertifikat/{userId}/update/{id}', [SertifikatAdminController::class, 'update'])->name('admin.sertifikat.update');
    Route::delete('sertifikat/{id}', [SertifikatAdminController::class, 'destroy'])->name('admin.sertifikat.destroy');
});
