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
            $data = Jurusan::query();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.jurusan.edit', $row->id);
                    $deleteUrl = route('admin.jurusan.destroy', $row->id);

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
                'nama_jurusan.required' => 'Nama Jurusan harus diisi.',
                'nama_jurusan.max'      => 'Nama Jurusan Maksimal 125 Karakter.',
                'nama_jurusan.min'      => 'Nama Jurusan Minimal 2 Karakter.'
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
        $request->validate(
            [
                'nama_jurusan' => 'required|string|max:125|min:2'
            ],
            [
                'nama_jurusan.required' => 'Nama Jurusan harus diisi.',
                'nama_jurusan.max'      => 'Nama Jurusan Maksimal 125 Karakter.',
                'nama_jurusan.min'      => 'Nama Jurusan Minimal 2 Karakter.'
            ]
        );

        $jurusan = Jurusan::findOrfail($id);

        $jurusan->update([
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->route('admin.jurusan.edit', $id)->with('edit_success', true);
    }

    public function destroy($id) {
        $jurusan = Jurusan::findOrfail($id);
        $jurusan->delete();

        return response()->json(['success' => true, 'message' => 'Jurusan berhasil dihapus.']);
    }
}
