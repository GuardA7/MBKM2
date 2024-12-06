<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Jurusan;
use App\Models\Prodi;
use App\Models\Kelas;
use App\Models\User;
class SyncController extends Controller
{
    public function syncData()
    {
        try {
            Log::info("Memulai proses sinkronisasi data...");

            // Ambil data jurusan, prodi, dan kelas dari API
            $response = Http::get('http://127.0.0.1:8000/api/Akademik');
            Log::info("Response Akademik: " . $response->body());

            if ($response->successful()) {
                $jurusanData = $response->json();

                foreach ($jurusanData as $jurusan) {
                    // Sinkronisasi jurusan
                    $jurusanModel = Jurusan::updateOrCreate(
                        ['id' => $jurusan['id']],
                        ['nama_jurusan' => $jurusan['nama_jurusan']]
                    );

                    Log::info("Sinkronisasi jurusan: " . $jurusanModel->nama_jurusan);

                    // Sinkronisasi prodi
                    foreach ($jurusan['prodis'] as $prodi) {
                        $prodiModel = Prodi::updateOrCreate(
                            ['id' => $prodi['id']],
                            [
                                'nama_prodi' => $prodi['nama_prodi'],
                                'jurusan_id' => $jurusanModel->id,
                            ]
                        );

                        Log::info("Sinkronisasi prodi: " . $prodiModel->nama_prodi);

                        // Sinkronisasi kelas
                        foreach ($prodi['kelas'] as $kelas) {
                            $kelasModel = Kelas::updateOrCreate(
                                ['id' => $kelas['id']],
                                [
                                    'nama_kelas' => $kelas['nama_kelas'],
                                    'prodi_id' => $prodiModel->id,
                                ]
                            );

                            Log::info("Sinkronisasi kelas: " . $kelasModel->nama_kelas);
                        }
                    }
                }

                Log::info("Sinkronisasi selesai.");
                return response()->json(['message' => 'Data jurusan, prodi, dan kelas berhasil disinkronkan'], 200);
            } else {
                Log::error("Gagal mendapatkan data dari API.");
                return response()->json(['message' => 'Gagal mendapatkan data dari API'], 500);
            }
        } catch (\Exception $e) {
            Log::error("Error saat sinkronisasi: " . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan saat sinkronisasi'], 500);
        }
    }
    public function syncDataUser()
    {
        try {
            Log::info("Memulai proses sinkronisasi data...");

            // Sinkronisasi data mahasiswa
            $responseMahasiswa = Http::get('http://127.0.0.1:8000/api/mahasiswa');
            Log::info("Response Mahasiswa: " . $responseMahasiswa->body());

            if ($responseMahasiswa->successful()) {
                $mahasiswaData = $responseMahasiswa->json();

                foreach ($mahasiswaData as $mahasiswa) {
                    // Membuat password menggunakan format @Poli.$nim
                    $password = "@Poli." . $mahasiswa['nim'];

                    // Menggunakan model User, bukan Users
                    $user = User::updateOrCreate(
                        ['email' => $mahasiswa['email']],
                        [
                            'nama' => $mahasiswa['nama_mahasiswa'],
                            'email' => $mahasiswa['email'],
                            'password' => bcrypt($password), // Set password sesuai format
                            'role' => 'mahasiswa',
                            'nim' => $mahasiswa['nim'],
                            'no_hp' => $mahasiswa['no_hp'] ?? null,
                            'jenis_kelamin' => $mahasiswa['jenis_kelamin'],
                            'prodi_id' => $mahasiswa['kelas']['prodi']['id'],
                            'kelas_id' => $mahasiswa['kelas']['id'],
                            'jurusan_id' => $mahasiswa['kelas']['prodi']['jurusan']['id'],
                        ]
                    );

                    Log::info("Sinkronisasi mahasiswa: " . $user->name . " dengan password " . $password);
                }
            } else {
                Log::error("Gagal mendapatkan data mahasiswa dari API.");
                return response()->json(['message' => 'Gagal mendapatkan data mahasiswa dari API'], 500);
            }

            // Sinkronisasi data dosen
            $responseDosen = Http::get('http://127.0.0.1:8000/api/dosen');
            Log::info("Response Dosen: " . $responseDosen->body());

            if ($responseDosen->successful()) {
                $dosenData = $responseDosen->json();

                foreach ($dosenData as $dosen) {
                    $password = "@Poli." . ($dosen['nidn'] ?? '1234'); // Gunakan NIDN jika ada

                    // Menggunakan model User, bukan Users
                    $user = User::updateOrCreate(
                        ['email' => $dosen['email']],
                        [
                            'nama' => $dosen['nama_dosen'],
                            'email' => $dosen['email'],
                            'password' => bcrypt($password), // Set password sesuai format
                            'role' => 'dosen',
                            'nidn' => $dosen['nidn'] ?? null,
                            'no_hp' => $dosen['no_hp'] ?? null,
                            'jenis_kelamin' => $dosen['jenis_kelamin'] ?? null,
                            'jurusan_id' => $dosen['jurusan_id'] ?? null,
                        ]
                    );

                    Log::info("Sinkronisasi dosen: " . $user->name . " dengan password " . $password);
                }
            } else {
                Log::error("Gagal mendapatkan data dosen dari API.");
                return response()->json(['message' => 'Gagal mendapatkan data dosen dari API'], 500);
            }

            Log::info("Sinkronisasi selesai.");
            return response()->json(['message' => 'Data berhasil disinkronkan'], 200);

        } catch (\Exception $e) {
            Log::error("Error saat sinkronisasi: " . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan saat sinkronisasi'], 500);
        }
    }

}
