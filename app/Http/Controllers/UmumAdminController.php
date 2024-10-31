<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class UmumAdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('jurusan')->where('role', 'masyarakat')->select('*');
            return DataTables::of($data)
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('admin.user.umum.index');
    }

    public function create()
    {
        return view('admin.user.umum.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'profile' => 'nullable|image|mimes:jpg,png|max:2048',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:20|unique:users',
            'jenis_kelamin' => 'required|string',
            'no_hp' => 'nullable|string|max:15',
        ]);

        $data = $request->all();

        if ($request->hasFile('profile')) {
            $profile = $request->file('profile');
            $profileNama = time() . '.' . $profile->getClientOriginalExtension();
            $profile->move(public_path('img/user/umum'), $profileNama);
            $data['profile'] = $profileNama; // Corrected the field name
        }

        User::create($data);

        return redirect()->route('admin.umum.index')->with('tambah_success', 'Umum berhasil ditambahkan.');
    }

    public function edit(User $umum)
    {
        return view('admin.user.umum.edit', compact('umum'));
    }

    public function update(Request $request, User $umum)
    {
        $request->validate([
            'profile' => 'nullable|image|mimes:jpg,png|max:2048',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:20|unique:users,nidn,' . $umum->id,
            'jenis_kelamin' => 'required|string',
            'no_hp' => 'nullable|string|max:15',
        ]);

        $data = $request->all();

        if ($request->hasFile('profile')) {
            // Delete old file if it exists
            if ($umum->profile && file_exists(public_path('img/user/umum/' . $umum->profile))) {
                unlink(public_path('img/user/umum/' . $umum->profile));
            }
            $profile = $request->file('profile');
            $profileNama = time() . '.' . $profile->getClientOriginalExtension();
            $profile->move(public_path('img/user/dosen'), $profileNama);
            $data['profile'] = $profileNama; // Ensure we set the correct field name
        }

        $umum->update($data);

        return redirect()->route('admin.umum.index')->with('update_success', 'Umum berhasil diperbarui.');
    }

    public function destroy(User $umum)
    {
        if ($umum->profile && file_exists(public_path('img/user/umum/' . $umum->profile))) {
            unlink(public_path('img/user/umum/' . $umum->profile));
        }

        $umum->delete();

        return response()->json(['success' => true, 'message' => 'Umum berhasil dihapus.']);
    }
}
