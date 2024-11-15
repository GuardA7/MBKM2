<?php

namespace App\Http\Controllers;

use App\Models\Lsp;
use App\Models\PelatihanUser;
use App\Models\KategoriPelatihan;
use App\Models\Pelatihan;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use auth
class PelatihanController extends Controller
{
    public function index(Request $request)
    {
        // Cek apakah permintaan adalah AJAX
        if ($request->ajax()) {
            $pelatihans = Pelatihan::with(['kategori:nama', 'lsp:nama'])->get(); // Memuat relasi
            return DataTables::of($pelatihans)
                ->addIndexColumn()
                ->make(true);
        }

        // Render view index jika tidak AJAX
        return view('admin.data.pelatihan.index');
    }

    public function create()
    {
        // Ambil data LSP dan Kategori
        $lsps = Lsp::all();
        $kategoris = KategoriPelatihan::all();

        // Render view untuk form tambah pelatihan
        return view('admin.data.pelatihan.create', compact('lsps', 'kategoris'));
    }

    public function detail()
    {
        // Ambil data LSP dan Kategori
        $lsps = Lsp::all();
        $kategoris = KategoriPelatihan::all();

        // Render view untuk form detail pelatihan
        return view('admin.data.pelatihan.detail', compact('lsps', 'kategoris'));
    }

    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'nama' => 'required|string|max:125',
            'jenis_pelatihan' => 'required|string|max:125',
            'deskripsi' => 'required|string',
            'tanggal_pendaftaran' => 'required|date',
            'berakhir_pendaftaran' => 'required|date',
            'harga' => 'required|numeric',
            'kuota' => 'required|integer',
            'lsp_id' => 'required|exists:lsp,id', // pastikan lsp yang dipilih ada di database
            'kategori_id' => 'required|exists:kategori,id', // pastikan kategori yang dipilih ada di database
            'gambar' => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        $data = $request->all();

        // Menghandle upload file gambar
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarNama = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('img/pelatihan'), $gambarNama);
            $data['gambar'] = $gambarNama;
        }

        // Simpan data pelatihan
        Pelatihan::create($data);

        return redirect()->route('admin.pelatihan.index')->with('tambah_success', true);
    }

    public function edit($id)
    {
        // Cari pelatihan berdasarkan ID
        $pelatihan = Pelatihan::findOrFail($id);
        $lsps = Lsp::all();  // Ambil data LSP
        $kategoris = KategoriPelatihan::all(); // Ambil data Kategori

        // Render view untuk form edit pelatihan
        return view('admin.data.pelatihan.edit', compact('pelatihan', 'lsps', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        // Cari pelatihan berdasarkan ID
        $pelatihan = Pelatihan::findOrFail($id);

        // Validasi input form
        $request->validate([
            'nama' => 'required|string|max:125',
            'jenis_pelatihan' => 'required|string|max:125',
            'deskripsi' => 'required|string',
            'tanggal_pendaftaran' => 'required|date',
            'berakhir_pendaftaran' => 'required|date',
            'harga' => 'required|numeric',
            'kuota' => 'required|integer',
            'lsp_id' => 'required|exists:lsp,id',
            'kategori_id' => 'required|exists:kategori,id',
            'gambar' => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        $data = $request->all();

        // Menghandle upload file gambar
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($pelatihan->gambar && file_exists(public_path('img/pelatihan/' . $pelatihan->gambar))) {
                unlink(public_path('img/pelatihan/' . $pelatihan->gambar));
            }
            $gambar = $request->file('gambar');
            $gambarNama = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('img/pelatihan'), $gambarNama);
            $data['gambar'] = $gambarNama;
        }

        // Update data pelatihan
        $pelatihan->update($data);

        return redirect()->back()->with('edit_success', 'Pelatihan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Hapus pelatihan berdasarkan ID
        $pelatihan = Pelatihan::findOrFail($id);

        try {
            // Hapus file gambar jika ada
            if ($pelatihan->gambar && file_exists(public_path('img/pelatihan/' . $pelatihan->gambar))) {
                unlink(public_path('img/pelatihan/' . $pelatihan->gambar));
            }

            $pelatihan->delete();
            return response()->json(['success' => true, 'message' => 'Pelatihan berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus pelatihan'], 500);
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

    /**
     * Get data for the registrations DataTable
     */
    public function getRegistrationsData(Request $request, $id)
    {
        $registrations = PelatihanUser::with('user')
            ->where('pelatihan_id', $id);

        return DataTables::of($registrations)
            ->addColumn('user_name', function ($registration) {
                return $registration->user->nama;
            })
            ->addColumn('user_email', function ($registration) {
                return $registration->user->email;
            })
            ->addColumn('status_pendaftaran', function ($registration) {
                return $registration->status_pendaftaran;
            })
            ->addColumn('bukti_pembayaran', function ($registration) {
                return $registration->bukti_pembayaran
    ? '<a href="' . asset(public_path('img/bukti_pembayaran/' . $registration->bukti_pembayaran)) . '" target="_blank">Lihat Bukti</a>'
    : 'Tidak ada bukti';

            })
            ->rawColumns(['bukti_pembayaran'])
            ->make(true);
    }

    public function updateStatus(Request $request)
{
    $registration = PelatihanUser::find($request->id);
    if ($registration) {
        $registration->status_pendaftaran = $request->status_pendaftaran;
        $registration->save();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 404);
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

}

