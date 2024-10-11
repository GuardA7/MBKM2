<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prodi;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prodiList = [
            'D3 TEKNIK MESIN',
            'D3 TEKNIK PENDINGIN DAN TATA UDARA',
            'D3 TEKNIK INFORMATIKA',
            'D3 KEPERAWATAN',
            'D4 PERANCANGAN MANUFAKTUR',
            'D4 REKAYASA PERANGKAT LUNAK',
            'D4 TEKNOLOGI REKAYASA INSTRUMENTASI DAN KONTROL',
            'D4 SISTEM INFORMASI KOTA CERDAS',
        ];

        foreach ($prodiList as $prodi) {
            Prodi::create(['nama' => $prodi]);
        }
    }
}
