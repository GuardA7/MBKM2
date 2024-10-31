<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JurusanController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Jurusan::all();
            return DataTables::of($data)
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.akademik.jurusan.index');
    }

    public function create()
    {
        return view('admin.akademik.jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_jurusan' => 'required|string|max:125|min:2',
            ],
            [
                'nama_jurusan.required' => 'Nama Harus Diisi.',
                'nama_jurusan.min' => 'Nama minimal 2 karakter.',
                'nama_jurusan.max' => 'Nama Maksimal 125 karakter.'
            ]
        );

        Jurusan::create([
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->route('admin.jurusan.index')->with('tambah_success', true);
    }

    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('admin.akademik.jurusan.edit', compact('jurusan')); 
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
        ]);

        $jurusan = Jurusan::findOrFail($id);

        $jurusan->update([
            'nama_jurusan' => $request->nama_jurusan, 
        ]);

        return redirect()->route('admin.jurusan.index')->with('edit_success', true);
    }


    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        try {
            $jurusan->delete();
            return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus kategori'], 500);
        }
    }
}
