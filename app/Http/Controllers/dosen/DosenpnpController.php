<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class DosenpnpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $dosens = Dosen::latest()->paginate(1);
        return view('dosens/index', compact('dosens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('dosens.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'email' => 'required|email|unique:dosens',
            'nohp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
            'keahlian' => 'required|string|max:255'
        ]);
        DB::table('dosens')->insert([
            'nama' =>$request->nama,
            'nik' =>$request->nik,
            'email' => $request->email,
            'nohp' => $request->nohp,
            'alamat' => $request->alamat,
            'keahlian' => $request->keahlian,
            'created_at' => now(),
            'updated_at' => now()
    ]);
  return  redirect()->route('dosens.index')->with('success','Data Dosens berhasil ditambahkan');
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
        $dosen = DB::table('dosens')->where('id', $id)->first();
        return view('dosens.edit', compact('dosen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'email' => 'required|email|unique:dosens,email,' . $id,
            'nohp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
            'keahlian' => 'required|string|max:255'
        ]);
        DB::table('dosens')
        ->where('id', $id)
        ->update([
            'nama' =>$request->nama,
            'nik' =>$request->nik,
            'email' => $request->email,
            'nohp' => $request->nohp,
            'alamat' => $request->alamat,
            'keahlian' => $request->keahlian,
            'updated_at' => now()
    ]);
   return redirect()->route('dosens.index')->with('success','Data Dosens berhasil diupdate');
   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        DB::table('dosens')->where('id', $id)->delete();
     return   redirect()->route('dosens.index')->with('success','Data Dosens berhasil dihapus');
      
    }
}
