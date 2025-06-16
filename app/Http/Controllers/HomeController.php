<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Tampilkan daftar berita terbaru.
     */
    public function index()
    {
        // Ambil berita terbaru, urutkan berdasarkan tanggal publikasi, dan paginasi
        $news = News::with('author')->latest('published_at')->paginate(9); // Menampilkan 9 berita per halaman
        return view('berita.index', compact('news'));
    }

    /**
     * Tampilkan detail berita.
     */
    public function show(News $news)
    {
        return view('berita.show', compact('news'));
    }
}
