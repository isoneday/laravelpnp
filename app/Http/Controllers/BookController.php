<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\PublishingReport;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->paginate(10);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'stock'        => 'required|integer|min:0',
            'price'        => 'required|numeric|min:0',
            'published_by' => 'required|string|max:255',
        ]);

        $book = Book::create([
            'title'  => $request->title,
            'author' => $request->author,
            'stock'  => $request->stock,
            'price'  => $request->price,
        ]);

        PublishingReport::create([
            'book_id'      => $book->id,
            'published_by' => $request->published_by,
        ]);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diterbitkan.');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title'  => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'stock'  => 'required|integer|min:0',
            'price'  => 'required|numeric|min:0',
        ]);

        $book->update($request->only('title', 'author', 'stock', 'price'));

        return redirect()->route('books.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}

