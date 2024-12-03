<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SertifikatAdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Sertifikat::with('user')
                ->select('user_id')
                ->distinct();

            // Filter by sertifikat_id if provided
            if ($request->has('sertifikat_id')) {
                $query->where('id', $request->sertifikat_id);
            }

            // Filter by role if provided
            if ($request->has('role') && $request->role != '') {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('role', $request->role);
                });
            }

            return DataTables::of($query)
                ->addColumn('user_nama', function ($row) {
                    $user = $row->user;
                    return $user->nama ?? 'N/A';
                })
                ->addColumn('user_role', function ($row) {
                    $user = $row->user;
                    return ucfirst($user->role ?? 'N/A');
                })
                ->addColumn('sertifikat', function ($row) {
                    return '<a class="btn btn-success btn-sm mx-1" href="' . route('admin.sertifikat.detail', ['userId' => $row->user_id]) . '">
                        <i class="fas fa-eye"></i> Detail
                    </a>';
                })
                ->rawColumns(['sertifikat'])
                ->make(true);
        }

        return view('admin.data.sertifikat.index');
    }

    public function detail($userId, Request $request)
    {
        $user = User::findOrFail($userId);

        if ($request->ajax()) {

            $sertifikat = Sertifikat::where('user_id', $userId)->get();

            return DataTables::of($sertifikat)
                ->addColumn('action', function ($row) use ($userId) {
                    $editUrl = route('admin.sertifikat.edit', ['userId' => $userId, 'id' => $row->id]);
                    $deleteUrl = route('admin.sertifikat.destroy', ['userId' => $userId, 'id' => $row->id]);

                    return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary"  data-id="' . $row->id . '"><i class="fas fa-pen"></i></a>
                    <form action="' . $deleteUrl . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">
                        ' . csrf_field() . '
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger delete-button" data-id="' . $row->id . '"><i class="fas fa-trash"></i></button>
                    </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Only pass user data to the initial view load
        return view('admin.data.sertifikat.detail', compact('user', 'userId'));
    }


    public function create($userId)
    {
        $user = User::findOrFail($userId);
        $roles = ['dosen', 'mahasiswa', 'masyarakat'];
        return view('admin.data.sertifikat.create', compact('user', 'roles'));
    }

    public function store(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $request->validate([
            'nama_pelatihan'    => 'required|string|max:255',
            'tanggal_berlaku'   => 'required|date',
            'tanggal_berakhir'  => 'required|date|after_or_equal:tanggal_berlaku',
            'sertifikat_file'   => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $sertifikat = $request->except('sertifikat_file');
        $sertifikat['user_id'] = $userId;

        // Cek apakah ada file sertifikat yang di-upload
        if ($request->hasFile('sertifikat_file')) {
            $file = $request->file('sertifikat_file');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Nama file unik
            $filePath = public_path('sertifikat'); // Folder penyimpanan di public

            // Pindahkan file ke folder public/sertifikat
            $file->move($filePath, $fileName);

            // Simpan path file yang baru
            $sertifikat['sertifikat_file'] = 'sertifikat/' . $fileName;
        }

        // Simpan data sertifikat ke database
        Sertifikat::create($sertifikat);

        return redirect()->route('admin.sertifikat.detail', $userId)->with('tambah_success', true);
    }


    public function edit($userId, $id)
    {
        $sertifikat = Sertifikat::findOrFail($id);
        $user = User::findOrFail($userId);
        $roles = ['dosen', 'mahasiswa', 'masyarakat'];
        return view('admin.data.sertifikat.edit', compact('user', 'roles', 'sertifikat'));
    }

    public function update(Request $request, $userId, $id)
    {
        $user = User::findOrFail($userId);
        $sertifikat = Sertifikat::findOrFail($id);

        // Validate the incoming request
        $request->validate([
            'nama_pelatihan'    => 'required|string|max:255',
            'tanggal_berlaku'   => 'required|date',
            'tanggal_berakhir'  => 'required|date|after_or_equal:tanggal_berlaku',
            'sertifikat_file'   => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Prepare data to update
        $data = [
            'nama_pelatihan'   => $request->nama_pelatihan,
            'tanggal_berlaku'  => $request->tanggal_berlaku,
            'tanggal_berakhir' => $request->tanggal_berakhir,
        ];

        // Handle file upload if a new file is provided
        if ($request->hasFile('sertifikat_file')) {
            // Delete the old file if it exists
            if ($sertifikat->sertifikat_file && file_exists(public_path($sertifikat->sertifikat_file))) {
                unlink(public_path($sertifikat->sertifikat_file)); // Menghapus file yang lama
            }

            // Store the new file in public/sertifikat and update the file path in the data array
            $file = $request->file('sertifikat_file');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Unique file name
            $filePath = public_path('sertifikat'); // Target folder in public

            // Move the file to public/sertifikat
            $file->move($filePath, $fileName);

            // Save the file path (relative to public folder)
            $data['sertifikat_file'] = 'sertifikat/' . $fileName;
        }

        // Update the sertifikat with the new data
        $sertifikat->update($data);

        // Redirect with a success message
        return redirect()->route('admin.sertifikat.edit', ['userId' => $userId, 'id' => $sertifikat->id])
            ->with('edit_success', true);
    }


    public function destroy($id)
    {
        $sertifikat = Sertifikat::findOrFail($id);
        $sertifikat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sertifikat berhasil dihapus.',
            'id' => $id
        ]);
    }
}
