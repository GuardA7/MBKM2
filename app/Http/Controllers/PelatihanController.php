<?php

namespace App\Http\Controllers;

use App\Models\Lsp;
use App\Models\Pelatihan;
use Illuminate\Http\Request;
use App\Models\PelatihanUser;
use App\Models\KategoriPelatihan;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;


class PelatihanController extends Controller
{
    public function index(Request $request)
    {
        // Check if the request is AJAX
        if ($request->ajax()) {
            $data = Pelatihan::with(['kategori', 'lsp'])->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $editUrl        = route('admin.pelatihan.edit', $row->id);
                    $deleteUrl      = route('admin.pelatihan.destroy', $row->id);
                    $detailUrl      = route('admin.pelatihan.detail', $row->id);
                    return '
                    <a href="' . $detailUrl . '" class="btn btn-sm btn-info" data-id="' . $row->id . '">
                        <i class="fas fa-eye" style="color: white;"></i>
                    </a>
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary" data-id="' . $row->id . '">
                        <i class="fas fa-pen" style="color: white;"></i>
                    </a>
                    <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger delete-button" data-id="' . $row->id . '">
                            <i class="fas fa-trash" style="color: white;"></i>
                        </button>
                    </form>
                ';
                })
                ->rawColumns(['action', 'gambar'])
                ->make(true);
        }
        return view('admin.data.pelatihan.listpelatihan.index');
    }

    public function create()
    {
        $lsps       = Lsp::all();
        $kategoris  = KategoriPelatihan::all();
        return view('admin.data.pelatihan.listpelatihan.create', compact('lsps', 'kategoris'));
    }

    public function detail($id)
    {
        $pelatihan      = Pelatihan::with(['users', 'kategori', 'lsp'])->findOrFail($id);
        $pelatihanUser  = PelatihanUser::where('pelatihan_id', $id)->get();

        return view('admin.data.pelatihan.listpelatihan.detail', compact('pelatihan', 'pelatihanUser'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'                  => 'required|string|max:125|unique:pelatihan,nama',
            'jenis_pelatihan'       => 'required|string|max:125',
            'deskripsi'             => 'required|string',
            'tanggal_pendaftaran'   => 'required|date',
            'berakhir_pendaftaran'  => 'required|date|after_or_equal:tanggal_pendaftaran',
            'harga'                 => 'required|numeric',
            'kuota'                 => 'required|integer',
            'lsp_id'                => 'required|exists:lsp,id',
            'kategori_id'           => 'required|exists:kategori,id',
            'gambar'                => 'nullable|image|mimes:jpg,png|max:2048',
        ], [
            'nama.required'                         => 'Nama pelatihan wajib diisi.',
            'nama.unique'                    => 'Nama pelatihan sudah ada.',
            'jenis_pelatihan.required'              => 'Jenis pelatihan wajib diisi.',
            'deskripsi.required'                    => 'Deskripsi wajib diisi.',
            'tanggal_pendaftaran.required'          => 'Tanggal pendaftaran wajib diisi.',
            'berakhir_pendaftaran.required'         => 'Tanggal berakhir pendaftaran wajib diisi.',
            'berakhir_pendaftaran.after_or_equal'   => 'Tanggal berakhir pendaftaran harus lebih besar atau sama dengan tanggal pendaftaran.',
            'harga.required'                        => 'Harga pelatihan wajib diisi.',
            'kuota.required'                        => 'Kuota pelatihan wajib diisi.',
            'lsp_id.required'                       => 'LSP wajib dipilih.',
            'kategori_id.required'                  => 'Kategori wajib dipilih.',
            'gambar.image'                          => 'File gambar harus berupa gambar.',
            'gambar.mimes'                          => 'Gambar harus berformat JPG atau PNG.',
            'gambar.max'                            => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $gambar     = $request->file('gambar');
            $gambarNama = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('img/pelatihan/'), $gambarNama);
            $data['gambar'] = $gambarNama;
        }

        Pelatihan::create($data);

        return redirect()->route('admin.pelatihan.index')->with('tambah_success', true);
    }

    public function edit($id)
    {
        $pelatihan  = Pelatihan::findOrFail($id);
        $lsps       = Lsp::all();
        $kategoris  = KategoriPelatihan::all();

        return view('admin.data.pelatihan.listpelatihan.edit', compact('pelatihan', 'lsps', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $pelatihan = Pelatihan::findOrFail($id);

        $request->validate([
            'nama'                  => 'required|string|max:125',
            'jenis_pelatihan'       => 'required|string|max:125',
            'deskripsi'             => 'required|string',
            'tanggal_pendaftaran'   => 'required|date',
            'berakhir_pendaftaran'  => 'required|date|after_or_equal:tanggal_pendaftaran',
            'harga'                 => 'required|numeric',
            'kuota'                 => 'required|integer',
            'lsp_id'                => 'required|exists:lsp,id',
            'kategori_id'           => 'required|exists:kategori,id',
            'gambar'                => 'nullable|image|mimes:jpg,png|max:2048',
        ], [
            'nama.required'                         => 'Nama pelatihan wajib diisi.',
            'jenis_pelatihan.required'              => 'Jenis pelatihan wajib diisi.',
            'deskripsi.required'                    => 'Deskripsi wajib diisi.',
            'tanggal_pendaftaran.required'          => 'Tanggal pendaftaran wajib diisi.',
            'berakhir_pendaftaran.required'         => 'Tanggal berakhir pendaftaran wajib diisi.',
            'berakhir_pendaftaran.after_or_equal'   => 'Tanggal berakhir pendaftaran harus lebih besar atau sama dengan tanggal pendaftaran.',
            'harga.required'                        => 'Harga pelatihan wajib diisi.',
            'kuota.required'                        => 'Kuota pelatihan wajib diisi.',
            'lsp_id.required'                       => 'LSP wajib dipilih.',
            'kategori_id.required'                  => 'Kategori wajib dipilih.',
            'gambar.image'                          => 'File gambar harus berupa gambar.',
            'gambar.mimes'                          => 'Gambar harus berformat JPG atau PNG.',
            'gambar.max'                            => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            if ($pelatihan->gambar && file_exists(public_path($pelatihan->gambar))) {
                unlink(public_path($pelatihan->gambar));
            }

            $gambar     = $request->file('gambar');
            $gambarNama = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('img/pelatihan/'), $gambarNama);
            $data['gambar'] = $gambarNama;
        }


        $pelatihan->update($data);

        return redirect()->route('admin.pelatihan.edit', $id)->with('edit_success', true);
    }

    public function getParticipants($pelatihanId)
    {
        $participants = PelatihanUser::with(['user', 'pelatihan'])
            ->where('pelatihan_id', $pelatihanId)
            ->select(['id', 'user_id', 'pelatihan_id', 'status_pendaftaran', 'created_at']);

        return DataTables::of($participants)
            ->addColumn('nama_user', fn($row) => $row->user->nama ?? '-')
            ->addColumn('email_user', fn($row) => $row->user->email ?? '-')
            ->addColumn('nama_pelatihan', fn($row) => $row->pelatihan->nama ?? '-')
            ->addColumn('status_pendaftaran', fn($row) => $row->status_pendaftaran)
            ->addColumn('bukti_pembayaran', function ($row) {
                return $row->bukti_pembayaran
                    ? '<a href="' . asset('img/pelatihan/buktiPembayaran/' . $row->bukti_pembayaran) . '" target="_blank">Lihat Bukti</a>'
                    : 'Tidak ada bukti';
            })
            ->editColumn('created_at', fn($row) => $row->created_at->format('d/m/Y'))
            ->rawColumns(['bukti_pembayaran'])
            ->make(true);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id'                 => 'required|exists:pelatihan_user,id',
            'status_pendaftaran' => 'required|in:menunggu,diterima,ditolak',
        ]);

        try {
            $registration = PelatihanUser::findOrFail($request->id);
            $registration->status_pendaftaran = $request->status_pendaftaran;
            $registration->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status.'], 500);
        }
    }

    public function destroy($id)
    {
        // Cari pelatihan berdasarkan ID
        $pelatihan = Pelatihan::find($id);

        if (!$pelatihan) {
            return response()->json(['success' => false, 'message' => 'Pelatihan tidak ditemukan'], 404);
        }

        try {
            // Hapus file gambar jika ada
            if ($pelatihan->gambar && file_exists(public_path('img/pelatihan/' . $pelatihan->gambar))) {
                unlink(public_path('img/pelatihan/' . $pelatihan->gambar));
            }

            // Hapus pelatihan dari database
            $pelatihan->delete();

            return response()->json(['success' => true, 'message' => 'Pelatihan berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus pelatihan: ' . $e->getMessage()], 500);
        }
    }


    public function index_user(Request $request)
    {
        // Get search and category filters from the request
        $search = $request->input('search');
        $categoryId = $request->input('category');

        // Query to fetch categories for filter buttons
        $kategoris = KategoriPelatihan::all();

        // Build query for pelatihans based on search and category
        $pelatihans = Pelatihan::with(['kategori:id,nama', 'lsp:id,nama']);

        if ($search) {
            $pelatihans->where('nama', 'like', '%' . $search . '%');
        }

        if ($categoryId) {
            $pelatihans->where('kategori_id', $categoryId);
        }

        $pelatihans = $pelatihans->paginate(6);

        // Pass the data to the view
        return view('user.content.pelatihan.index', compact('pelatihans', 'kategoris', 'search', 'categoryId'));
    }


    public function deskripsi($id){
        $pelatihan = Pelatihan::with(['kategori:nama', 'lsp:nama'])->findOrFail($id);

        // Return the view with the pelatihan data
        return view('user.content.pelatihan.deskripsi', compact('pelatihan'));
    }


    //Daftar Pelatihan

    public function showDaftarForm($id)
    {
        $pelatihan = Pelatihan::findOrFail($id);
        return view('user.content.pelatihan.daftarPelatihan', compact('pelatihan'));
    }

    public function submitDaftar(Request $request, $id)
    {
        $request->validate([
            'no_telp' => 'required|string|max:15',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pelatihan = Pelatihan::findOrFail($id);

        // Handle file upload
        $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        // Create the registration with a default 'menunggu' status
        PelatihanUser::create([
            'user_id' => auth()->id(),
            'pelatihan_id' => $id,
            'bukti_pembayaran' => $buktiPath,
            'status_pendaftaran' => 'menunggu',
        ]);

        return redirect()->route('user.pelatihan.index')->with('success', 'Pendaftaran berhasil, menunggu konfirmasi admin.');
    }

    public function registrations($id)
    {
        // Retrieve the Pelatihan by ID
        $pelatihan = Pelatihan::findOrFail($id);

        // Fetch registered users for this Pelatihan via PelatihanUser
        $registrations = PelatihanUser::with('user')
            ->where('pelatihan_id', $id);

        // Return the view
        return view('admin.data.pelatihan.registrations', compact('pelatihan'));
    }

    public function pelatihanSaya(Request $request)
    {
        // Retrieve the logged-in user
        $user = Auth::user();

        // Get the list of trainings that the user has registered for
        $pelatihans = $user->pelatihan()->with(['kategori', 'lsp'])->get();

        // Return the view with registered trainings
        return view('user.content.pelatihan.pelatihan_saya', compact('pelatihans'));
    }

    
    public function detail_pelatihan($id)
    {
        $user = Auth::user();

        // Cari pelatihan berdasarkan ID dan relasi dengan pivot
        $pelatihan = $user->pelatihan()
            ->with(['kategori', 'lsp'])
            ->where('pelatihan_id', $id) // Pastikan id pelatihan cocok
            ->firstOrFail();

        // Return view dengan data pelatihan
        return view('user.content.pelatihan.detailPendaftaran', compact('pelatihan'));
    }

}

