<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosenti;
use Illuminate\Http\Request;

// use Illuminate\Support\Facades\DB;

class DosentiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $dosens = Dosenti::all();
        return view('dosensti/index', compact('dosens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('dosensti.create');
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
            'bidang' => 'required|string|max:255'
        ]);
        Dosenti::create($request->all());
        return  redirect()->route('dosensti.index')->with('success', 'Data Dosens berhasil ditambahkan');
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
        $dosen = Dosenti::findOrFail($id);
        return view('dosensti.edit', compact('dosen'));
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
            'bidang' => 'required|string|max:255'
        ]);
        $dosen = Dosenti::findOrFail($id);
        $dosen->update($request->all());
        return redirect()->route('dosensti.index')->with('success', 'Data Dosens berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $dosen = Dosenti::findOrFail($id);
        $dosen->delete();
        return   redirect()->route('dosensti.index')->with('success', 'Data Dosens berhasil dihapus');
    }
}
