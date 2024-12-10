<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    // Controller untuk data dosen
    public function dosenIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'dosen')
                ->with('jurusan'); // Memuat relasi jurusan dengan memilih kolom tertentu

            return DataTables::of($data)
                ->addColumn('nama_jurusan', function ($row) {
                    return $row->jurusan->nama_jurusan ?? '-';
                })
                ->make(true);
        }

        return view('admin.data.user.dosen');
    }


    // Controller untuk data mahasiswa
    public function mahasiswaIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'mahasiswa')
                ->with(['prodi', 'kelas', 'jurusan']);

            return DataTables::of($data)
                ->addColumn('nama_prodi', function ($row) {
                    return $row->prodi->nama_prodi ?? '-';
                })
                ->addColumn('nama_kelas', function ($row) {
                    return $row->kelas->nama_kelas ?? '-';
                })
                ->addColumn('nama_jurusan', function ($row) {
                    return $row->jurusan->nama_jurusan ?? '-';
                })
                ->make(true);
        }

        return view('admin.data.user.mahasiswa');
    }

    // Controller untuk data umum
    public function umumIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'masyarakat');

            return DataTables::of($data)->make(true);
        }

        return view('admin.data.user.umum');
    }
}
