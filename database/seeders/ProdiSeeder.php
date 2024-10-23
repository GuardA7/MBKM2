<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('prodis')->insert([
            [
                'nama' => 'Teknik Informatika',
                'jurusan_id' => 1, // Assuming this is the ID of the 'Teknik Informatika' jurusan
            ],
            [
                'nama' => 'Sistem Informasi',
                'jurusan_id' => 1, // Belongs to the same jurusan
            ],
            [
                'nama' => 'Teknik Elektro',
                'jurusan_id' => 3, // Assuming this is the ID of 'Teknik Elektro'
            ],
            [
                'nama' => 'Teknik Mesin',
                'jurusan_id' => 4, // Assuming this is the ID of 'Teknik Mesin'
            ],
            [
                'nama' => 'Manajemen Informatika',
                'jurusan_id' => 2, // Assuming this is the ID of 'Manajemen Informatika'
            ],
        ]);
    }
}
