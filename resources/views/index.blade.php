<!-- resources/views/index.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Halaman Index</title>
</head>
<body>
    <h2>Selamat datang di Halaman Index</h2>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
