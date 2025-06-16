<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Penjualan Buku</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        label { display: block; margin-top: 10px; }
        input, select { padding: 6px; width: 300px; margin-top: 5px; }
        button { margin-top: 15px; padding: 8px 16px; }
    </style>
</head>
<body>
    <h2>Edit Data Penjualan</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sales.update', $sale->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Judul Buku</label>
        <select name="book_id">
            @foreach ($books as $book)
                <option value="{{ $book->id }}" {{ $sale->book_id == $book->id ? 'selected' : '' }}>
                    {{ $book->title }}
                </option>
            @endforeach
        </select>

        <label>Jumlah</label>
        <input type="number" name="quantity" value="{{ old('quantity', $sale->quantity) }}">

        <label>Pembeli</label>
        <input type="text" name="sold_to" value="{{ old('sold_to', $sale->salesReport->sold_to ?? '') }}">

        <button type="submit">💾 Simpan Perubahan</button>
    </form>

    <p><a href="{{ route('sales.index') }}">⬅️ Kembali ke daftar</a></p>
</body>
</html>
