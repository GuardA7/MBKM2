<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SertifikatController extends Controller
{

    public function index()
    {
        return view('sertifikat.index'); // Create this view file
    }

    public function getData(Request $request)
    {
        $sertifikats = Sertifikat::with('user')->select('sertifikats.*');

        return DataTables::of($sertifikats)
            ->addColumn('action', function ($sertifikat) {
                return '<a href="'. route('sertifikat.download', $sertifikat->id) .'" class="btn btn-primary btn-sm">Download</a>';
            })
            ->make(true);
    }

    public function download($id)
    {
        $sertifikat = Sertifikat::findOrFail($id);
        $filePath = public_path('storage/' . $sertifikat->sertifikat_file);

        // Check if the file exists
        if (!file_exists($filePath)) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        return response()->download($filePath);
    }



        //upload

    public function create()
    {
        return view('sertifikat.upload');
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
}
