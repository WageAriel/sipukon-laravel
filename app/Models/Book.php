<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'author',
        'isbn', 
        'publisher',
        'tahun', 
        'cover_image',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
