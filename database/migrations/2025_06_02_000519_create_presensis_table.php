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
        Schema::create('presensi', function (Blueprint $table) {
          $table->id();
            $table->string('nama', 100);
            $table->enum('jenis_presensi', ['WFO', 'WFF']);
            $table->string('wff_location', 50)->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('alamat_lengkap', 255)->nullable();
            $table->timestamp('waktu_presensi');
            $table->timestamps();
            
            // Index untuk performa query
            $table->index(['nama', 'waktu_presensi']);
            $table->index(['jenis_presensi', 'waktu_presensi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
