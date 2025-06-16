<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $news->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                {{-- Baris if($news->isEmpty()) telah dihapus karena $news selalu merupakan instance tunggal News di sini --}}
                @if($news->image)
                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-96 object-cover rounded-lg mb-6">
                @else
                    <img src="https://placehold.co/1000x500/CCCCCC/333333?text=Tidak+Ada+Gambar" alt="Tidak Ada Gambar" class="w-full h-96 object-cover rounded-lg mb-6">
                @endif

                <div class="text-gray-700 text-lg leading-relaxed mb-6">
                    <p class="mb-2"><strong>Penulis:</strong> {{ $news->author->name ?? 'N/A' }}</p>
                    <p class="mb-4"><strong>Tanggal Publikasi:</strong> {{ $news->published_at->format('d F Y H:i') }}</p>
                    <hr class="my-4 border-gray-200">
                    {!! nl2br(e($news->content)) !!} {{-- Menggunakan nl2br untuk baris baru, e() untuk escape --}}
                </div>

                <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-800 text-center">
                    <h3 class="font-bold text-xl mb-2">Tempat Iklan</h3>
                    <p>Iklan Anda bisa ditempatkan di sini. Misalnya, iklan banner atau teks.</p>
                    <a href="#" class="inline-block mt-3 px-6 py-2 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors">Lihat Penawaran Iklan</a>
                </div>

                <div class="mt-8 text-right">
                    <a href="{{ route('berita.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Kembali ke Daftar Berita
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
