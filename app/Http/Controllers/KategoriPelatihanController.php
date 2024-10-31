<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriPelatihan;
use Yajra\DataTables\Facades\DataTables;

class KategoriPelatihanController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = KategoriPelatihan::all();
            return DataTables::of($data)
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.data.kategoripelatihan.index');
    }

    public function create()
    {
        return view('admin.data.kategoripelatihan.create');
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|string|max:125|min:2',
            ],
            [
                'nama.required' => 'Nama Harus Diisi.',
                'nama.min' => 'Nama minimal 2 karakter.',
                'nama.max' => 'Nama Maksimal 125 karakter.'
            ]
        );

        KategoriPelatihan::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kategori.index')->with('tambah_success', true);
    }
    
    public function edit($id)
    {
        $kategori = KategoriPelatihan::findOrFail($id);
        return view('admin.data.kategoripelatihan.edit', compact('kategori'));
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kategori = KategoriPelatihan::findOrFail($id);

        $kategori->update([
            'nama' => $request->nama,
        ]);

        return redirect()->back()->with('edit_success', true);
    }

    public function destroy($id)
    {
        $kategori = KategoriPelatihan::findOrFail($id);
        try {
            $kategori->delete();
            return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus kategori'], 500);
        }
    }
}
