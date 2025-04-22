<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // jika ingin seeder manual tanpa faker
        // \App\Models\Mahasiswa::create([
        //     'nama'=>'naufal',
        //     'nobp'=>'202423245',
        //     'email'=>'naufal@gmail.com',
        //     'nohp'=>'23232322',
        //     'jurusan'=>'TI',
        //     'prodi'=>'TRPL',
        //     'tgllahir'=>'2002-04-12'
        // ]);
    
        //jika menggunakan faker
         \App\Models\Mahasiswa::factory(10)->create();
    }
}
