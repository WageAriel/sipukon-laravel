<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman'; 

    protected $fillable = [
        'judul',
        'nama_peminjam',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'metode_pengambilan',
        'alamat',
        'status_pengembalian',
        'kondisi_buku',
    ];
    
}
