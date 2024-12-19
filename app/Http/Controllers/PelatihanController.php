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
        return view('admin.data.pelatihan.listpelatihan.index',);
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
            'nama'                      => 'required|string|max:125|unique:pelatihan,nama',
            'jenis_pelatihan'           => 'required|string|max:125',
            'deskripsi'                 => 'required|string',
            'tanggal_pendaftaran'       => 'required|date',
            'berakhir_pendaftaran'      => 'required|date|after_or_equal:tanggal_pendaftaran',
            'jadwal_pelatihan_mulai'    => 'required|date',
            'jadwal_pelatihan_selesai'  => 'required|date|after_or_equal:jadwal_pelatihan_mulai',
            'harga'                     => 'required|numeric',
            'kuota'                     => 'required|integer',
            'lsp_id'                    => 'required|exists:lsp,id',
            'kategori_id'               => 'required|exists:kategori,id',
            'gambar'                    => 'required|image|mimes:jpg,png|max:2048',
        ], [
            'nama.required'                             => 'Nama pelatihan wajib diisi.',
            'nama.unique'                               => 'Nama pelatihan sudah ada.',
            'jenis_pelatihan.required'                  => 'Jenis pelatihan wajib diisi.',
            'deskripsi.required'                        => 'Deskripsi wajib diisi.',
            'tanggal_pendaftaran.required'              => 'Tanggal pendaftaran wajib diisi.',
            'berakhir_pendaftaran.required'             => 'Tanggal berakhir pendaftaran wajib diisi.',
            'berakhir_pendaftaran.after_or_equal'       => 'Tanggal berakhir pendaftaran harus lebih besar atau sama dengan tanggal pendaftaran.',
            'jadwal_pelatihan_mulai.required'           => 'Jadwal pelatihan wajib diisi.',
            'jadwal_pelatihan_selesai.required'         => 'Jadwal selesai pelatihan wajib diisi.',
            'jadwal_pelatihan_selesai.after_or_equal'   => 'Jadwal selesai pelatihan harus lebih besar atau sama dengan tanggal pendaftaran.',
            'harga.required'                            => 'Harga pelatihan wajib diisi.',
            'kuota.required'                            => 'Kuota pelatihan wajib diisi.',
            'lsp_id.required'                           => 'LSP wajib dipilih.',
            'kategori_id.required'                      => 'Kategori wajib dipilih.',
            'gambar.image'                              => 'File gambar harus berupa gambar.',
            'gambar.mimes'                              => 'Gambar harus berformat JPG atau PNG.',
            'gambar.max'                                => 'Ukuran gambar maksimal 2MB.',
            'gambar.required'                           => 'Gambar wajib diisi.',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $gambar     = $request->file('gambar');
            $gambarNama = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('img/pelatihan/gambar/'), $gambarNama);
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
            'nama'                      => 'required|string|max:125',
            'jenis_pelatihan'           => 'required|string|max:125',
            'deskripsi'                 => 'required|string',
            'tanggal_pendaftaran'       => 'required|date',
            'berakhir_pendaftaran'      => 'required|date|after_or_equal:tanggal_pendaftaran',
            'jadwal_pelatihan_mulai'    => 'required|date',
            'jadwal_pelatihan_selesai'  => 'required|date|after_or_equal:jadwal_pelatihan_mulai',
            'harga'                     => 'required|numeric',
            'kuota'                     => 'required|integer',
            'lsp_id'                    => 'required|exists:lsp,id',
            'kategori_id'               => 'required|exists:kategori,id',
            'gambar'                    => 'required|image|mimes:jpg,png|max:2048',
        ], [
            'nama.required'                             => 'Nama pelatihan wajib diisi.',
            'jenis_pelatihan.required'                  => 'Jenis pelatihan wajib diisi.',
            'deskripsi.required'                        => 'Deskripsi wajib diisi.',
            'tanggal_pendaftaran.required'              => 'Tanggal pendaftaran wajib diisi.',
            'berakhir_pendaftaran.required'             => 'Tanggal berakhir pendaftaran wajib diisi.',
            'berakhir_pendaftaran.after_or_equal'       => 'Tanggal berakhir pendaftaran harus lebih besar atau sama dengan tanggal pendaftaran.',
            'jadwal_pelatihan_mulai.required'           => 'Jadwal pelatihan wajib diisi.',
            'jadwal_pelatihan_selesai.required'         => 'Jadwal selesai pelatihan wajib diisi.',
            'jadwal_pelatihan_selesai.after_or_equal'   => 'Jadwal selesai pelatihan harus lebih besar atau sama dengan tanggal pendaftaran.',
            'harga.required'                            => 'Harga pelatihan wajib diisi.',
            'kuota.required'                            => 'Kuota pelatihan wajib diisi.',
            'lsp_id.required'                           => 'LSP wajib dipilih.',
            'kategori_id.required'                      => 'Kategori wajib dipilih.',
            'gambar.image'                              => 'File gambar harus berupa gambar.',
            'gambar.mimes'                              => 'Gambar harus berformat JPG atau PNG.',
            'gambar.max'                                => 'Ukuran gambar maksimal 2MB.',
            'gambar.required'                           => 'Gambar wajib diisi.',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            if ($pelatihan->gambar && file_exists(public_path($pelatihan->gambar))) {
                unlink(public_path($pelatihan->gambar));
            }

            $gambar     = $request->file('gambar');
            $gambarNama = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('img/pelatihan/gambar/'), $gambarNama);
            $data['gambar'] = $gambarNama;
        }

        $pelatihan->update($data);
        return redirect()->route('admin.pelatihan.edit', $id)->with('edit_success', true);
    }

    public function getParticipants($id)
    {
        $participants = PelatihanUser::where('pelatihan_id', $id)
            ->with(['user', 'pelatihan'])
            ->get();

        return datatables()->of($participants)
            ->addColumn('nama_user', fn($row) => $row->user->nama)
            ->addColumn('email_user', fn($row) => $row->user->email)
            ->addColumn('nama_pelatihan', fn($row) => $row->pelatihan->nama)
            ->addColumn('status_pendaftaran', fn($row) => $row->status_pendaftaran)
            ->addColumn('status_kelulusan', fn($row) => $row->status_kelulusan)
            ->addColumn('bukti_pembayaran', fn($row) => $row->bukti_pembayaran
                ? '<a href="' . asset("uploads/" . $row->bukti_pembayaran) . '" target="_blank">Lihat</a>'
                : '-')
            ->addColumn('created_at', fn($row) => $row->created_at->format('d-m-Y'))
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

    public function updateStatusKelulusan(Request $request)
    {
        $request->validate([
            'id'               => 'required|exists:pelatihan_user,id',
            'status_kelulusan' => 'required|in:menunggu,lulus,tidak_lulus', // Sesuaikan opsi status kelulusan
        ]);

        try {
            // Cari data pendaftaran berdasarkan ID
            $registration = PelatihanUser::findOrFail($request->id);

            // Perbarui status kelulusan
            $registration->status_kelulusan = $request->status_kelulusan;
            $registration->save();

            return response()->json(['success' => true, 'message' => 'Status kelulusan berhasil diperbarui.']);
        } catch (\Exception $e) {
            // Tangani jika ada error
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui status kelulusan.'], 500);
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
            if ($pelatihan->gambar && file_exists(public_path('img/pelatihan/gambar/' . $pelatihan->gambar))) {
                unlink(public_path('img/pelatihan/gambar/' . $pelatihan->gambar));
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
        $search     = $request->input('search');
        $categoryId = $request->input('category');

        $kategoris = KategoriPelatihan::all();
        $pelatihans = Pelatihan::with(['kategori:id,nama', 'lsp:id,nama']);

        if ($search) {
            $pelatihans->where('nama', 'like', '%' . $search . '%');
        }

        if ($categoryId) {
            $pelatihans->where('kategori_id', $categoryId);
        }

        $pelatihans = $pelatihans->paginate(6);

        return view('user.content.pelatihan.index', compact('pelatihans', 'kategoris', 'search', 'categoryId'));
    }


    public function deskripsi($id)
    {
        $pelatihan = Pelatihan::with(['kategori:nama', 'lsp:nama'])->findOrFail($id);
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
            'no_telp'           => 'required|string|max:15',
            'bukti_pembayaran'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pelatihan = Pelatihan::findOrFail($id);
        $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        PelatihanUser::create([
            'user_id'               => auth()->id(),
            'pelatihan_id'          => $id,
            'bukti_pembayaran'      => $buktiPath,
            'status_pendaftaran'    => 'menunggu',
        ]);

        return redirect()->route('user.pelatihan.index')->with('success', 'Pendaftaran berhasil, menunggu konfirmasi admin.');
    }

    public function registrations($id)
    {
        $pelatihan      = Pelatihan::findOrFail($id);
        $registrations  = PelatihanUser::with('user')
            ->where('pelatihan_id', $id);

        return view('admin.data.pelatihan.registrations', compact('pelatihan'));
    }

    public function pelatihanSaya(Request $request)
    {
        $user       = Auth::user();
        $pelatihans = $user->pelatihan()->with(['kategori', 'lsp'])->get();

        return view('user.content.pelatihan.pelatihan_saya', compact('pelatihans'));
    }


    public function detail_pelatihan($id)
    {
        $user = Auth::user();

        $pelatihan = $user->pelatihan()
            ->with(['kategori', 'lsp'])
            ->where('pelatihan_id', $id) // Pastikan id pelatihan cocok
            ->firstOrFail();

        return view('user.content.pelatihan.detailPendaftaran', compact('pelatihan'));
    }
}
