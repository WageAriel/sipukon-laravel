<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    public function run()
    {
        DB::table('prodi')->insert([
            ['nama_prodi' => 'Teknik Informatika'],
            ['nama_prodi' => 'Sistem Informasi'],
            ['nama_prodi' => 'Teknik Komputer'],
        ]);
    }
}
