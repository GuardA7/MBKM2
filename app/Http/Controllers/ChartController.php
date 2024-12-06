<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Sertifikat;
use App\Models\Jurusan;
use App\Models\Prodi;
use App\Models\Kelas;

class ChartController extends Controller
{


    public function index(Request $request)
    {
        $jurusan_id = $request->input('jurusan_id');
        $prodi_id = $request->input('prodi_id');
        $kelas_id = $request->input('kelas_id');
        $role = $request->input('role');

        // Fetch data in relational structure
        $jurusan = Jurusan::with('prodis.kelas')->get();

        // Filter users based on the selected filters
        $userQuery = User::query();
        if ($role) $userQuery->where('role', $role);
        if ($jurusan_id) $userQuery->where('jurusan_id', $jurusan_id);
        if ($prodi_id) $userQuery->where('prodi_id', $prodi_id);
        if ($kelas_id) $userQuery->where('kelas_id', $kelas_id);

        $totalUsers = $userQuery->count();
        $uploadedUsers = Sertifikat::whereIn('user_id', $userQuery->pluck('id'))->count();
        $notUploadedUsers = $totalUsers - $uploadedUsers;

        // Data to pass to the view
        $data = [
            'uploaded' => $uploadedUsers,
            'not_uploaded' => $notUploadedUsers,
        ];

        return view('user.content.grafik.presentase', compact('data', 'jurusan', 'jurusan_id', 'prodi_id', 'kelas_id', 'role'));
    }



}
