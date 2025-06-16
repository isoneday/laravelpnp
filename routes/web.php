<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\dosen\DosenController;
use App\Http\Controllers\dosen\DosenpnpController;
use App\Http\Controllers\dosen\DosentiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\SaleController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TodoController;
use App\Models\Blog;

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



// Route::get('/profile', function () {
//     echo '<h1>Profile</h1>';
//     return '<p> Jurusan teknologi informasi-Politeknik Negeri Padang</p>';
// });

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
    $total_nilai = [20, 30, 50, 80];

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
    $total_nilai = [20, 30, 56, 80];

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
    $total_nilai = [20, 30, 56, 80];

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
    $total_nilai = [100, 80, 20, 30, 56, 80];

    return view("akademik.nilaimahasiswabreak", compact(
        "nama",
        "nim",
        "total_nilai"
    ));
});
//mahasiswa
Route::get('/mahasiswati', function () {
    $arrMhs = ['naufal', 'reykel', 'atika', 'dika', 'gilang', 'rafi'];
    return view('akademik.mahasiswapnp', ['mhs' => $arrMhs]);
})->name(name: 'mahasiswatii');


//dosen
Route::get('/dosenti', action: function () {
    $arrDsn = [
        'dosen web framework',
        'dosen microservices',
        'dosen mobile programming',
        'dosen web programming',
        'dosen multimedia',
        'dosen IOT'
    ];
    return view('akademik.dosenpnp', ['dsn' => $arrDsn]);
})->name('dosenti');

//prodi
Route::get('/pnp/{jurusan}/{prodi}', action: function ($jurusan, $prodi) {
    $data = [$jurusan, $prodi];
    return view('akademik.prodipnp')->with('data', $data);
})->name('prodi');

Route::get('dosen', [DosenController::class, 'index']);

Route::get('teknisi', [TeknisiController::class, 'index']);
Route::get('teknisi/create', [TeknisiController::class, 'create']);
Route::get('teknisi/{id}', [TeknisiController::class, 'show']);

Route::post('teknisi', [TeknisiController::class, 'store']);
Route::get('teknisi/{id}/edit', [TeknisiController::class, 'edit']);
Route::put('teknisi/{id}', [TeknisiController::class, 'update']);
Route::delete('teknisi/{id}', [TeknisiController::class, 'destroy']);

Route::get('insert-sql', [MahasiswaController::class, 'insertSql']);
Route::get('insert-prepared', [MahasiswaController::class, 'insertPrepared']);
Route::get('insert-binding', [MahasiswaController::class, 'insertBinding']);
Route::get('update', [MahasiswaController::class, 'update']);
Route::get('delete', [MahasiswaController::class, 'delete']);
Route::get('select', [MahasiswaController::class, 'select']);
Route::get('select-tampil', [MahasiswaController::class, 'selectTampil']);
Route::get('select-view', [MahasiswaController::class, 'selectView']);
Route::get('select-where', [MahasiswaController::class, 'selectWhere']);
Route::get('statement', [MahasiswaController::class, 'statement']);
//query builder
Route::get('dosen', [DosenpnpController::class, 'index'])->name('dosens.index');
Route::get('dosen/create', [DosenpnpController::class, 'create'])->name('dosens.create');
Route::post('dosen', [DosenpnpController::class, 'store'])->name('dosens.store');
Route::get('dosen/{id}/edit', [DosenpnpController::class, 'edit'])->name('dosens.edit');
Route::put('dosen/{id}', [DosenpnpController::class, 'update'])->name('dosens.update');
Route::delete('dosen/{id}', [DosenpnpController::class, 'destroy'])->name('dosens.destroy');
//eloquent ORM
Route::get('dosenti', [DosentiController::class, 'index'])->name('dosensti.index');
Route::get('dosenti/create', [DosentiController::class, 'create'])->name('dosensti.create');
Route::post('dosenti', [DosentiController::class, 'store'])->name('dosensti.store');
Route::get('dosenti/{id}/edit', [DosentiController::class, 'edit'])->name('dosensti.edit');
Route::put('dosenti/{id}', [DosentiController::class, 'update'])->name('dosensti.update');
Route::delete('dosenti/{id}', [DosentiController::class, 'destroy'])->name('dosensti.destroy');
//orm
Route::get('cek-objek', [DosenController::class, 'cekObjek']);
Route::get('insert', [DosenController::class, 'insert']);
Route::get('mass-assignment', [DosenController::class, 'massAssignment']);
Route::get('updatedosen', [DosenController::class, 'update']);
Route::get('updatedosen-where', [DosenController::class, 'updateWhere']);
Route::get('mass-update', [DosenController::class, 'massUpdate']);
Route::get('deletedosen', [DosenController::class, 'delete']);
Route::get('destroydosen', [DosenController::class, 'destroy']);
Route::get('mass-delete', [DosenController::class, 'massDelete']);
Route::get('all', [DosenController::class, 'all']);
Route::get('all-view', [DosenController::class, 'allView']);
Route::get('get-where', [DosenController::class, 'getWhere']);
Route::get('test-where', [DosenController::class, 'testWhere']);
Route::get('first', [DosenController::class, 'first']);
Route::get('find', [DosenController::class, 'find']);
Route::get('latest', [DosenController::class, 'latest']);
Route::get('limit', [DosenController::class, 'limit']);
Route::get('skip-take', [DosenController::class, 'skipTake']);
Route::get('soft-delete', [DosenController::class, 'softDelete']);
Route::get('with-trashed', [DosenController::class, 'withTrashed']);
Route::get('restore', [DosenController::class, 'restore']);
Route::get('force-delete', [DosenController::class, 'forceDelete']);

