@extends('layouts.main')

@section('content')
<h2>Form Tambah Pengguna</h2>

@if(session('success'))
    <div style="color:green;">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div style="color:red;">
        <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('penggunas.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Nama:</label>
    <input type="text" name="name" value="{{ old('name') }}"><br>

    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email') }}">
    @error('email')
        <br><small style="color: red;">{{ $message }}</small>
    @enderror
    <br>

    <label>Password:</label>
    <input type="password" name="password">
    @error('password')
        <br><small style="color: red;">{{ $message }}</small>
    @enderror
    <br>

    <label>Konfirmasi Password:</label>
    <input type="password" name="password_confirmation">
    @error('password_confirmation')
        <br><small style="color: red;">{{ $message }}</small>
    @enderror
    <br>

    <label>No. HP:</label>
    <input type="text" name="phone" value="{{ old('phone') }}">
    @error('phone')
        <br><small style="color: red;">{{ $message }}</small>
    @enderror
    <br>
    <label> Upload File (PDF/JPG/PNG):</label>
    <input type="file" name="file_upload" accept=".pdf,.jpg,.jpeg,.png">
    @error('file_upload')
        <br><small style="color: red">{{ $message }}</small>
    @enderror

    <button type="submit">Simpan</button>
</form>
@endsection
