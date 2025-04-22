<?php

use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dosen\DosenController;
use App\Http\Controllers\dosen\DosenpnpController;
use App\Http\Controllers\dosen\DosentiController;
use App\Http\Controllers\TeknisiController;

//default routing
Route::get('/', function () {
    return view('welcome');
});

Route::get('/mahasiswa', [MahasiswaController::class, 'index']);

Route::get('/listmahasiswa', function () {
    $arrmhs = [
        'reykel',
        'vania',
        'naufal',
        'rafi'
    ];
    return view('akademik.mahasiswa', ['mhs' => $arrmhs]);
});


Route::view('/hello', 'hello', ['nama' => 'reykel']);






Route::post('submit', function () {
    return 'form submitted!!';
});

Route::put('update/{id}', function ($id) {
    return 'update data for id:' . $id;
});

Route::delete('delete/{id}', function ($id) {
    return 'delete data for id:' . $id;
});



Route::get('/profile', function () {
    echo '<h1>Profile</h1>';
    return '<p> Jurusan teknologi informasi-Politeknik Negeri Padang</p>';
});

Route::get('mahasiswa/ti/latifa', function () {
    echo "<p style='font-size:40;color:orange'>Jurusan Teknologi Informasi";
    echo "<h1> Selamat Datang Latifa...</h1>";
    echo "<hr>";
    echo "<p> lorem .........................</p>";
});

//route with parameter
Route::get('mahasiswa/{nama}', function ($nama) {
    return '<p> Nama mahasiswa RPL : <b>' . $nama . '</b></p>';
});

Route::get('hitungusia/{nama}/{tahunlahir}', function ($nama, $tahun_lahir) {
    $usia = date('Y') - $tahun_lahir;
    return "<p>Hai <b>" . $nama . "</b><br> usia anda sekarang adalah <b>" . $usia . "</b> tahun.</p>";
});

//route with optional parameter
Route::get('mahasiswa/{nama?}', function ($nama = 'tidak ada') {
    return '<p> Nama mahasiswa RPL : <b>' . $nama . '</b></p>';
});

Route::get('hitungusia/{nama?}/{tahunlahir?}', function ($nama = "tidak ada", $tahun_lahir = "2025") {
    $usia = date('Y') - $tahun_lahir;
    return "<p>Hai <b>" . $nama . "</b><br> usia anda sekarang adalah <b>" . $usia . "</b> tahun.</p>";
});

//route with regular expression
Route::get('user/{id}', function ($id) {
    return '<p> user admin memiliki id <b>' . $id . '</b></p>';
})->where('id', '[0-9]+');

//route redirect
Route::redirect('public', 'hitungusia');

//route group
Route::prefix('login')->group(function () {
    route::get('mahasiswa', function () {
        return '<h2> login sebagai mahasiswa</h2>';
    });
    route::get('dosen', function () {
        return '<h2> login sebagai dosen</h2>';
    });
    route::get('admin', function () {
        return '<h2> login sebagai admin</h2>';
    });
});

// route fallback
Route::fallback(function () {
    return "<h2> Mohon maaf, halaman yang anda cari <b>tidak ditemukan</b>";
});

Route::get("listmahasiswa", function () {
    $mhs1 = "reykel";
    $mhs2 = "naufal";
    $mhs3 = "rafi";

    return view("akademik.mahasiswalist", compact(
        "mhs1",
        "mhs2",
        "mhs3"
    ));
});
//if conditional
Route::get("nilaimahasiswa", function () {
    $nama = "reykel";
    $nim = "20240343334";
    $total_nilai = 90;

    return view("akademik.nilaimahasiswa", compact(
        "nama",
        "nim",
        "total_nilai"
    ));
});
//switch
Route::get("nilaimhsswitch", function () {
    $nama = "reykel";
    $nim = "20240343334";
    $total_nilai = -1;

    return view("akademik.nilaimahasiswaswitch", compact(
        "nama",
        "nim",
        "total_nilai"
    ));
});

//forloop
Route::get("nilaimhsforloop", function () {
    $nama = "reykel";
    $nim = "20240343334";
    $total_nilai = 20;

    return view("akademik.nilaimahasiswaforloop", compact(
        "nama",
        "nim",
        "total_nilai"
    ));
});
//whileloop
Route::get("nilaimhswhile", function () {
    $nama = "reykel";
    $nim = "20240343334";
    $total_nilai = 2;

    return view("akademik.nilaimahasiswawhile", compact(
        "nama",
        "nim",
        "total_nilai"
    ));
});

//foreach
Route::get("nilaimhsforeach", function () {
    $nama = "reykel";
    $nim = "20240343334";
    $total_nilai = [20,30,50,80];

    return view("akademik.nilaimahasiswaforeach", compact(
        "nama",
        "nim",
        "total_nilai"
    ));
});

//forelse
Route::get("nilaimhsforeach", function () {
    $nama = "reykel";
    $nim = "20240343334";
    $total_nilai = [20,30,56,80];

    return view("akademik.nilaimahasiswaforelse", compact(
        "nama",
        "nim",
        "total_nilai"
    ));
});

