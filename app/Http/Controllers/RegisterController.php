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
    public function registerMahasiswa(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'nim' => 'required',
        ]);

        $name = $request->name;
        $email = $request->email;
        $nim = $request->nim;

        // Cek apakah user dengan NIM sudah ada
        if (User::where('nim', $nim)->exists()) {
            return back()->with('error', 'User dengan NIM ' . $nim . ' sudah terdaftar.');
        }

        // Request ke API untuk mendapatkan data mahasiswa
        $response = Http::get('http://127.0.0.1:8000/api/mahasiswa?nim=' . $nim);

        // Cek apakah respons API berhasil
        if ($response->successful()) {
            $data = $response->json();
            $mahasiswa = is_array($data) ? $data[0] : $data;

            // Cek apakah data mahasiswa lengkap
            if (!$mahasiswa || !isset($mahasiswa['nama_mahasiswa'], $mahasiswa['email'], $mahasiswa['kelas']['prodi']['jurusan'])) {
                return back()->with('error', 'Data mahasiswa tidak lengkap di API.');
            }

            $kelas = $mahasiswa['kelas'] ?? null;
            $prodi = $kelas['prodi'] ?? null;
            $jurusan = $prodi['jurusan'] ?? null;
            $no_hp = $mahasiswa['no_hp'] ?? null;
            $jenis_kelamin = $mahasiswa['jenis_kelamin'] ?? null;

            // Cek apakah data kelas, prodi, atau jurusan tidak lengkap
            if (!$kelas || !$prodi || !$jurusan) {
                return back()->with('error', 'Data kelas, prodi, atau jurusan tidak lengkap.');
            }

            $password = '@Poli' . $nim;

            // Sinkronisasi data mahasiswa ke tabel users
            $user = User::create([
                'nama' => $name,
                'email' => $email,
                'nim' => $nim,
                'no_hp' => $no_hp,
                'jenis_kelamin' => $jenis_kelamin,
                'password' => bcrypt($password),
                'role' => 'mahasiswa',
                'kelas_id' => $kelas['id'],
                'prodi_id' => $prodi['id'],
                'jurusan_id' => $jurusan['id'],
            ]);

            // Kirim email setelah user berhasil dibuat
            Mail::to($email)->send(new UserCreatedMail($name, $nim, $password));

            return redirect()->route('login')->with('success', 'Data Mahasiswa berhasil disinkronkan! Anda dapat login sekarang.');
        }

        // Jika NIM tidak ditemukan di API
        return back()->with('error', 'NIM ' . $nim . ' tidak ditemukan di database mahasiswa.');
    }

    public function registerDosen(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'nidn' => 'required',
        ]);

        // Cek apakah user dengan NIDN sudah ada
        if (User::where('nidn', $request->nidn)->exists()) {
            return back()->with('error', 'User dengan NIDN ' . $request->nidn . ' sudah terdaftar.');
        }

        // Request ke API untuk mendapatkan data dosen
        $response = Http::get('http://127.0.0.1:8000/api/dosen?nidn=' . $request->nidn);

        // Periksa jika respons API berhasil
        if ($response->successful()) {
            $data = $response->json();

            // Pastikan data memiliki key yang diperlukan
            if (!isset($data['nama_dosen'], $data['email'], $data['jurusan_id'])) {
                return back()->with('error', 'Data dosen tidak lengkap di API.');
            }

            $no_hp = $data['no_hp'] ?? null; // Ambil no_hp dari data API

            // Sinkronisasi data dosen dari API ke tabel users
            $user = User::create([
                'name' => $data['nama_dosen'], // Data dari API
                'email' => $data['email'], // Data dari API
                'nidn' => $request->nidn,
                'password' => bcrypt($request->nidn . '@'),
                'role' => 'dosen',
                'jurusan_id' => $data['jurusan_id'],
                'no_hp' => $no_hp, // Simpan nomor HP
            ]);

            return redirect()->route('login')->with('success', 'Data Dosen berhasil disinkronkan! Anda dapat login sekarang.');
        }

        // Jika NIDN tidak ditemukan di API
        return back()->with('error', 'NIDN ' . $request->nidn . ' tidak ditemukan di database dosen.');
    }

}
