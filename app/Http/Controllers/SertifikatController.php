<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SertifikatController extends Controller
{
    /**
     * Menampilkan halaman sertifikat.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('sertifikat.index'); // Mengarahkan ke view sertifikat.index
    }

    /**
     * Mengambil data sertifikat untuk DataTables.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login
        $sertifikats = Sertifikat::where('user_id', $user->id)->get(); // Mengambil sertifikat berdasarkan user_id

        return DataTables::of($sertifikats)
            ->addColumn('action', function ($sertifikat) {
                // Menambahkan kolom aksi untuk melihat sertifikat
                return '<a href="'.Storage::url($sertifikat->sertifikat_file).'" target="_blank" class="btn btn-primary">Lihat Sertifikat</a>';
            })
            ->make(true); // Mengembalikan response dalam format JSON
    }

    // Menampilkan form upload sertifikat
    public function create()
    {
        return view('sertifikat.upload'); // Mengarahkan ke form upload
    }

    // Menyimpan data sertifikat ke database
    public function store(Request $request)
    {
        // Validasi data yang di-upload
        $request->validate([
            'nama_pelatihan' => 'required|string|max:255',
            'tanggal_berlaku' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_berlaku',
            'sertifikat_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Hanya mengizinkan file PDF, JPG, JPEG, dan PNG
        ]);

        // Meng-upload file sertifikat
        $filePath = $request->file('sertifikat_file')->store('sertifikats', 'public');

        // Membuat entri sertifikat baru
        Sertifikat::create([
            'user_id' => Auth::id(), // Mendapatkan ID pengguna yang sedang login
            'nama_pelatihan' => $request->nama_pelatihan,
            'tanggal_berlaku' => $request->tanggal_berlaku,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'sertifikat_file' => $filePath, // Menyimpan path file sertifikat
        ]);

        return redirect()->route('sertifikat.create')->with('success', 'Sertifikat berhasil di-upload!');
    }
}
