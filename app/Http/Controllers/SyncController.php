<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Jurusan;
use App\Models\Prodi;
use App\Models\Kelas;

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
}
