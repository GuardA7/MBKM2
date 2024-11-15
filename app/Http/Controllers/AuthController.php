<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use App\Models\KategoriPelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // show login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // show Register
public function showRegisterForm()
{
    return view('auth.register');
}


    // Menangani proses login
    public function login(Request $request)
    {
        // Validasi input login
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek apakah login berhasil
        if (Auth::attempt($credentials)) {
            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            // Cek role pengguna yang login
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('index');
            }
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Menangani proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function index()
    {
        // Retrieve all Pelatihan with their related categories and LSP data
        $pelatihans = Pelatihan::with(['kategori', 'lsp'])->get();
        $kategoris = KategoriPelatihan::with('pelatihan')->get();

        // Pass data to the view
        return view('index', compact('pelatihans', 'kategoris'));
    }
}
