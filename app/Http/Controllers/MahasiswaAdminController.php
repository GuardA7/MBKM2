<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MahasiswaAdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with(['prodi:id,nama_prodi', 'kelas:id,nama_kelas'])
                ->where('role', 'mahasiswa')
                ->select('*');

            return DataTables::of($data)
                ->addColumn('prodi.nama_prodi', function ($row) {
                    return $row->prodi ? $row->prodi->nama_prodi : 'N/A';
                })
                ->addColumn('kelas.nama_kelas', function ($row) {
                    return $row->kelas ? $row->kelas->nama_kelas : 'N/A'; // Assuming 'nama_kelas' is the correct attribute
                })
                ->addColumn('aksi', function ($row) {
                    // Example actions, replace with your actual buttons
                    return '
                        <a href="' . route('admin.mahasiswa.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" onclick="deleteMahasiswa(' . $row->id . ')">Delete</button>
                    ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('admin.user.mahasiswa.index');
    }

    public function create()
    {
        return view('admin.user.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'profile' => 'nullable|image|mimes:jpg,png|max:2048',
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:users',
            'jenis_kelamin' => 'required|string',
            'prodi_id' => 'required|exists:prodis,id',
            'kelas_id' => 'required|exists:kelas,id',
            'no_hp' => 'nullable|string|max:15',
        ]);

        $data = $request->all();

        if ($request->hasFile('profile')) {
            $profile = $request->file('profile');
            $profileNama = time() . '.' . $profile->getClientOriginalExtension();
            $profile->move(public_path('img/user/mahasiswa'), $profileNama);
            $data['profile'] = $profileNama; // Corrected the field name
        }

        User::create($data);

        return redirect()->route('admin.mahasiswa.index')->with('tambah_success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function edit(User $mahasiswa)
    {
        return view('admin.user.mahasiswa.edit', compact('mahasiswa')); // Fixed variable name
    }

    public function update(Request $request, User $mahasiswa)
    {
        $request->validate([
            'profile' => 'nullable|image|mimes:jpg,png|max:2048',
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:users,nim,' . $mahasiswa->id,
            'jenis_kelamin' => 'required|string',
            'prodi_id' => 'required|exists:prodis,id',
            'kelas_id' => 'required|exists:kelas,id', // Corrected field name
            'no_hp' => 'nullable|string|max:15',
        ]);

        $data = $request->all();

        if ($request->hasFile('profile')) {
            // Delete old file if it exists
            if ($mahasiswa->profile && file_exists(public_path('img/user/mahasiswa/' . $mahasiswa->profile))) {
                unlink(public_path('img/user/mahasiswa/' . $mahasiswa->profile));
            }
            $profile = $request->file('profile');
            $profileNama = time() . '.' . $profile->getClientOriginalExtension();
            $profile->move(public_path('img/user/mahasiswa'), $profileNama);
            $data['profile'] = $profileNama; // Ensure we set the correct field name
        }

        $mahasiswa->update($data);

        return redirect()->route('admin.mahasiswa.index')->with('update_success', 'Mahasiswa berhasil diperbarui.');
    }

    public function destroy(User $mahasiswa)
    {
        // Optionally handle file deletion if required before deleting the user
        if ($mahasiswa->profile && file_exists(public_path('img/user/mahasiswa/' . $mahasiswa->profile))) {
            unlink(public_path('img/user/mahasiswa/' . $mahasiswa->profile));
        }

        $mahasiswa->delete();

        return response()->json(['success' => true, 'message' => 'Mahasiswa berhasil dihapus.']);
    }
}
