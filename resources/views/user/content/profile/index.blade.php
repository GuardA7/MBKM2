@extends('user.layouts.app')

@section('title', 'Halaman Profile Dosen')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Profile User</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item">Profile</li>
            </ol>

            
            <!-- Alert Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Edit Berhasil!</strong> Profil telah berhasil diedit.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Profile Section -->
            <div class="row">
                <!-- Left Sidebar -->
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <!-- Icon Profile -->
                            <i class="fas fa-user-circle text-secondary mb-3" style="font-size: 120px;"></i>
                            <h5>{{ $user->nama }}</h5>
                            <p class="badge bg-primary text-light">{{ ucfirst($user->role) }}</p>

                            <!-- Edit Profile & Password Buttons -->
                            <div class="d-grid gap-2 mt-3">
                                <button class="btn btn-outline-primary" id="editProfileBtn">
                                    <i class="fas fa-user-edit me-2"></i>Edit Profil
                                </button>
                                <button class="btn btn-outline-danger" id="editPasswordBtn">
                                    <i class="fas fa-lock me-2"></i>Edit Kata Sandi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Details -->
                <div class="col-md-9">
                    <div class="card shadow-sm border-0">
                        <div class="card-header text-black">
                            <h3 class="mb-0">Detail Profil</h3>
                        </div>
                        <div class="card-body">
                            <!-- Form for Viewing Profile Details -->
                            <form id="profileForm" method="POST" action="{{ route('user.updateProfile') }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" id="nama" name="nama" class="form-control" value="{{ $user->nama }}"
                                        disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}"
                                        disabled>
                                </div>

                                @if ($user->role === 'mahasiswa')
                                    <div class="mb-3">
                                        <label for="nim" class="form-label">NIM</label>
                                        <input type="text" id="nim" class="form-control" name="nim"
                                            value="{{ $user->nim }}" disabled readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="prodi_id" class="form-label">Program Studi</label>
                                        <select id="prodi_id" class="form-select" name="prodi" disabled readonly>
                                            <option value="">Pilih Program Studi</option>
                                            @foreach ($prodiList as $prodi)
                                                <option value="{{ $prodi->id }}"
                                                    {{ $user->prodi_id == $prodi->id ? 'selected' : '' }}>
                                                    {{ $prodi->nama_prodi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @elseif ($user->role === 'dosen')
                                    <div class="mb-3">
                                        <label for="nidn" class="form-label">NIDN</label>
                                        <input type="text" id="nidn" name="nidn" class="form-control"
                                            value="{{ $user->nidn }}" disabled readonly>
                                    </div>
                                @elseif ($user->role === 'masyarakat')
                                    <div class="mb-3">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="text" id="nik" name="nik" class="form-control"
                                            value="{{ $user->nik }}" disabled readonly>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="no_hp" class="form-label">No HP</label>
                                    <input type="text" id="no_hp" name="no_hp" class="form-control" value="{{ $user->no_hp }}"
                                        disabled readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <input type="text" id="jenis_kelamin"name="jenis_kelamin" class="form-control"
                                        value="{{ $user->jenis_kelamin }}" disabled readonly>
                                </div>

                                <button type="submit" class="btn btn-primary" id="saveProfileBtn"
                                    style="display: none;">Save Profile</button>
                            </form>

                            <!-- Form for Changing Password -->
                            <form id="passwordForm" method="POST" action="#" style="display: none;">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <div class="input-group">
                                        <input type="password" id="current_password" class="form-control" required>
                                        <button type="button" class="btn btn-outline-secondary" id="toggleCurrentPassword">
                                            <i class="fas fa-eye" id="eyeIconCurrent"></i>
                                        </button>
                                    </div>
                                </div>
                                

                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <div class="input-group">
                                        <input type="password" id="new_password" class="form-control" required>
                                        <button type="button" class="btn btn-outline-secondary" id="toggleNewPassword">
                                            <i class="fas fa-eye" id="eyeIconNew"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                    <div class="input-group">
                                        <input type="password" id="new_password_confirmation" class="form-control"
                                            required>
                                        <button type="button" class="btn btn-outline-secondary"
                                            id="toggleNewPasswordConfirmation">
                                            <i class="fas fa-eye" id="eyeIconNewConfirmation"></i>
                                        </button>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-danger">Simpan Password</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Handle profile edit button
        document.getElementById('editProfileBtn').addEventListener('click', function() {
            const formElements = document.querySelectorAll('#profileForm input, #profileForm select');
            formElements.forEach(input => input.disabled = !input.disabled);
            const saveButton = document.getElementById('saveProfileBtn');
            saveButton.style.display = saveButton.style.display === 'none' ? 'inline-block' : 'none';
        });

        // Handle password edit button
        document.getElementById('editPasswordBtn').addEventListener('click', function() {
            const passwordForm = document.getElementById('passwordForm');
            passwordForm.style.display = passwordForm.style.display === 'none' ? 'block' : 'none';
        });

        // Toggle visibility of new password
        document.getElementById('toggleNewPassword').addEventListener('click', function() {
            const newPasswordField = document.getElementById('new_password');
            const eyeIcon = document.getElementById('eyeIconNew');
            if (newPasswordField.type === 'password') {
                newPasswordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                newPasswordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });

        // Toggle visibility of current password
        document.getElementById('toggleCurrentPassword').addEventListener('click', function() {
            const currentPasswordField = document.getElementById('current_password');
            const eyeIcon = document.getElementById('eyeIconCurrent');
            if (currentPasswordField.type === 'password') {
                currentPasswordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                currentPasswordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });

        // Toggle visibility of new password confirmation
        document.getElementById('toggleNewPasswordConfirmation').addEventListener('click', function() {
            const newPasswordConfirmationField = document.getElementById('new_password_confirmation');
            const eyeIcon = document.getElementById('eyeIconNewConfirmation');
            if (newPasswordConfirmationField.type === 'password') {
                newPasswordConfirmationField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                newPasswordConfirmationField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
@endsection
