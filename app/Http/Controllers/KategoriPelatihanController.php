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
            $data = KategoriPelatihan::query();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.kategori.edit', $row->id);
                    $deleteUrl = route('admin.kategori.destroy', $row->id);

                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></a>
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">
                            ' . csrf_field() . '
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger button-delete" data-id="' . $row->id . '"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.data.pelatihan.kategori.index');
    }

    public function create()
    {
        return view('admin.data.pelatihan.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|string|max:125|min:2|unique:kategori,nama'
            ],
            [
                'nama.required' => 'Nama kategori harus diisi.',
                'nama.max'      => 'Nama kategori maksimal 125 karakter.',
                'nama.min'      => 'Nama kategori minimal 2 karakter.',
                'nama.unique'   => 'Nama kategori sudah ada.',
            ]
        );

        KategoriPelatihan::create([
            'nama' => $request->nama
        ]);

        return redirect()->route('admin.kategori.index')->with('tambah_success', true);
    }

    public function edit($id)
    {
        $kategori = KategoriPelatihan::findOrFail($id);
        return view('admin.data.pelatihan.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nama' => 'required|string|max:125|min:2'
            ],
            [
                'nama.required' => 'Nama kategori harus diisi.',
                'nama.max'      => 'Nama kategori maksimal 125 karakter.',
                'nama.min'      => 'Nama kategori minimal 2 karakter.',
            ]
        );

        $kategori = KategoriPelatihan::findOrFail($id);

        $kategori->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('admin.kategori.edit', $id)->with('edit_success', true);
    }

    public function destroy($id)
    {
        $kategori = KategoriPelatihan::findOrFail($id);
        $kategori->delete();

        return response()->json(['success' => true, 'message' => 'Lsp berhaisil dihapus.']);
    }
}
