<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleAndUserSeeder extends Seeder
{
    public function run()
    {
        // Membuat Role
        $mahasiswaRole = Role::create(['name' => 'mahasiswa']);
        $dosenRole = Role::create(['name' => 'dosen']);
        $masyarakatRole = Role::create(['name' => 'masyarakat']);
        $adminRole = Role::create(['name' => 'admin']);

        // Membuat User dan Assign Role

        // 1. Mahasiswa
        $mahasiswa = User::create([
            'nama' => 'Mahasiswa Satu',
            'email' => 'mahasiswa@example.com',
            'password' => bcrypt('password'),
            'role' => 'mahasiswa',
            'nim' => '123456789',
            'no_hp' => '08123456789',
            'jenis_kelamin' => 'L',
            'prodi_id' => 6, // Sesuaikan ID prodi
            'kelas_id' => 1  // Sesuaikan ID kelas
        ]);
        $mahasiswa->assignRole($mahasiswaRole);

        // 2. Dosen
        $dosen = User::create([
            'nama' => 'Dosen Satu',
            'email' => 'dosen@example.com',
            'password' => bcrypt('password'),
            'role' => 'dosen',
            'nidn' => '987654321',
            'no_hp' => '08123456789',
            'jenis_kelamin' => 'L',
            'prodi_id' => 1 // Sesuaikan ID prodi
        ]);
        $dosen->assignRole($dosenRole);

        // 3. Masyarakat Umum
        $masyarakat = User::create([
            'nama' => 'Masyarakat Umum',
            'email' => 'masyarakat@example.com',
            'password' => bcrypt('password'),
            'role' => 'masyarakat',
            'nik' => '1029384756',
            'no_hp' => '08123456789',
        ]);
        $masyarakat->assignRole($masyarakatRole);

        // 4. Admin
        $admin = User::create([
            'nama' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $admin->assignRole($adminRole);
    }
}
