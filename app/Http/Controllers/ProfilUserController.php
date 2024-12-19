<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class ProfilUserController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('user.content.profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // Validasi input form
        $request->validate([
            'nama' => 'required|string|max:255',
            // Validasi lainnya
        ]);
    
        // Update profil pengguna
        $user = auth()->user();  // Ambil pengguna yang sedang login
        $user->update([
            'nama' => $request->nama,
            // Update kolom lain
        ]);
    
        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui');
    }
    
}
