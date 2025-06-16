<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Carbon;

class NewsSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     */
    public function run(): void
    {
        // Dapatkan ID admin atau user pertama sebagai penulis
        $adminUser = User::where('role', User::ADMIN_ROLE)->first();
        if (!$adminUser) {
            $this->command->error('User admin tidak ditemukan. Jalankan AdminUserSeeder terlebih dahulu.');
            return;
        }

        // Hapus berita yang sudah ada untuk menghindari duplikasi saat seeding berulang
        News::truncate();

        // Buat beberapa berita dummy
        News::create([
            'title' => 'Panduan Lengkap Laravel 12 untuk Pemula',
            'image' => 'news_images/laravel-12-guide.jpg', // Contoh path gambar
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'author_id' => $adminUser->id,
            'published_at' => Carbon::now()->subDays(5),
        ]);

        News::create([
            'title' => 'Perkembangan Teknologi AI Terbaru di Tahun 2024',
            'image' => 'news_images/ai-tech.jpg',
            'content' => 'Detail tentang inovasi AI, machine learning, dan dampaknya pada industri. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'author_id' => $adminUser->id,
            'published_at' => Carbon::now()->subDays(3),
        ]);

        News::create([
            'title' => 'Tips Membangun Aplikasi Web Aman dengan PHP',
            'image' => 'news_images/web-security.jpg',
            'content' => 'Membahas praktik terbaik untuk keamanan web, termasuk validasi input, pencegahan XSS dan SQL Injection. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'author_id' => $adminUser->id,
            'published_at' => Carbon::now()->subDays(1),
        ]);

        $this->command->info('Berita dummy berhasil dibuat!');
    }
}
