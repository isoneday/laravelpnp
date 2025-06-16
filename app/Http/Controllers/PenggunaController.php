<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenggunaRequest;
use App\Http\Requests\UpdatePenggunaRequest;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PenggunaController extends Controller
{
    //
    public function index()
    {
        $penggunas = Pengguna::latest()->paginate(2);
        return view('penggunas.index', compact('penggunas'));
    }
    public function create()
    {
        return view('penggunas.create');
    }
    public function store(StorePenggunaRequest $request)
    {
        //cara 1 manual validate
        // $request->validate([
        //     'name'=> 'required|string|max:100',
        //     'email'=> 'required|email|unique:penggunas',
        //     'password'=> 'required|min:6|confirmed',
        //     'phone'=>'nullable|digits_between:9,13'
        // ]);
        // simpan data ke database
        // Pengguna::create([
        //     'name'=>$request->name,
        //     'email'=>$request->email,
        //     'password'=> Hash::make($request->password),
        //     'phone'=>$request->phone,
        // ]);

        //cara2
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');
            $data['file_upload'] = $path;
        }
        Pengguna::create($data);

        return redirect()->route('penggunas.index')->with('success', 'Pengguna Berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        return view('penggunas.edit', compact('pengguna'));
    }

    public function update(UpdatePenggunaRequest $request, $id)
    {
        // $request->validate([
        //     'name' => 'required|string|max:100',
        //     'email' => 'required|email|unique:penggunas,email,' . $id,
        //     'phone' => 'nullable|digits_between:10,13',
        // ]);


        $pengguna = Pengguna::findOrFail($id);
        $data = $request->validated();
        // Upload file baru jika ada
        if ($request->hasFile('file_upload')) {
            // Hapus file lama jika ada
            if ($pengguna->file_upload && Storage::disk('public')->exists($pengguna->file_upload)) {
                Storage::disk('public')->delete($pengguna->file_upload);
            }

            $file = $request->file('file_upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');
            $data['file_upload'] = $path;
        }
        $pengguna->update($data);
        // $pengguna->update([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        // ]);

        return redirect()->route('penggunas.index')->with('success', 'Data penggunas diperbarui.');
    }

      public function destroy($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->delete();

        return redirect()->route('penggunas.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
