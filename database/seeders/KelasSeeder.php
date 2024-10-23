<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelas')->insert([
            [
                'nama' => 'Kelas A Teknik Informatika',
                'prodi_id' => 10, // Assuming 1 is the ID for 'Teknik Informatika' prodi
            ],
            [
                'nama' => 'Kelas B Teknik Informatika',
                'prodi_id' => 10, // Same prodi as above
            ],
            [
                'nama' => 'Kelas A Sistem Informasi',
                'prodi_id' => 11, // Assuming 2 is the ID for 'Sistem Informasi' prodi
            ],
            [
                'nama' => 'Kelas A Teknik Elektro',
                'prodi_id' => 12, // Assuming 3 is the ID for 'Teknik Elektro' prodi
            ],
            [
                'nama' => 'Kelas A Teknik Mesin',
                'prodi_id' => 13, // Assuming 4 is the ID for 'Teknik Mesin' prodi
            ],
        ]);
    }
}
