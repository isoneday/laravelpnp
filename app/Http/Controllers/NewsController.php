<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Import Storage facade
use Illuminate\Support\Carbon; // Import Carbon

class NewsController extends Controller
{
    /**
     * Konstruktor untuk menerapkan middleware.
     * Baris ini telah dihapus karena middleware sudah diterapkan di routes/web.php
     * public function __construct()
     * {
     * $this->middleware(['auth', 'admin']); // Hanya user terautentikasi dan admin yang bisa mengakses
     * }
     */

    /**
     * Tampilkan daftar berita.
     */
    public function index()
    {
        $news = News::with('author')->latest('published_at')->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    /**
     * Tampilkan form untuk membuat berita baru.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Simpan berita baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|min:10|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Wajib diisi, maks 2MB
            'content' => 'required|string|min:50', // Konten minimal 50 karakter
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Simpan gambar ke folder 'news_images' di dalam 'storage/app/public'
            $imagePath = $request->file('image')->store('news_images', 'public');
        }

        News::create([
            'title' => $request->title,
            'image' => $imagePath,
            'content' => $request->content,
            'author_id' => auth()->id(), // Penulis adalah user yang sedang login
            'published_at' => Carbon::now(), // Set tanggal publikasi saat ini
        ]);

        return redirect()->route('news.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail berita (untuk admin, bisa juga diakses user melalui HomeController).
     */
    public function show(News $news)
    {
        // Untuk admin, mungkin ingin melihat detail sebelum edit/hapus
        return view('admin.news.show', compact('news'));
    }

    /**
     * Tampilkan form untuk mengedit berita.
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Perbarui berita di database.
     */
    public function update(Request $request, News $news)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|min:10|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Tidak wajib saat update
            'content' => 'required|string|min:50',
        ]);

        $imagePath = $news->image; // Pertahankan gambar yang sudah ada secara default

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('news_images', 'public');
        }

        $news->update([
            'title' => $request->title,
            'image' => $imagePath,
            'content' => $request->content,
            // author_id dan published_at tidak diubah saat update
        ]);

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Hapus berita dari database.
     */
    public function destroy(News $news)
    {
        // Hapus gambar terkait jika ada
        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();
        return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus!');
    }
}