//continue
Route::get("nilaimhsforeach", function () {
    $nama = "reykel";
    $nim = "20240343334";
    $total_nilai = [20,30,56,80];

    return view("akademik.nilaimahasiswacontinue", compact(
        "nama",
        "nim",
        "total_nilai"
    ));
});

//break
Route::get("nilaimhsbreak", function () {
    $nama = "reykel";
    $nim = "20240343334";
    $total_nilai = [100,80,20,30,56,80];

    return view("akademik.nilaimahasiswabreak", compact(
        "nama",
        "nim",
        "total_nilai"
    ));
});
//mahasiswa
Route::get('/mahasiswati', function () {
   $arrMhs =['naufal','reykel','atika','dika','gilang','rafi'];
    return view('akademik.mahasiswapnp',['mhs'=> $arrMhs]);
})->name(name: 'mahasiswati');;

//dosen
Route::get('/dosenti', action: function () {
    $arrDsn =['dosen web framework','dosen microservices','dosen mobile programming'
    ,'dosen web programming','dosen multimedia','dosen IOT'];
     return view('akademik.dosenpnp',['dsn'=> $arrDsn]);
 })->name('dosenti');

 //prodi
Route::get('/pnp/{jurusan}/{prodi}', action: function ($jurusan,$prodi) {
    $data=[$jurusan,$prodi];
    return view('akademik.prodipnp')->with('data',$data);
 })->name('prodi');

Route::get('dosen',[DosenController::class,'index']);

Route::get('teknisi',[TeknisiController::class,'index']);
Route::get('teknisi/create',[TeknisiController::class,'create']);
Route::get('teknisi/{id}',[TeknisiController::class,'show']);

Route::post('teknisi',[TeknisiController::class,'store']);
Route::get('teknisi/{id}/edit',[TeknisiController::class,'edit']);
Route::put('teknisi/{id}',[TeknisiController::class,'update']);
Route::delete('teknisi/{id}',[TeknisiController::class,'destroy']);

Route::get('insert-sql',[MahasiswaController::class,'insertSql']);
Route::get('insert-prepared',[MahasiswaController::class,'insertPrepared']);
Route::get('insert-binding',[MahasiswaController::class,'insertBinding']);
Route::get('update',[MahasiswaController::class,'update']);
Route::get('delete',[MahasiswaController::class,'delete']);
Route::get('select',[MahasiswaController::class,'select']);
Route::get('select-tampil',[MahasiswaController::class,'selectTampil']);
Route::get('select-view',[MahasiswaController::class,'selectView']);
Route::get('select-where',[MahasiswaController::class,'selectWhere']);
Route::get('statement',[MahasiswaController::class,'statement']);
//Query Builder
Route::get('dosen',[DosenpnpController::class,'index'])->name('dosens.index');
Route::get('dosen/create',[DosenpnpController::class,'create'])->name('dosens.create');
Route::post('dosen',[DosenpnpController::class,'store'])->name('dosens.store');
Route::get('dosen/{id}/edit',[DosenpnpController::class,'edit'])->name('dosens.edit');
Route::put('dosen/{id}',[DosenpnpController::class,'update'])->name('dosens.update');
Route::delete('dosen/{id}',[DosenpnpController::class,'destroy'])->name('dosens.destroy');
//Eloquent ORM
Route::get('dosenti',[DosentiController::class,'index'])->name('dosensti.index');
Route::get('dosenti/create',[DosentiController::class,'create'])->name('dosensti.create');
Route::post('dosenti',[DosentiController::class,'store'])->name('dosensti.store');
Route::get('dosenti/{id}/edit',[DosentiController::class,'edit'])->name('dosensti.edit');
Route::put('dosenti/{id}',[DosentiController::class,'update'])->name('dosensti.update');
Route::delete('dosenti/{id}',[DosentiController::class,'destroy'])->name('dosensti.destroy');


Route::get('cek-objek',[DosenController::class,'cekObjek']);
Route::get('insert',[DosenController::class,'insert']);
Route::get('mass-assignment',[DosenController::class,'massAssignment']);
Route::get('updatedosen',[DosenController::class,'update']);
Route::get('updatedosen-where',[DosenController::class,'updateWhere']);
Route::get('mass-update',[DosenController::class,'massUpdate']);
Route::get('deletedosen',[DosenController::class,'delete']);
Route::get('destroydosen',[DosenController::class,'destroy']);
Route::get('mass-delete',[DosenController::class,'massDelete']);
Route::get('all',[DosenController::class,'all']);
Route::get('all-view',[DosenController::class,'allView']);
Route::get('get-where',[DosenController::class,'getWhere']);
Route::get('test-where',[DosenController::class,'testWhere']);
Route::get('first',[DosenController::class,'first']);
Route::get('find',[DosenController::class,'find']);
Route::get('latest',[DosenController::class,'latest']);
Route::get('limit',[DosenController::class,'limit']);
Route::get('skip-take',[DosenController::class,'skipTake']);
Route::get('soft-delete',[DosenController::class,'softDelete']);
Route::get('with-trashed',[DosenController::class,'withTrashed']);
Route::get('restore',[DosenController::class,'restore']);
Route::get('force-delete',[DosenController::class,'forceDelete']);

Route::get('mahasiswapnp',[MahasiswaController::class,'selectView']);


