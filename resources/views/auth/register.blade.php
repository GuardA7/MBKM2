<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('User/css/style2.css') }}"> <!-- Link ke style2.css -->
</head>

<body>
    <!-- Back Button -->
    <a href="javascript:history.back()" class="back-button"><i class="fas fa-arrow-left"></i> Back</a>

    <div class="container-fluid">
        <div class="row vh-100">
            <!-- Left Panel -->
            <div class="col-md-7 d-none d-md-block left-panel" style="background: url('{{ asset('User/img/DSC_5537-1320x600.jpg') }}') no-repeat center center; background-size: cover;">
            </div>

            <!-- Right Panel -->
            <div class="col-md-5 d-flex align-items-center justify-content-center right-panel">
                <div class="form-container w-100">
                    <img src="https://tikom.polindra.ac.id/wp-content/uploads/2024/06/group_1_3x.webp" alt="Logo" class="logo img-fluid mb-4">
                    <h2>Register</h2>

                    <!-- Menampilkan notifikasi error jika ada -->
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Choose Registration Type -->
                    <div id="toggle-buttons" class="d-flex flex-column justify-content-center mb-3">
                        <button id="mahasiswa-btn" class="btn-toggle mb-3" onclick="toggleForm('mahasiswa')">Register as Mahasiswa</button>
                        <button id="dosen-btn" class="btn-toggle" onclick="toggleForm('dosen')">Register as Dosen</button>
                    </div>

                    <!-- Mahasiswa Registration Form -->
                    <form id="mahasiswa-form" method="POST" action="{{ route('register.mahasiswa') }}" style="display:none;">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="nim" name="nim" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register as Mahasiswa</button>
                    </form>

                    <!-- Dosen Registration Form -->
                    <form id="dosen-form" method="POST" action="{{ route('register.dosen') }}" style="display:none;">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="nidn" class="form-label">NIDN</label>
                            <input type="text" class="form-control" id="nidn" name="nidn" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register as Dosen</button>
                    </form>

                    <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle between forms for Mahasiswa and Dosen
        function toggleForm(role) {
            // Hide the toggle buttons after one is clicked
            document.getElementById('toggle-buttons').style.display = 'none';

            // Hide the buttons themselves to prevent re-selection
            document.getElementById('mahasiswa-btn').style.display = 'none';
            document.getElementById('dosen-btn').style.display = 'none';

            // Show the respective form based on the selected role
            if (role === 'mahasiswa') {
                document.getElementById('mahasiswa-form').style.display = 'block';
                document.getElementById('dosen-form').style.display = 'none';
            } else if (role === 'dosen') {
                document.getElementById('dosen-form').style.display = 'block';
                document.getElementById('mahasiswa-form').style.display = 'none';
            }
        }
    </script>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>
