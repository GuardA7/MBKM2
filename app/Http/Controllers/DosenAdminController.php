<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class DosenAdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('jurusan')->where('role', 'dosen')->select('*');
            return DataTables::of($data)
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('admin.user.dosen.index');
    }

    public function create()
    {
        return view('admin.user.dosen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'profile' => 'nullable|image|mimes:jpg,png|max:2048',
            'nama' => 'required|string|max:255',
            'nidn' => 'required|string|max:20|unique:users',
            'jenis_kelamin' => 'required|string',
            'jurusan_id' => 'required|exists:jurusans,id',
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

        return redirect()->route('admin.dosen.index')->with('tambah_success', 'Dosen berhasil ditambahkan.');
    }

    public function edit(User $dosen)
    {
        return view('admin.user.dosen.edit', compact('dosen'));
    }

    public function update(Request $request, User $dosen)
    {
        $request->validate([
            'profile' => 'nullable|image|mimes:jpg,png|max:2048',
            'nama' => 'required|string|max:255',
            'nidn' => 'required|string|max:20|unique:users,nidn,' . $dosen->id,
            'jenis_kelamin' => 'required|string',
            'jurusan_id' => 'required|exists:jurusans,id',
            'no_hp' => 'nullable|string|max:15',
        ]);

        $data = $request->all();

        if ($request->hasFile('profile')) {
            // Delete old file if it exists
            if ($dosen->profile && file_exists(public_path('img/user/dosen/' . $dosen->profile))) {
                unlink(public_path('img/user/dosen/' . $dosen->profile));
            }
            $profile = $request->file('profile');
            $profileNama = time() . '.' . $profile->getClientOriginalExtension();
            $profile->move(public_path('img/user/dosen'), $profileNama);
            $data['profile'] = $profileNama; // Ensure we set the correct field name
        }

        $dosen->update($data);

        return redirect()->route('admin.dosen.index')->with('update_success', 'Dosen berhasil diperbarui.');
    }

    public function destroy(User $dosen)
    {
        if ($dosen->profile && file_exists(public_path('img/user/dosen/' . $dosen->profile))) {
            unlink(public_path('img/user/dosen/' . $dosen->profile));
        }

        $dosen->delete();

        return response()->json(['success' => true, 'message' => 'Dosen berhasil dihapus.']);
    }
}
