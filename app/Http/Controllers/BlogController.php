<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Tampilkan semua blog.
     */
    public function index()
    {
        $blogs = Blog::latest('published_at')->paginate(6);
        return view('blog.index', compact('blogs'));
    }

    /**
     * Tampilkan detail blog berdasarkan slug.
     */
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        return view('blog.show', compact('blog'));
    }
}
