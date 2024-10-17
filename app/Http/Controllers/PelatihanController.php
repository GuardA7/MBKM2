<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan; // Pastikan model Pelatihan sudah ada
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data pelatihan dari database dan paginasi per 8 item
        $pelatihan = Pelatihan::paginate(8); // 8 pelatihan per halaman

        // Kirim data ke view
        return view('user.pelatihan.index', compact('pelatihan'));
    }
}
