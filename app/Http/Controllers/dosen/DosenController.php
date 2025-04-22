<?php

namespace App\Http\Controllers\dosen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dosen;

class DosenController extends Controller
{
    //
    public function index()
    {
        return 'menampilkan list dosen';
    }
    public function cekObjek()
    {
        $dosen = new Dosen();
        dd($dosen);
    }

    public function insert()
    {
        $dosen = new Dosen();
        $dosen->nama = "naufal";
        $dosen->nik = "999999";
        $dosen->email = "naufal@gmail.com";
        $dosen->nohp = "082312333488";
        $dosen->alamat = "jl limau manih";
        $dosen->keahlian = "web programming";
        $dosen->save();
        dd($dosen);
    }

    public function massAssignment()
    {
        $dosen1 = Dosen::create(
            [
                'nama' => "atika",
                'nik' => "2958444",
                'email' => "atika@gmail.com",
                'nohp' => "08114848899",
                'alamat' => "jl limau manih",
                'keahlian' => "mobile programming",
            ]
        );
        dump($dosen1);
        $dosen2 = Dosen::create(
            [
                'nama' => "kasih",
                'nik' => "2993933",
                'email' => "kasih@gmail.com",
                'nohp' => "092302333",
                'alamat' => "jl limau manih",
                'keahlian' => "web programming",
            ]
        );
        dump($dosen2);
    }

    public function update()
    {
        $dosen = Dosen::find(10);
        $dosen->keahlian = "Data Analyst";
        $dosen->save();
        dd($dosen);
    }
    public function updateWhere()
    {
        $dosen = Dosen::where('nohp', '08114848899')->first();
        $dosen->keahlian = "Artifical Intelligence";
        $dosen->alamat = "jl padang";
        $dosen->nohp = "08232333333";
        $dosen->save();
        dd($dosen);
    }
    public function massUpdate()
    {
        $dosen = Dosen::where('nohp', '08114848899')->first()->update(
            [
                'alamat' => "jalan jalan",
                'keahlian' => "cloud platform",
            ]
        );
        dump($dosen);
    }

    public function delete()
    {
        $dosen = Dosen::find(22);
        $dosen->delete();
        dd($dosen);
    }
    public function destroy()
    {
        $dosen = Dosen::destroy(23);
        dd($dosen);
    }

    public function massDelete()
    {
        $dosen = Dosen::where('keahlian', 'cloud platform')->delete();
        dd($dosen);
    }
    public function all()
    {
        $dosen = Dosen::all();
        foreach ($dosen as $itemDosen) {
            echo $itemDosen->id . '<br>';
            echo $itemDosen->nama . '<br>';
            echo $itemDosen->nik . '<br>';
            echo $itemDosen->email . '<br>';
            echo $itemDosen->nohp . '<br>';
            echo $itemDosen->alamat;
            echo '<hr>';
            //dd ($itemDosen);
        }
    }
    public function allView()
    {
        $dosen = Dosen::all();
        return view('akademik.dosen', ['dsn' => $dosen]);
    }

    public function getWhere()
    {

        $dosen = Dosen::where('keahlian', 'Web Programming')
            ->orderBy('nama', 'desc')
            ->get();
        return view('akademik.dosen', ['dsn' => $dosen]);
    }
    public function testWhere()
    {

        $dosen = Dosen::where('keahlian', 'Web Programming')
            ->orderBy('nik', 'asc')
            ->get();
        return view('akademik.dosen', ['dsn' => $dosen]);
    }
    public function first()
    {

        $dosen = Dosen::where('keahlian', 'Web Programming')->first();
        return view('akademik.dosen1', ['dosen' => $dosen]);
    }
    public function find()
    {

        $dosen = Dosen::find(27);
        return view('akademik.dosen1', ['dosen' => $dosen]);
    }
    public function latest()
    {
        $dosen = Dosen::latest()->get();
        return view('akademik.dosen', ['dsn' => $dosen]);
    }
    public function limit()
    {
        $dosen = Dosen::latest()->limit(3)->get();
        return view('akademik.dosen', ['dsn' => $dosen]);
    }
    public function skipTake()
    {

        $dosen = Dosen::orderBy("id")->skip(2)->take(3)->get();
        return view('akademik.dosen', ['dsn' => $dosen]);
    }
    public function softDelete(){
        Dosen::where('id','2')->delete();
        return 'Data berhasil dihapus';
    }
    public function withTrashed(){
        $dosen = Dosen::withTrashed()->get();
        return view('akademik.dosen', ['dsn' => $dosen]);
    }
    public function restore(){
        Dosen::withTrashed()->where('id','2')->restore();
        return "data berhasil di restore";
    }
    public function forceDelete(){
        Dosen::where('id','2')->forceDelete();
        return "data berhasil di hapus secara permanen";
    }
}
