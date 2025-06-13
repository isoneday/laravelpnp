<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Buku</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <h2>Laporan Penjualan Buku</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Pembeli</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Tanggal Pembelian</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $index => $report)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $report->sale->book->title }}</td>
                    <td>{{ $report->sold_to }}</td>
                    <td>{{ $report->sale->quantity }}</td>
                    <td>Rp {{ number_format($report->sale->total_price, 0, ',', '.') }}</td>
                    <td>{{ $report->created_at->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada data penjualan buku.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p><strong>Total Transaksi:</strong> {{ count($reports) }}</p>
</body>
</html>
