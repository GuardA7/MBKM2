@extends('user.layouts.app')

@section('title', 'Halaman Profile Mahasiswa')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Profil Mahasiswa</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Edit Berhasil!</strong> Profil telah berhasil diedit.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <i class="fas fa-user-circle text-secondary mb-3" style="font-size: 120px;"></i>
                            <h5>{{ $user->nama }}</h5>
                            <p class="badge bg-primary text-light">{{ ucfirst($user->role) }}</p>
                            <div class="d-grid gap-2 mt-3">
                                <a href="{{ route('profile.mahasiswa', ['action' => 'detail']) }}"
                                    class="btn btn-outline-primary @if ($action == 'detail') active @endif">
                                    <i class="fas fa-eye me-2"></i>Detail Profil
                                </a>
                                <a href="{{ route('profile.mahasiswa', ['action' => 'edit-profile']) }}"
                                    class="btn btn-outline-primary {{ request()->get('action') == 'edit-profile' ? 'active' : '' }}">
                                    <i class="fas fa-user-edit me-2"></i>Edit Profil
                                </a>
                                <a href="{{ route('profile.mahasiswa', ['action' => 'edit-password']) }}"
                                    class="btn btn-outline-primary {{ request()->get('action') == 'edit-password' ? 'active' : '' }}">
                                    <i class="fas fa-lock me-2"></i>Edit Kata Sandi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    @if (request()->get('action') == 'edit-profile')
                        <div class="card shadow-sm border-0">
                            <div class="card-header text-black">
                                <h3 class="mb-0">Edit Profil</h3>
                            </div>
                            <div class="card-body">
                                <form id="profileForm" method="POST" action="{{ route('user.updateProfile') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" id="nama" name="nama" class="form-control"
                                            value="{{ old('nama', $user->nama) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            value="{{ old('email', $user->email) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_hp" class="form-label">No HP</label>
                                        <input type="text" id="no_hp" name="no_hp" class="form-control"
                                            value="{{ old('no_hp', $user->no_hp) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nim" class="form-label">NIM</label>
                                        <input type="text" id="nim" class="form-control"
                                            value="{{ $user->nim }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="prodi" class="form-label">Program Studi</label>
                                        <input type="text" id="prodi" class="form-control"
                                            value="{{ $user->prodi?->nama_prodi ?? 'Belum ditentukan' }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jurusan" class="form-label">Jurusan</label>
                                        <input type="text" id="jurusan" class="form-control"
                                            value="{{ $user->prodi?->jurusan?->nama_jurusan ?? 'Belum ditentukan' }}"
                                            disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kelas" class="form-label">Kelas</label>
                                        <input type="text" id="kelas" class="form-control"
                                            value="{{ $user->kelas?->nama_kelas ?? 'Belum ditentukan' }}" disabled>
                                    </div>
                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary">Simpan Profil</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @elseif(request()->get('action') == 'edit-password')
                        <div class="card shadow-sm border-0">
                            <div class="card-header text-black">
                                <h3 class="mb-0">Ubah Kata Sandi</h3>
                            </div>
                            <div class="card-body">
                                <form id="passwordForm" method="POST" action="{{ route('user.updatePassword') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Kata Sandi Saat Ini</label>
                                        <input type="password" id="current_password" name="current_password"
                                            class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Kata Sandi Baru</label>
                                        <input type="password" id="new_password" name="new_password"
                                            class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password_confirmation" class="form-label">Konfirmasi Kata Sandi
                                            Baru</label>
                                        <input type="password" id="new_password_confirmation"
                                            name="new_password_confirmation" class="form-control" required>
                                    </div>
                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-primary">Ubah Kata Sandi</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @elseif(request()->get('action') == 'detail')
                        <div class="card shadow-sm border-0">
                            <div class="card-header text-black">
                                <h3 class="mb-0">Detail Profil</h3>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" id="nama" class="form-control"
                                            value="{{ $user->nama }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" class="form-control"
                                            value="{{ $user->email }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_hp" class="form-label">No HP</label>
                                        <input type="text" id="no_hp" class="form-control"
                                            value="{{ $user->no_hp }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nim" class="form-label">NIM</label>
                                        <input type="text" id="nim" class="form-control"
                                            value="{{ $user->nim }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="prodi" class="form-label">Program Studi</label>
                                        <input type="text" id="prodi" class="form-control"
                                            value="{{ $user->prodi?->nama_prodi ?? 'Belum ditentukan' }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jurusan" class="form-label">Jurusan</label>
                                        <input type="text" id="jurusan" class="form-control"
                                            value="{{ $user->prodi?->jurusan?->nama_jurusan ?? 'Belum ditentukan' }}"
                                            disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kelas" class="form-label">Kelas</label>
                                        <input type="text" id="kelas" class="form-control"
                                            value="{{ $user->kelas?->nama_kelas ?? 'Belum ditentukan' }}" disabled>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
