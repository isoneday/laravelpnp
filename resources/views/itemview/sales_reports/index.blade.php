<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Buku</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #2c3e50; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        .total { font-weight: bold; background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h2>Laporan Penjualan Buku</h2>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Nama Pembeli</th>
                <th>Tanggal Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($salesReports as $index => $report)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $report->sale->book->title }}</td>
                    <td>{{ $report->sale->quantity }}</td>
                    <td>Rp {{ number_format($report->sale->total_price, 0) }}</td>
                    <td>{{ $report->sold_to }}</td>
                    <td>{{ $report->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada data penjualan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
