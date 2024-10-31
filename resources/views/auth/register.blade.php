<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="User/css/style2.css"> <!-- Link to the CSS file -->
</head>
<body>
    <!-- Back Button -->
    <a href="javascript:history.back()" class="back-button"><i class="fas fa-arrow-left"></i> Back</a>

    <div class="container-fluid">
        <div class="row vh-100">
            <div class="col-md-7 left-panel" style="background: url('{{ asset('User/img/DSC_5537-1320x600.jpg') }}') no-repeat center center; background-size: cover;"></div>

            <div class="col-md-5 right-panel d-flex flex-column justify-content-center align-items-center bg-light">
                <img src="https://tikom.polindra.ac.id/wp-content/uploads/2024/06/group_1_3x.webp" alt="Logo" class="logo img-fluid mb-4" style="max-width: 80%;">

                <h2 class="mb-4">Register</h2>

                <!-- Step 1: Role Selection -->
                <div id="role-selection" class="mb-4">
                    <h3>Select Your Role</h3>
                    <button class="btn btn-primary mr-2" onclick="selectRole('mahasiswa')">Mahasiswa</button>
                    <button class="btn btn-primary mr-2" onclick="selectRole('dosen')">Dosen</button>
                    <button class="btn btn-primary" onclick="selectRole('masyarakat')">Masyarakat Umum</button>
                </div>

                <!-- Step 2: Registration Form -->
                <div id="registration-form" style="display:none; width: 100%;">
                    <form action="{{ route('register.masyarakat') }}" method="POST">
                        @csrf <!-- Token CSRF -->

                        <!-- Display errors if there are any -->
                        @if ($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div id="dynamic-fields" class="mb-3"></div>

                        <button type="submit" class="btn btn-success btn-block">REGISTER</button>
                    </form>

                    <!-- Display success message -->
                    @if(session('success'))
                        <div class="alert alert-success mt-3">{{ session('success') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to select role and show registration form
        function selectRole(role) {
            const registrationForm = document.getElementById("registration-form");
            const roleSelection = document.getElementById("role-selection");
            const dynamicFields = document.getElementById("dynamic-fields");

            // Hide the role selection
            roleSelection.style.display = 'none';
            // Show the registration form
            registrationForm.style.display = 'block';

            // Clear any previous fields
            dynamicFields.innerHTML = '';

            // Add dynamic fields based on the selected role
            if (role === 'mahasiswa') {
                dynamicFields.innerHTML += `
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM" required>
                    </div>
                    <div class="form-group">
                        <label for="prodi">Prodi</label>
                        <input type="text" class="form-control" id="prodi" name="prodi" placeholder="Masukkan Prodi" required>
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <input type="text" class="form-control" id="kelas" name="kelas" placeholder="Masukkan Kelas" required>
                    </div>
                `;
            } else if (role === 'dosen') {
                dynamicFields.innerHTML += `
                    <div class="form-group">
                        <label for="nidn">NIDN</label>
                        <input type="text" class="form-control" id="nidn" name="nidn" placeholder="Masukkan NIDN" required>
                    </div>
                    <div class="form-group">
                        <label for="prodi">Prodi</label>
                        <input type="text" class="form-control" id="prodi" name="prodi" placeholder="Masukkan Prodi" required>
                    </div>
                `;
            } else if (role === 'masyarakat') {
                dynamicFields.innerHTML += `
                                        <div class="form-group">
                            <input type="text" class="form-control" name="Nama" placeholder="Nama" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email address" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="notelpon" placeholder="No Telepon" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="nik" placeholder="NIK" required>
                        </div>
                        <div class="form-group">
                        <label for="jenisklamin">Jenis Kelamin</label>
                        <select class="form-control" id="jenisklamin" name="jenisklamin" required>
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password" required>
                        </div>
                `;
            }
        }
    </script>
</body>
</html>
