<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Anda Berhasil Dibuat</title>
</head>
<body>
    <h1>Halo, {{ $name }}</h1>
    <p>Akun Anda telah berhasil dibuat dengan detail berikut:</p>
    <ul>
        <li><strong>Username (NIM):</strong> {{ $nim }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>
    <p>Silakan login dan ganti password Anda segera setelah login.</p>
    <p>Terima kasih!</p>
</body>
</html>
