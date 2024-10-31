<?php

namespace App\Http\Controllers;

use App\Models\Lsp;
use App\Models\KategoriPelatihan;
use App\Models\Pelatihan;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

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
        // Ambil data pelatihan dari database dan paginasi per 8 item
        $pelatihan = Pelatihan::paginate(8); // 8 pelatihan per halaman

        // Kirim data ke view
        return view('user.pelatihan.index', compact('pelatihan'));
    }

    public function deskripsi(Request $request){
        return view('user.content.pelatihan.deskripsi');
    }

    public function daftarPelatihan(Request $request){
        return view('user.content.pelatihan.daftarPelatihan');
    }
}
