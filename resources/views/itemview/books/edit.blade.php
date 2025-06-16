<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Buku</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        label { display: block; margin-top: 10px; }
        input { width: 300px; padding: 6px; margin-top: 5px; }
        button { margin-top: 15px; padding: 8px 16px; }
    </style>
</head>
<body>
    <h2>Edit Buku: {{ $book->title }}</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('books.update', $book->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Judul Buku</label>
        <input type="text" name="title" value="{{ old('title', $book->title) }}">

        <label>Penulis</label>
        <input type="text" name="author" value="{{ old('author', $book->author) }}">

        <label>Stok</label>
        <input type="number" name="stock" value="{{ old('stock', $book->stock) }}">

        <label>Harga (Rp)</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $book->price) }}">

        <button type="submit">💾 Simpan Perubahan</button>
    </form>

    <p><a href="{{ route('books.index') }}">⬅️ Kembali ke Daftar Buku</a></p>
</body>
</html>
