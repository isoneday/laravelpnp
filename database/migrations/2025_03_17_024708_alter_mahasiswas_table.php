<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            //
            $table->renameColumn('nim','nobp'); 
            $table->date('tgllahir')->after('prodi');
            $table->dropColumn('alamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            //
            $table->renameColumn('nobp','nim');
            $table->dropColumn('tgllahir');
            $table->string('alamat')->after('jurusan');
        });
    }
};
