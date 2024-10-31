<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProdiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Prodi::with('jurusan:id,nama_jurusan')->get();

            return DataTables::of($data)
                ->addColumn('jurusan_nama', function (Prodi $prodi) {
                    return $prodi->jurusan ? $prodi->jurusan->nama_jurusan : 'Tidak Ada';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.akademik.prodi.index');
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        return view('admin.akademik.prodi.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255|unique:prodis,nama_prodi',
            'jurusan_id' => 'required|exists:jurusans,id',
        ], [
            'nama_prodi.required' => 'Nama Prodi harus diisi.',
            'nama_prodi.unique' => 'Nama Prodi sudah terdaftar.',
            'jurusan_id.required' => 'Jurusan harus diisi.',
            'jurusan_id.exists' => 'Jurusan tidak valid.'
        ]);

        $jurusan = Jurusan::findOrFail($request->jurusan_id);

        Prodi::create([
            'nama_prodi' => $request->nama_prodi,
            'jurusan_id' => $request->jurusan_id,
            'nama_jurusan' => $jurusan->nama_jurusan,
        ]);

        return redirect()->route('admin.prodi.index')->with('tambah_success', true);
    }

    public function edit($id)
    {
        $prodi = Prodi::findOrFail($id);
        $jurusans = Jurusan::all();
        return view('admin.akademik.prodi.edit', compact('prodi', 'jurusans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255|unique:prodis,nama_prodi,' . $id,
            'jurusan_id' => 'required|exists:jurusans,id',
        ], [
            'nama_prodi.required' => 'Nama Prodi harus diisi.',
            'nama_prodi.unique' => 'Nama Prodi sudah terdaftar.',
            'jurusan_id.required' => 'Jurusan harus diisi.',
            'jurusan_id.exists' => 'Jurusan tidak valid.'
        ]);

        $prodi = Prodi::findOrFail($id);
        $prodi->nama_prodi = $request->input('nama_prodi');
        $prodi->jurusan_id = $request->input('jurusan_id');

        $jurusan = Jurusan::findOrFail($request->jurusan_id);
        $prodi->nama_jurusan = $jurusan->nama_jurusan;

        $prodi->save();

        return redirect()->back()->with('edit_success', 'Prodi telah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $prodi = Prodi::findOrFail($id);
        try {
            $prodi->delete();
            return response()->json(['success' => true, 'message' => 'Prodi berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus Prodi'], 500);
        }
    }
}
