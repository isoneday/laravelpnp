<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daftar Penjualan Buku</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h2 { color: #333; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
        th { background-color: #f5f5f5; }
        .action { display: flex; gap: 10px; }
    </style>
</head>
<body>
    <h2>Daftar Penjualan Buku</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <a href="{{ route('sales.create') }}">➕ Tambah Penjualan Baru</a>
     <a href="{{ route('sales.reports.index') }}">Laporan Penjualan</a>
<a href="{{ route('laporan.penjualan.pdf') }}">Cetak PDF Penjualan</a>
<a href="{{ route('laporan.penjualan.excel') }}">Export Excel Penjualan</a>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Buku</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $index => $sale)
                <tr>
                    <td>{{ $sales->firstItem() + $index }}</td>
                    <td>{{ $sale->book->title }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>Rp {{ number_format($sale->total_price, 0) }}</td>
                    <td>{{ $sale->created_at->format('d-m-Y H:i') }}</td>
                    <td class="action">
                     
                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">🗑️ Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">Belum ada data penjualan.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $sales->links() }}
    </div>
</body>
</html>
