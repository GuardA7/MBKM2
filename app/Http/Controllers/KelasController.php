<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kelas::with('prodi')->select(['id', 'nama_kelas', 'prodi_id', 'nama_prodi']);

            return DataTables::of($data)
                ->addColumn('nama_prodi', function ($row) {
                    return $row->prodi ? $row->prodi->nama_prodi : 'Tidak Ada';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.kelas.edit', $row->id);
                    $deleteUrl = route('admin.kelas.destroy', $row->id);

                    return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></a>
                    <form action="' . $deleteUrl . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">
                        ' . csrf_field() . '
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger delete-button" data-id="' . $row->id . '"><i class="fas fa-trash"></i></button>
                    </form>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.akademik.kelas.index');
    }

    public function create()
    {
        $prodis = Prodi::all();
        return view('admin.akademik.kelas.create', compact('prodis'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_kelas'    => 'required|string|max:125|min:2|unique:kelas,nama_kelas',
                'prodi_id'      => 'required|exists:prodis,id',
            ],
            [
                'nama_kelas.unique'     => 'Nama Kelas sudah terdaftar.',
                'nama_kelas.required'   => 'Nama Kelas harus diisi.',
                'nama_kelas.max'        => 'Nama Kelas maksimal 125 karakater.',
                'nama_kelas.min'        => 'Nama Kelas minimal 2 karakter.',
                'prodi_id.required'     => 'Prodi harus diisi.',
                'prodi_id.exists'       => 'Prodi tidak valid.'
            ]
        );

        Kelas::create([
            'nama_kelas'    => $request->nama_kelas,
            'prodi_id'      => $request->prodi_id
        ]);

        return redirect()->route('admin.kelas.index')->with('tambah_success', true);
    }

    public function edit($id){
        $kelas  = Kelas::findOrFail($id);
        $prodis = Prodi::all();
        return view('admin.akademik.kelas.edit', compact('kelas', 'prodis'));
    }

    public function update(Request $request, $id){
        $request->validate(
            [
                'nama_kelas'    => 'required|string|max:125|min:2',
                'prodi_id'      => 'required|exists:prodis,id',
            ],
            [
                'nama_kelas.required'   => 'Nama Kelas harus diisi.',
                'nama_kelas.max'        => 'Nama Kelas maksimal 125 karakater.',
                'nama_kelas.min'        => 'Nama Kelas minimal 2 karakter.',
                'prodi_id.required'     => 'Prodi harus diisi.',
                'prodi_id.exists'       => 'Prodi tidak valid.'
            ]
        );

        $kelas = Kelas::findOrFail($id);

        $kelas->update([
            'nama_kelas'    => $request->nama_kelas,
            'prodi_id'      => $request->prodi_id
        ]);

        return redirect()->route('admin.kelas.edit', $id)->with('edit_success', true);
    }

    public function destroy($id){
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        $kelas->response()->json(['success' => true, 'message' => 'Kelas berhasil dihapus.']);
    }
}
