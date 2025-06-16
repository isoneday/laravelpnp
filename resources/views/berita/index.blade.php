<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Berita Terbaru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($news->isEmpty())
                    <p class="text-gray-600 text-center">Belum ada berita yang dipublikasikan.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($news as $item)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl">
                                <a href="{{ route('berita.show', $item) }}">
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                                    @else
                                        <img src="https://placehold.co/600x400/CCCCCC/333333?text=Tidak+Ada+Gambar" alt="Tidak Ada Gambar" class="w-full h-48 object-cover">
                                    @endif
                                    <div class="p-4">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2 truncate">{{ $item->title }}</h3>
                                        <p class="text-sm text-gray-600 mb-1">
                                            Penulis: <span class="font-semibold">{{ $item->author->name ?? 'N/A' }}</span>
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            Tanggal: {{ $item->published_at->format('d M Y') }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $news->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
