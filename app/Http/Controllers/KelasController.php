<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Prodi; // Pastikan ini sesuai dengan relasi Anda
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kelas::with('prodi:id,nama_prodi')->get();

            return DataTables::of($data)
                ->addColumn('aksi', function ($row) {
                    return '
                    <a class="btn btn-primary btn-sm" href="' . route('admin.kelas.edit', $row->id) . '">
                        <i class="fas fa-pen"></i> Edit
                    </a>
                    <form action="' . route('admin.kelas.destroy', $row->id) . '" method="POST" class="d-inline delete-form">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="button" class="btn btn-danger btn-sm delete-button" data-id="' . $row->id . '">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                ';
                })
                ->addColumn('nama_prodi', function ($row) {
                    return $row->prodi ? $row->prodi->nama_prodi : 'Tidak Ada';
                })
                ->rawColumns(['aksi'])
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
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas',
            'prodi_id' => 'required|exists:prodis,id',
        ], [
            'nama_kelas.required' => 'Nama Kelas harus diisi.',
            'nama_kelas.unique' => 'Nama Kelas sudah terdaftar.',
            'prodi_id.required' => 'Prodi harus diisi.',
            'prodi_id.exists' => 'Prodi tidak valid.'
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'prodi_id' => $request->prodi_id,
        ]);

        return redirect()->route('admin.kelas.index')->with('tambah_success', true);
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $prodis = Prodi::all();
        return view('admin.akademik.kelas.edit', compact('kelas', 'prodis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas,' . $id,
            'prodi_id' => 'required|exists:prodis,id',
        ], [
            'nama_kelas.required' => 'Nama Kelas harus diisi.',
            'nama_kelas.unique' => 'Nama Kelas sudah terdaftar.',
            'prodi_id.required' => 'Prodi harus diisi.',
            'prodi_id.exists' => 'Prodi tidak valid.'
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->nama_kelas = $request->input('nama_kelas');
        $kelas->prodi_id = $request->input('prodi_id');

        $kelas->save();

        return redirect()->back()->with('edit_success', 'Kelas telah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        try {
            $kelas->delete();
            return response()->json(['success' => true, 'message' => 'Kelas berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus Kelas'], 500);
        }
    }
}
