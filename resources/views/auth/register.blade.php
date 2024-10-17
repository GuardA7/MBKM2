<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="User/css/style2.css">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .left-panel {
            width: 70%;
            background: url('{{ asset('User/img/DSC_5537-1320x600.jpg') }}') no-repeat center center;
            background-size: cover;
        }

        .right-panel {
            width: 30%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.9);
            z-index: 1;
        }

        .right-panel h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .right-panel h1 i {
            color: #6ab04c;
            margin-right: 10px;
        }

        .right-panel h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .role-button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #00aaff; /* Button color */
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        .role-button:hover {
            background-color: #0088cc; /* Hover effect for buttons */
        }

        .right-panel form {
            width: 100%;
        }

        .right-panel input[type="email"],
        .right-panel input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            box-sizing: border-box; /* Ensure width includes padding and border */
            border: 1px solid #adadad;
            background-color: #ffffff; /* White background for form fields */
            color: #000000; /* Black text color */
        }

        .right-panel button {
            border: none;
            background-color: #00aaff; /* Button color */
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            padding: 10px; /* Added padding for button */
            margin: 10px 0;
        }

        .right-panel h1, .right-panel h2, .right-panel a {
            color: #000000; /* Black text for headings and links */
        }

        .right-panel a {
            color: #00aaff; /* Link color */
            text-decoration: none;
        }

        /* Style for the back button */
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            background-color: #00aaff;
            color: rgb(0, 0, 0);
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            z-index: 1;
        }

        .back-button i {
            margin-right: 8px;
        }

        .back-button:hover {
            background-color: #0088cc; /* Hover effect for back button */
        }

        /* Adjust the z-index to ensure it's above other content */
        .right-panel,
        .left-panel {
            position: relative;
        }

        .alert {
            background-color: #f8d7da; /* Background color for alerts */
            color: #721c24; /* Text color for alerts */
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #role-selection {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        label {
            font-weight: bold; /* Make labels bold for clarity */
            margin-top: 10px; /* Add margin for spacing */
        }
    </style>
</head>
<body>
    <!-- Back Button -->
    <a href="javascript:history.back()" class="back-button"><i class="fas fa-arrow-left"></i> Back</a>

    <div class="container">
        <div class="left-panel"></div>

        <div class="right-panel">
            <h1><i class="fas fa-dove"></i> Welcome</h1>
            <h2>Register</h2>

            <!-- Step 1: Role Selection -->
            <div id="role-selection">
                <h3>Select Your Role</h3>
                <button class="role-button" onclick="selectRole('mahasiswa')">Mahasiswa</button>
                <button class="role-button" onclick="selectRole('dosen')">Dosen</button>
                <button class="role-button" onclick="selectRole('masyarakat')">Masyarakat Umum</button>
            </div>

            <!-- Step 2: Registration Form -->
            <div id="registration-form" style="display:none;">
                <form action="{{ route('register') }}" method="POST">
                    @csrf <!-- Token CSRF -->
                    <!-- Role-specific inputs will be loaded dynamically -->
                    <div id="dynamic-fields"></div>

                    <input type="email" name="email" placeholder="Email address" required>
                    <button type="submit">REGISTER</button>
                </form>

                <!-- Display errors if there are any -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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
                    <label for="nim">NIM</label>
                    <input type="text" id="nim" name="nim" placeholder="Masukkan NIM" required>
                    <label for="prodi">Prodi</label>
                    <input type="text" id="prodi" name="prodi" placeholder="Masukkan Prodi" required>
                    <label for="kelas">Kelas</label>
                    <input type="text" id="kelas" name="kelas" placeholder="Masukkan Kelas" required>
                `;
            } else if (role === 'dosen') {
                dynamicFields.innerHTML += `
                    <label for="nidn">NIDN</label>
                    <input type="text" id="nidn" name="nidn" placeholder="Masukkan NIDN" required>
                    <label for="prodi">Prodi</label>
                    <input type="text" id="prodi" name="prodi" placeholder="Masukkan Prodi" required>
                `;
            } else if (role === 'masyarakat') {
                dynamicFields.innerHTML += `
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" name="nik" placeholder="Masukkan NIK" required>
                `;
            }
        }
    </script>
</body>
</html>
