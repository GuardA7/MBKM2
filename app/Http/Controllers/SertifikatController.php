<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SertifikatController extends Controller
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
        $request->validate(
            [
                'no_sertifikat'     => 'required|string|max:255',
                'nama_pelatihan'    => 'required|string|max:255',
                'tanggal_berlaku'   => 'required|date',
                'tanggal_berakhir'  => 'required|date|after_or_equal:tanggal_berlaku',
                'sertifikat_file'   => 'required|file|mimes:pdf,doc,docx|max:2048',
            ],
            [
                'no_sertifikat.required'          => 'Nomor sertifikat harus diisi.',
                'no_sertifikat.string'           => 'Nomor sertifikat harus berupa angka.',
                'no_sertifikat.max'               => 'Nomor sertifikat tidak boleh lebih dari 255 karakter.',
                'nama_pelatihan.required'         => 'Nama pelatihan harus diisi.',
                'nama_pelatihan.string'           => 'Nama pelatihan harus berupa teks.',
                'nama_pelatihan.max'              => 'Nama pelatihan tidak boleh lebih dari 255 karakter.',
                'tanggal_berlaku.required'        => 'Tanggal berlaku harus diisi.',
                'tanggal_berlaku.date'            => 'Tanggal berlaku harus berupa format tanggal yang valid.',
                'tanggal_berakhir.required'       => 'Tanggal berakhir harus diisi.',
                'tanggal_berakhir.date'           => 'Tanggal berakhir harus berupa format tanggal yang valid.',
                'tanggal_berakhir.after_or_equal' => 'Tanggal berakhir harus sama atau setelah tanggal berlaku.',
                'sertifikat_file.required'        => 'Sertifikat harus diisi.',
                'sertifikat_file.file'            => 'Sertifikat harus berupa file yang valid.',
                'sertifikat_file.mimes'           => 'File sertifikat harus memiliki format PDF, DOC, atau DOCX.',
                'sertifikat_file.max'             => 'Ukuran file sertifikat tidak boleh lebih dari 2 MB.',
            ]
        );

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
            'no_sertifikat'     => 'required|string|max:255',
            'nama_pelatihan'    => 'required|string|max:255',
            'tanggal_berlaku'   => 'required|date',
            'tanggal_berakhir'  => 'required|date|after_or_equal:tanggal_berlaku',
            'sertifikat_file'   => 'requird|file|mimes:pdf,doc,docx|max:2048',
        ], [
            'no_sertifikat.required'          => 'Nomor sertifikat harus diisi.',
            'no_sertifikat.string'            => 'Nomor sertifikat harus berupa angka.',
            'no_sertifikat.max'               => 'Nomor sertifikat tidak boleh lebih dari 255 karakter.',
            'nama_pelatihan.required'         => 'Nama pelatihan harus diisi.',
            'nama_pelatihan.string'           => 'Nama pelatihan harus berupa teks.',
            'nama_pelatihan.max'              => 'Nama pelatihan tidak boleh lebih dari 255 karakter.',
            'tanggal_berlaku.required'        => 'Tanggal berlaku harus diisi.',
            'tanggal_berlaku.date'            => 'Tanggal berlaku harus berupa format tanggal yang valid.',
            'tanggal_berakhir.required'       => 'Tanggal berakhir harus diisi.',
            'tanggal_berakhir.date'           => 'Tanggal berakhir harus berupa format tanggal yang valid.',
            'tanggal_berakhir.after_or_equal' => 'Tanggal berakhir harus sama atau setelah tanggal berlaku.',
            'sertifikat_file.requird'         => 'Sertifikat harus berupa diisi.',
            'sertifikat_file.file'            => 'Sertifikat harus berupa file yang valid.',
            'sertifikat_file.mimes'           => 'File sertifikat harus memiliki format PDF, DOC, atau DOCX.',
            'sertifikat_file.max'             => 'Ukuran file sertifikat tidak boleh lebih dari 2 MB.',
        ]);

        $data = [
            'no_sertifikat'    => $request->no_sertifikat,
            'nama_pelatihan'   => $request->nama_pelatihan,
            'tanggal_berlaku'  => $request->tanggal_berlaku,
            'tanggal_berakhir' => $request->tanggal_berakhir,
        ];

        if ($request->hasFile('sertifikat_file')) {
            if ($sertifikat->sertifikat_file && file_exists(public_path($sertifikat->sertifikat_file))) {
                unlink(public_path($sertifikat->sertifikat_file)); // Menghapus file yang lama
            }

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
            'success'   => true,
            'message'   => 'Sertifikat berhasil dihapus.',
            'id'        => $id
        ]);
    }

    public function chart(Request $request)
    {
        $role = $request->query('role', 'all'); // Default 'all' jika tidak ada role yang dipilih
        $year = $request->query('year', now()->year); // Default tahun saat ini jika tidak ada yang dipilih

        $dataMahasiswa  = array_fill(1, 12, 0);
        $dataDosen      = array_fill(1, 12, 0);
        $dataMasyarakat = array_fill(1, 12, 0);

        if ($role === 'all') {
            // Data untuk Mahasiswa
            $mahasiswaCounts = Sertifikat::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', $year)
                ->whereHas('user', function ($query) {
                    $query->where('role', 'mahasiswa');
                })
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray();

            foreach ($mahasiswaCounts as $month => $count) {
                $dataMahasiswa[$month] = $count;
            }

            // Data untuk Dosen
            $dosenCounts = Sertifikat::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', $year)
                ->whereHas('user', function ($query) {
                    $query->where('role', 'dosen');
                })
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray();

            foreach ($dosenCounts as $month => $count) {
                $dataDosen[$month] = $count;
            }

            // Data untuk Masyarakat
            $masyarakatCounts = Sertifikat::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', $year)
                ->whereHas('user', function ($query) {
                    $query->where('role', 'masyarakat');
                })
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray();

            foreach ($masyarakatCounts as $month => $count) {
                $dataMasyarakat[$month] = $count;
            }

            $data = [
                'mahasiswa' => $dataMahasiswa,
                'dosen' => $dataDosen,
                'masyarakat' => $dataMasyarakat,
            ];
        } else {
            // Jika role spesifik dipilih, ambil satu dataset saja
            $sertifikatCounts = Sertifikat::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', $year)
                ->when($role !== 'all', function ($query) use ($role) {
                    $query->whereHas('user', function ($q) use ($role) {
                        $q->where('role', $role);
                    });
                })
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray();

            $dataSingleRole = array_fill(1, 12, 0);
            foreach ($sertifikatCounts as $month => $count) {
                $dataSingleRole[$month] = $count;
            }

            $data = [
                $role => $dataSingleRole
            ];
        }

        $years = range(2020, now()->year); // Range tahun dari 2020 hingga saat ini

        return view('user.content.grafik.grafik', [
            'data'          => $data,
            'selectedRole'  => $role,
            'selectedYear'  => $year,
            'years'         => $years
        ]);
    }


    public function PresentaseMahasiswa()
    {
        return view('user.content.grafik.presentase');
    }
}
