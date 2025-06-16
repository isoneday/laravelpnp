<x-app-layout>
    <div class="max-w-7xl mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Blog IT</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($blogs as $blog)
                <a href="{{ route('blog.show', $blog->slug) }}"
                    class="bg-white shadow rounded-lg overflow-hidden hover:shadow-xl transition duration-300">
                    @if ($blog->thumbnail)
                        <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-900">{{ $blog->title }}</h2>
                        <p class="text-sm text-gray-600 mb-2">
                            Diposting oleh {{ $blog->author->name }} |
                            {{ $blog->published_at->format('d M Y') }}
                        </p>
                        <p class="text-sm text-gray-700 line-clamp-3">
                            {{ Str::limit(strip_tags($blog->content), 120, '...') }}
                        </p>
                    </div>
                </a>
            @empty
                <p class="text-gray-600">Belum ada blog yang tersedia.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $blogs->links() }}
        </div>
    </div>
</x-app-layout>
