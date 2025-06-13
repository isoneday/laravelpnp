<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Sale;
use App\Models\SalesReport;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('book')->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $books = Book::where('stock', '>', 0)->get();
        return view('sales.create', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id'  => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'sold_to'  => 'required|string|max:255',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok buku tidak mencukupi.']);
        }

        $total = $book->price * $request->quantity;

        $sale = Sale::create([
            'book_id'     => $book->id,
            'quantity'    => $request->quantity,
            'total_price' => $total,
        ]);

        SalesReport::create([
            'sale_id' => $sale->id,
            'sold_to' => $request->sold_to,
        ]);

        $book->decrement('stock', $request->quantity);

        return redirect()->route('sales.index')->with('success', 'Pembelian berhasil dicatat.');
    }
      public function edit(Book $book)
    {
        return view('sales.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
          $request->validate([
            'book_id'  => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'sold_to'  => 'required|string|max:255',
        ]);

        $book->update($request->only('title', 'author', 'stock', 'price'));

        return redirect()->route('books.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Data penjualan dihapus.');
    }
}
