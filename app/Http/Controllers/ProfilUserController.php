<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilUserController extends Controller
{
    public function showDosenProfile(Request $request)
    {
        $action = $request->get('action', 'detail'); 
        $user = Auth::user();
        return view('user.content.profile.dosen', compact('user', 'action'));
    }

    public function showMahasiswaProfile(Request $request)
    {
        $action = $request->get('action', 'detail'); 
        $user = Auth::user();
        return view('user.content.profile.mahasiswa', compact('user', 'action'));
    }

    public function showMasyarakatProfile(Request $request)
    {
        $action = $request->get('action', 'detail'); 
        $user = Auth::user();
        return view('user.content.profile.masyarakat', compact('user', 'action'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi data
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:20',
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', true);
    }

    public function updatePassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Verifikasi kata sandi lama
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Kata sandi lama salah.']);
        }

        // Perbarui kata sandi
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
    
}
