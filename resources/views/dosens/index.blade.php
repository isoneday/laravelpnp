



@extends('layouts.main')
@section('title')
Daftar Dosen
@endsection
@section('content')
<h1>Data Dosen</h1>
<a href="{{ route('dosens.create') }}">Tambah Dosen</a>
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
        <th>Keahlian</th>
        <th>Aksi</th>
    </tr>
    @foreach($dosens as $lecturer)
    <tr>
        <td>{{ $lecturer->nama }}</td>
        <td>{{ $lecturer->nik }}</td>
        <td>{{ $lecturer->email }}</td>
        <td>{{ $lecturer->nohp }}</td>
        <td>{{ $lecturer->alamat }}</td>
        <td>{{ $lecturer->keahlian }}</td>
        <td>
            <a href="{{ route('dosens.edit', $lecturer->id) }}">Edit</a>
            <form action="{{ route('dosens.destroy', $lecturer->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
<div class="pagination-container">
    {{ $dosens->links() }}
</div>
@endsection
