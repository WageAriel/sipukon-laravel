<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    public function run()
    {
        DB::table('mahasiswa')->insert([
            ['nama_mahasiswa' => 'Ahmad Rizky', 'prodi_id' => 1], // Mengacu ke id prodi
            ['nama_mahasiswa' => 'Budi Santoso', 'prodi_id' => 2],
            ['nama_mahasiswa' => 'Citra Dewi', 'prodi_id' => 3],
        ]);
    }
}
