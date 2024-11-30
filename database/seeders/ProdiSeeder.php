<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    public function run()
    {
        DB::table('prodi')->insert([
            ['nama_fakultas' => 'Sekolah Vokasi',
            'nama_prodi' => 'Teknik Informatika'],
            ['nama_fakultas' => 'Sekolah Vokasi',
            'nama_prodi' => 'Sistem Informasi'],
            ['nama_fakultas' => 'Sekolah Vokasi','nama_prodi' => 'Teknik Komputer'],
        ]);
    }
}
