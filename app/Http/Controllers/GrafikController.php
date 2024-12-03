<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;

class GrafikController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role', 'all'); // Default 'all' jika tidak ada role yang dipilih
        $year = $request->query('year', now()->year); // Default tahun saat ini jika tidak ada yang dipilih

        // Siapkan array data kosong untuk setiap role
        $dataMahasiswa = array_fill(1, 12, 0);
        $dataDosen = array_fill(1, 12, 0);
        $dataMasyarakat = array_fill(1, 12, 0);

        // Jika filter "all" dipilih, ambil data untuk masing-masing role
        if ($role === 'all') {
            // Data untuk Mahasiswa
            $mahasiswaCounts = Sertifikat::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', $year)
                ->whereHas('user', function ($query) {
                    $query->where('role', 'mahasiswa');
                })
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray();

            foreach ($mahasiswaCounts as $month => $count) {
                $dataMahasiswa[$month] = $count;
            }

            // Data untuk Dosen
            $dosenCounts = Sertifikat::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', $year)
                ->whereHas('user', function ($query) {
                    $query->where('role', 'dosen');
                })
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray();

            foreach ($dosenCounts as $month => $count) {
                $dataDosen[$month] = $count;
            }

            // Data untuk Masyarakat
            $masyarakatCounts = Sertifikat::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', $year)
                ->whereHas('user', function ($query) {
                    $query->where('role', 'masyarakat');
                })
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray();

            foreach ($masyarakatCounts as $month => $count) {
                $dataMasyarakat[$month] = $count;
            }

            $data = [
                'mahasiswa' => $dataMahasiswa,
                'dosen' => $dataDosen,
                'masyarakat' => $dataMasyarakat,
            ];
        } else {
            // Jika role spesifik dipilih, ambil satu dataset saja
            $sertifikatCounts = Sertifikat::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', $year)
                ->when($role !== 'all', function ($query) use ($role) {
                    $query->whereHas('user', function ($q) use ($role) {
                        $q->where('role', $role);
                    });
                })
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray();

            $dataSingleRole = array_fill(1, 12, 0);
            foreach ($sertifikatCounts as $month => $count) {
                $dataSingleRole[$month] = $count;
            }

            $data = [
                $role => $dataSingleRole
            ];
        }

        $years = range(2020, now()->year); // Range tahun dari 2020 hingga saat ini

        return view('admin.data.grafik.index', [
            'data' => $data,
            'selectedRole' => $role,
            'selectedYear' => $year,
            'years' => $years
        ]);
    }
}
