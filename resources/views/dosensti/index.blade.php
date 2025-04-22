



@extends('layouts.main')
@section('title')
Daftar Dosen TI
@endsection
@section('content')
<h1>Data Dosen TI</h1>
<a href="{{ route('dosensti.create') }}">Tambah Dosen</a>
@if(session('success'))
    <p>{{ session('success') }}</p>
@endif
<table border="1">
    <tr>
        <th>Nama</th>
        <th>Nik</th>
        <th>Email</th>
        <th>Nohp</th>
        <th>Alamat</th>
        <th>Bidang</th>
        <th>Aksi</th>
    </tr>
    @foreach($dosens as $lecturer)
    <tr>
        <td>{{ $lecturer->nama }}</td>
        <td>{{ $lecturer->nik }}</td>
        <td>{{ $lecturer->email }}</td>
        <td>{{ $lecturer->nohp }}</td>
        <td>{{ $lecturer->alamat }}</td>
        <td>{{ $lecturer->bidang }}</td>
        <td>
            <a href="{{ route('dosensti.edit', $lecturer->id) }}">Edit</a>
            <form action="{{ route('dosensti.destroy', $lecturer->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
