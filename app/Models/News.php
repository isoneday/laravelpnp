<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    // Atribut yang dapat diisi secara massal
    protected $fillable = [
        'title',
        'image',
        'content',
        'author_id', // Menambahkan author_id
        'published_at',
    ];

    // Atribut yang harus di-cast ke tipe data tertentu
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Dapatkan user yang merupakan penulis berita ini.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
