<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Import HTTP Client
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreatedMail;

class RegisterController extends Controller
{
    // Proses registrasi Mahasiswa
    public function registerMahasiswa(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nim' => 'required|unique:users,nim',
        ]);

        // Buat user baru
        $password = bcrypt('password123'); // Default password
        $user = User::create([
            'nama' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $password,
            'nim' => $validatedData['nim'],
            'status_registrasi' => 'Belum Terregistrasi',
            'role' => 'mahasiswa',
        ]);

        // Kirim email aktivasi
        Mail::to($user->email)->send(new \App\Mail\RegistrationSuccessMail($user, 'password123'));

        return redirect()->route('login')->with('success', 'Akun Anda berhasil didaftarkan. Cek email Anda untuk detail login.');
    }

    // Proses registrasi Dosen
    public function registerDosen(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nidn' => 'required|unique:users,nidn',
        ]);

        // Buat user baru
        $password = bcrypt('password123'); // Default password
        $user = User::create([
            'nama' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $password,
            'nidn' => $validatedData['nidn'],
            'status_registrasi' => 'Belum Terregistrasi',
            'role' => 'dosen',
        ]);

        // Kirim email aktivasi
        Mail::to($user->email)->send(new \App\Mail\RegistrationSuccessMail($user, 'password123'));

        return redirect()->route('login')->with('success', 'Akun Anda berhasil didaftarkan. Cek email Anda untuk detail login.');
    }

}
