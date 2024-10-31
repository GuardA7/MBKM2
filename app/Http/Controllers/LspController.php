<?php

namespace App\Http\Controllers;

use App\Models\Lsp;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LspController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Lsp::all();
            return DataTables::of($data)
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.data.lsp.index');
    }

    public function create()
    {
        return view('admin.data.lsp.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ], [
            'nama.required' => 'Nama Harus Diisi.',
            'nama.min' => 'Nama minimal 2 karakter.',
            'nama.max' => 'Nama Maksimal 125 karakter.'
        ]);

        Lsp::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.lsp.index')->with('tambah_success', true);
    }

    public function edit($id)
    {
        $lsp = Lsp::findOrFail($id);
        return view('admin.data.lsp.edit', compact('lsp'));
    }


    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate(
            [
                'nama' => 'required|string|max:255',
            ],
            [
                'nama.required' => 'Nama Harus Diisi.',
                'nama.min' => 'Nama minimal 2 karakter.',
                'nama.max' => 'Nama Maksimal 125 karakter.'
            ]
        );

        // Cari LSP berdasarkan ID dan update
        $lsp = Lsp::findOrFail($id);
        $lsp->nama = $request->input('nama');
        $lsp->save();

        return redirect()->back()->with('edit_success', 'LSP telah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lsp = Lsp::findOrFail($id);
        try {
            $lsp->delete();
            return response()->json(['success' => true, 'message' => 'Lsp berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus Lsp'], 500);
        }
    }
}
