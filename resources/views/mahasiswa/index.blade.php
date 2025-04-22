<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Daftar Mahasiswa</title>
</head>
<body>
   <h1>Daftar Mahasiswa</h1>
   <ul>
       @foreach($data as $mahasiswa)
           <li>{{ $mahasiswa->nama }} ({{ $mahasiswa->nim }}) - {{ $mahasiswa->jurusan }}</li>
       @endforeach
   </ul>
</body>
</html>



