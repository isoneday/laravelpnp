@extends('layouts.main')
@section('title')
Daftar Dosen TI
@endsection
@section('content')
    
<div class="form-container">
    <h2>Tambah Dosen TI</h2>
    <form action="{{ route('dosensti.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama:</label>
            <input type="text" name="nama" required>
        </div>
        <div class="form-group">
            <label>nik:</label>
            <input type="text" name="nik" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Nohp:</label>
            <input type="text" name="nohp">
        </div>
        <div class="form-group">
            <label>Alamat:</label>
            <input type="text" name="alamat">
        </div>


        <div class="form-group">
            <label>Bidang:</label>
            <input type="text" name="bidang" required>
        </div>

        <button type="submit">Simpan</button>
    </form>
</div>

@endsection

 