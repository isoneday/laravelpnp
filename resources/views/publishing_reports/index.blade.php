<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penerbitan Buku</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #2c3e50; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Laporan Penerbitan Buku</h2>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

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
            @forelse ($publishingReports as $index => $report)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $report->book->title }}</td>
                    <td>{{ $report->book->author }}</td>
                    <td>Rp {{ number_format($report->book->price, 0) }}</td>
                    <td>{{ $report->book->stock }}</td>
                    <td>{{ $report->published_by }}</td>
                    <td>{{ $report->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada data penerbitan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
