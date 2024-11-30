<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class FakultasSeeder extends Seeder
{
    public function run()
    {
        DB::table('fakultas')->insert([
            ['nama_fakultas' => 'FMIPA'],
            ['nama_fakultas' => 'Sekolah Vokasi'],
            ['nama_fakultas' => 'Ilmu Budaya'],
        ]);
    }
}
