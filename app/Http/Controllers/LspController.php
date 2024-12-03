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
            $data = Lsp::query();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.lsp.edit', $row->id);
                    $deleteUrl = route('admin.lsp.destroy', $row->id);

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
        return view('admin.data.lsp.index');
    }

    public function create()
    {
        return view('admin.data.lsp.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|string|max:125|min:2|unique:lsp,nama'
            ],
            [
                'nama.required' => 'Nama lsp harus diisi.',
                'nama.max'      => 'Nama lsp maksimal 125 karakter.',
                'nama.min'      => 'Nama lsp minimal 2 karakter.',
                'nama.unique'   => 'Nama lsp sudah ada.',
            ]
        );

        Lsp::create([
            'nama' => $request->nama
        ]);

        return redirect()->route('admin.lsp.index')->with('tambah_success', true);
    }

    public function edit($id)
    {
        $lsp = Lsp::findOrFail($id);
        return view('admin.data.lsp.edit', compact('lsp'));
    }

    public function update(Request $request, $id){
        $request->validate(
            [
                'nama' => 'required|string|max:125|min:2|unique:lsp,nama'
            ],
            [
                'nama.required' => 'Nama lsp harus diisi.',
                'nama.max'      => 'Nama lsp maksimal 125 karakter.',
                'nama.min'      => 'Nama lsp minimal 2 karakter.',
                'nama.unique'   => 'Nama lsp sudah ada.',
            ]
        );

        $lsp = Lsp::findOrFail($id);

        $lsp->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('admin.lsp.edit', $id)->with('edit_success', true);
    }

    public function destroy($id){
        $lsp = Lsp::findOrFail($id);
        $lsp->delete();

        return response()->json(['success' => true, 'message' => 'Lsp berhaisil dihapus.']);
    }
}
