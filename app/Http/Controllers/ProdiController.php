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
            $data = Prodi::with('jurusan')->select(['id', 'nama_prodi', 'jurusan_id', 'nama_jurusan']);

            return DataTables::of($data)
                ->addColumn('nama_jurusan', function (Prodi $prodi) {
                    return $prodi->jurusan ? $prodi->jurusan->nama_jurusan : 'Tidak Ada';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.prodi.edit', $row->id);
                    $deleteUrl = route('admin.prodi.destroy', $row->id);

                    return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></a>
                    <form action="' . $deleteUrl . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">
                        ' . csrf_field() . '
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger delete-button" data-id="' . $row->id .'"><i class="fas fa-trash"></i></button>
                    </form>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.akademik.prodi.index');
    }

    public function create()
    {
        $jurusan = Jurusan::all();
        return view('admin.akademik.prodi.create', compact('jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_prodi' => 'required|string|max:125|min:2|unique:prodis,nama_prodi',
                'jurusan_id' => 'required|exists:jurusans,id'
            ],
            [
                'nama_prodi.required'   => 'Nama Prodi harus diisi.',
                'nama_prodi.unique'     => 'Nama Prodi sudah terdaftar.',
                'nama_prodi.max'        => 'Nama Prodi maksimal 125 karatker.',
                'nama_prodi.min'        => 'Nama Prodi minimal 2 karakter.',
                'jurusan_id.required'   => 'Jurusan harus diisi.',
                'jurusan_id.exists'     => 'Jurusan tidak valid.'
            ]
        );

        $jurusan = Jurusan::findOrFail($request->jurusan_id);

        Prodi::create([
            'nama_prodi'    => $request->nama_prodi,
            'jurusan_id'    => $request->jurusan_id,
            'nama_jurusan'  => $request->nama_jurusan
        ]);

        return redirect()->route('admin.prodi.index')->with('tambah_success', true);
    }

    public function edit($id){
        $prodi = Prodi::findOrfail($id);
        $jurusans = Jurusan::all();
        return view('admin.akademik.prodi.edit', compact('prodi', 'jurusans'));
    }

    public function update(Request $request, $id){
        $request->validate(
            [
                'nama_prodi' => 'required|string|max:125|min:2',
                'jurusan_id' => 'required|exists:jurusans,id'
            ],
            [
                'nama_prodi.required'   => 'Nama Prodi harus diisi.',
                'jurusan_id.required'   => 'Jurusan harus diisi.',
                'nama_prodi.max'        => 'Nama Prodi maksimal 125 karatker.',
                'nama_prodi.min'        => 'Nama Prodi minimal 2 karakter.',
                'jurusan_id.exists'     => 'Jurusan tidak valid.'
            ]
        );

        $jurusan = Jurusan::findOrFail($request->jurusan_id);

        $prodi = Prodi::findOrFail($id);

        $prodi->update([
            'nama_prodi' => $request->nama_prodi,
            'jurusan_id' => $request->jurusan_id
        ]);

        return redirect()->route('admin.prodi.edit', $id)->with('edit_success', true);
    }

    public function destroy($id){
        $prodi = Prodi::findOrfail($id);
        $prodi->delete();

        return response()->json(['success' => true, 'message' => 'Prodi berhasil dihapus.']);
    }

}
