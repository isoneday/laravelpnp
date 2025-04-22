<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{

    public function insertSql()
    {
        $query = DB::insert('insert into mahasiswas (nobp, nama,jurusan,prodi,email,nohp
        ,tgllahir,created_at,updated_at) values ("243434993","anla","Teknologi Informasi"
        ,"RPL","anla@gmail.com","082323344455","2000-03-30",now(),now())');
        return "berhasil insert data mahasiswa";
    }

    public function insertPrepared()
    {
        $query = DB::insert('insert into mahasiswas (nobp, nama,jurusan,prodi,email,nohp
        ,tgllahir,created_at,updated_at) values (?,?,?,?,?,?,?,?,?)', [
            "2311081031",
            "reykel",
            "Teknologi Informasi",
            "RPL",
            "reykel@gmail.com",
            "082239588855",
            "2001-02-20",
            now(),
            now()
        ]);
        return "berhasil insert data mahasiswa";
    }

    public function insertBinding()
    {
        $query = DB::insert(
            'insert into mahasiswas (nobp, nama,jurusan,prodi,email,nohp
        ,tgllahir,created_at,updated_at) values (:nobp,:nama,:jurusan,:prodi,:email,:nohp,:tgllahir,:created_at,:updated_at)',
            [
                "tgllahir" => "2001-02-20",
                "prodi" => "RPL",
                "email" => "naufal@gmail.com",
                "nohp" => "0822395888522",
                "created_at" => now(),
                "updated_at" => now(),
                "nobp" => "2311081022",
                "nama" => "naufal",
                "jurusan" => "Teknologi Informasi"
            ]
        );
        return "berhasil insert data mahasiswa";
    }
    public function update()
    {
        $query = DB::update("UPDATE mahasiswas SET jurusan ='sastra jepang' WHERE nama=?", ['sarah']);
        return "berhasil udpate data mahasiswa";
    }

    public function delete()
    {
        $query = DB::delete("DELETE FROM mahasiswas WHERE nama=?", ['agel']);
        return "berhasil delete data mahasiswa";
    }

    public function select()
    {
        $query = DB::select("SELECT * FROM mahasiswas");
        dd($query);
    }
    public function selectTampil()
    {
        $query = DB::select("SELECT * FROM mahasiswas");
        echo ($query[2]->id) . "<br/>";
        echo ($query[2]->nama) . "<br/>";
        echo ($query[2]->nobp) . "<br/>";
        echo ($query[2]->jurusan) . "<br/>";
        echo ($query[2]->prodi) . "<br/>";
        echo ($query[2]->tgllahir) . "<br/>";
    }

    public function selectView()
    {
        $query = Mahasiswa::latest()->paginate(10);
        return view("akademik.mahasiswapnp", ["mhs"=>$query]);
       
    }
    public function selectWhere()
    {
        $query = DB::select("SELECT * FROM mahasiswas WHERE prodi=? ORDER BY nobp ASC", ["TK"]);
        return view("akademik.mahasiswapnp", ["mhs"=>$query]);
       
    }
    public function statement()
    {
        $query = DB::delete("TRUNCATE mahasiswas");
        return "berhasil menghapus table mahasiswa";
       
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        DB::listen(function ($query) {
            logger("Query: " . $query->sql . " |binding " . implode(", ", $query->bindings));
        });
        //mengambil semua data mahasiswa
        $data = Mahasiswa::all();
        // dd($data);

        dump($data);
        return view("mahasiswa.index", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
