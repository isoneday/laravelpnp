<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image')->nullable(); // Path ke gambar berita
            $table->longText('content');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade'); // Kunci asing ke tabel users
            $table->timestamp('published_at')->nullable(); // Tanggal publikasi
            $table->timestamps();
        });
    }

    /**
     * Kembalikan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
