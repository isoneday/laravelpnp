@extends('layouts.main')
@section('title', 'Data Prodi')

@section('content')
<h1>Daftar Jurusan : {{ $data[0] }} Prodi : {{ $data[1] }}</h1>
<div class="row">
    <div class="col-lg-4">
        <div class="card" style="width: 18rem;">
            <img src="/images/logoti.png" class="card-img-top" alt="Logo TI">
            <div class="card-body">
                <h5 class="card-title">Prodi Manajemen Informatika</h5>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi nihil voluptate vero
                    harum soluta reiciendis </p>
                <a href="#" class="btn btn-primary">more</a>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card" style="width: 18rem;">
            <img src="/images/logoti.png" class="card-img-top" alt="Logo TI">
            <div class="card-body">
                <h5 class="card-title">Prodi Teknik Komputer</h5>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi nihil voluptate vero
                    harum soluta reiciendis </p>
                <a href="#" class="btn btn-primary">more</a>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <di class="card" style="width: 18rem;">
            <img src="/images/logoti.png" class="card-img-top" alt="Logo TI">
            <div class="card-body">
                <h5 class="card-title">Prodi Teknologi Rekayasa Perangkat Lunak</h5>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi nihil voluptate vero
                    harum soluta reiciendis </p>
                <a href="#" class="btn btn-primary">more</a>
            </div>
    </div>
</div>
</div>
@endsection
