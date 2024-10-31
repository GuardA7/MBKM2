<?php
namespace App\Http\Controllers;

use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MasyarakatController extends Controller
{

    public function register(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|unique:masyarakat,nik',
            'notelpon' => 'required|string|max:15', // Adjust max length as needed
            'jenisklamin' => 'required|string',
            'email' => 'required|string|email|unique:masyarakat,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create a new Masyarakat
        Masyarakat::create([
            'nik' => $request->nik,
            'notelpon' => $request->no_hp,
            'jenisklamin' => $request->jenis_kelamin,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Registration successful! You can now log in.');
    }
}