Route::get('/mahasiswatii', [MahasiswaController::class, 'selectView'])->name(name: 'mahasiswati');;
Route::get('/dosenpnp', [DosenController::class, 'index']);

// (Opsional) Arahkan dashboard ke daftar pengguna
// Route::get('/dashboard', function () {
//     return redirect()->route('penggunas.index');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/dashboard', [PenggunaController::class, 'index'])
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

//     Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::redirect('/', '/dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    Route::get('/berita', [HomeController::class, 'index'])->name('berita.index');
    Route::get('/berita/{news}', [HomeController::class, 'show'])->name('berita.show');

    // Admin routes
    Route::middleware(['auth', 'admin'])->group(function () { // ✅ 'admin' adalah alias yang benar
        Route::resource('penggunas', PenggunaController::class);
        Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
        Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
        Route::put('/todos/{id}', [TodoController::class, 'update'])->name('todos.update');
        Route::delete('/todos/{id}', [TodoController::class, 'destroy'])->name('todos.destroy');
        Route::resource('news', NewsController::class); // Rute resource untuk manajemen berita


        Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
    });
});
Route::resource('books', BookController::class);
Route::resource('sales', SaleController::class);
Route::get('/publishing-reports', [ReportController::class, 'publishingIndex'])->name('publishing.reports.index');
Route::get('/sales-reports', [ReportController::class, 'salesIndex'])->name('sales.reports.index');
Route::get('/laporan/penerbitan/pdf', [ReportController::class, 'exportPenerbitanPdf'])->name('laporan.penerbitan.pdf');
Route::get('/laporan/penjualan/pdf', [ReportController::class, 'exportPenjualanPdf'])->name('laporan.penjualan.pdf');

Route::get('/laporan/penerbitan/excel', [ReportController::class, 'exportPenerbitanExcel'])->name('laporan.penerbitan.excel');
Route::get('/laporan/penjualan/excel', [ReportController::class, 'exportPenjualanExcel'])->name('laporan.penjualan.excel');



// Route::get('/', function () {
//     return redirect()->route('presensi.index');
// });

// Route untuk halaman presensi
Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');

/*
|--------------------------------------------------------------------------
| API Routes untuk AJAX
|--------------------------------------------------------------------------
*/

Route::prefix('api')->group(function () {
    // Route untuk operasi presensi
    Route::post('/presensi', [PresensiController::class, 'store'])->name('api.presensi.store');
    Route::get('/presensi/history', [PresensiController::class, 'history'])->name('api.presensi.history');
    Route::get('/presensi/stats', [PresensiController::class, 'stats'])->name('api.presensi.stats');
    Route::get('/presensi/locations', [PresensiController::class, 'locations'])->name('api.presensi.locations');
});

/*
|--------------------------------------------------------------------------
| Routes untuk dashboard admin (opsional)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/presensi', function () {
        $presensi = \App\Models\Presensi::with([])
            ->orderBy('waktu_presensi', 'desc')
            ->paginate(50);

        return view('admin.presensi', compact('presensi'));
    })->name('presensi');

    Route::get('/presensi/export', function () {
        // Logic untuk export data presensi ke Excel/CSV
        return response()->download(storage_path('app/exports/presensi.csv'));
    })->name('presensi.export');
});
require __DIR__ . '/auth.php';
