<?php
namespace App\Http\Controllers;

use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SertifikatController extends Controller
{
    public function index()
    {
        return view('user.content.sertifikat.index'); // Pastikan ini ada
    }

    public function getData(Request $request)
    {
        $sertifikats = Sertifikat::where('user_id', Auth::id())->select('sertifikats.*');

        return DataTables::of($sertifikats)
            ->addIndexColumn()
            ->editColumn('id', function($sertifikat) {
                return '1-' . $sertifikat->id;
            })
            ->addColumn('action_download', function ($sertifikat) {
                return '<a href="'. route('sertifikat.download', $sertifikat->id) .'" class="btn btn-primary btn-sm">Download</a>';
            })
            ->addColumn('action_delete', function ($sertifikat) {
                return '<button class="btn btn-danger btn-sm delete" data-id="'.$sertifikat->id.'">Hapus</button>';
            })
            ->rawColumns(['action_download', 'action_delete']) // Pastikan HTML dirender
            ->make(true);
    }

    public function download($id)
    {
        $sertifikat = Sertifikat::findOrFail($id);
        $filePath = public_path('storage/' . $sertifikat->sertifikat_file);

        // Cek apakah file ada
        if (!file_exists($filePath)) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        return response()->download($filePath);
    }

    public function create()
    {
        return view('user.content.sertifikat.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelatihan' => 'required|string|max:255',
            'tanggal_berlaku' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_berlaku',
            'sertifikat_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Simpan file ke penyimpanan publik
        $filePath = $request->file('sertifikat_file')->store('sertifikats', 'public');

        // Buat entri di database
        Sertifikat::create([
            'user_id' => Auth::id(),
            'nama_pelatihan' => $request->nama_pelatihan,
            'tanggal_berlaku' => $request->tanggal_berlaku,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'sertifikat_file' => $filePath,
        ]);

        // Redirect dan kirim notifikasi sukses
        return redirect()->route('sertifikat.create')->with('success', 'Sertifikat berhasil di-upload!');
    }

    public function destroy($id)
    {
        // Temukan sertifikat berdasarkan ID
        $sertifikat = Sertifikat::findOrFail($id);
        $filePath = public_path('storage/' . $sertifikat->sertifikat_file);

        // Hapus file dari penyimpanan jika ada
        if (file_exists($filePath)) {
            Storage::disk('public')->delete($sertifikat->sertifikat_file);
        }

        // Hapus sertifikat dari database
        $sertifikat->delete();

        return response()->json(['message' => 'Sertifikat berhasil dihapus.']);
    }

    public function chart(Request $request)
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

        return view('user.content.grafik.grafik', [
            'data' => $data,
            'selectedRole' => $role,
            'selectedYear' => $year,
            'years' => $years
        ]);
    }


    public function PresentaseMahasiswa(){
        return view('user.content.grafik.presentase');
    }


}
