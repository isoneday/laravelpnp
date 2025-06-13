<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penerbitan Buku</title>
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
            background-color: #eaeaea;
        }
    </style>
</head>
<body>
    <h2>Laporan Penerbitan Buku</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Diterbitkan Oleh</th>
                <th>Tanggal Penerbitan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $index => $report)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $report->book->title }}</td>
                    <td>{{ $report->book->author }}</td>
                    <td>Rp {{ number_format($report->book->price, 0, ',', '.') }}</td>
                    <td>{{ $report->book->stock }}</td>
                    <td>{{ $report->published_by }}</td>
                    <td>{{ $report->created_at->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada data penerbitan buku.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p><strong>Total Data:</strong> {{ count($reports) }}</p>
</body>
</html>
