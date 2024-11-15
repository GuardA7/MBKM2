<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="User/css/style2.css">
</head>
<body>
    <!-- Back Button -->
    <a href="javascript:history.back()" class="back-button"><i class="fas fa-arrow-left"></i> Back</a>

    <div class="container">
        <div class="left-panel" style="background: url('{{ asset('User/img/DSC_5537-1320x600.jpg') }}') no-repeat center center; background-size: cover;"></div>

        <div class="right-panel">
            <div class="form-container">
                <img src="https://tikom.polindra.ac.id/wp-content/uploads/2024/06/group_1_3x.webp" alt="Logo" class="logo img-fluid mb-4">
                <h2>Log in</h2>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <input type="email" name="email" placeholder="Email address" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">LOGIN</button>
                </form>

                <!-- Error display -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <a href="#">Forgot password?</a>
                <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
