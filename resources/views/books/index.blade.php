<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daftar Buku</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .action-btn { margin-right: 8px; }
    </style>
</head>
<body>
    <h2>Daftar Buku</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <a href="{{ route('books.create') }}">➕ Tambah Buku Baru</a>
 <a href="{{ route('publishing.reports.index') }}">Laporan Publishing</a>
<a href="{{ route('laporan.penerbitan.pdf') }}">Cetak PDF Penerbitan</a>
<a href="{{ route('laporan.penerbitan.excel') }}">Export Excel Penerbitan</a>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Diterbitkan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($books as $index => $book)
                <tr>
                    <td>{{ $books->firstItem() + $index }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->stock }}</td>
                    <td>Rp {{ number_format($book->price, 0) }}</td>
                    <td>{{ $book->created_at->format('d-m-Y') }}</td>
                    <td>
                        <a class="action-btn" href="{{ route('books.edit', $book->id) }}">✏️ Edit</a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus buku ini?')" type="submit">🗑️ Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">Belum ada buku yang diterbitkan.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $books->links() }}
    </div>
</body>
</html>
