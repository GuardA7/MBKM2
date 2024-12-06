<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.data.user.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with(['prodi', 'kelas'])->select('users.*');

            return DataTables::of($users)
                ->addColumn('prodi', function ($row) {
                    return $row->prodi ? $row->prodi->nama_prodi : '-';
                })
                ->addColumn('kelas', function ($row) {
                    return $row->kelas ? $row->kelas->nama_kelas : '-';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
