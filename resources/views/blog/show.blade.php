<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-4">
        <div class="mb-6">
            <h1 class="text-4xl font-bold text-gray-900">{{ $blog->title }}</h1>
            <p class="text-sm text-gray-600 mt-2">Diposting oleh {{ $blog->author->name }} |
                {{ $blog->published_at->format('d M Y') }}</p>
        </div>

        @if ($blog->thumbnail)
            <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}"
                class="rounded-lg mb-6 w-full max-h-[450px] object-cover">
        @endif

        <div class="prose max-w-none">
            {!! $blog->content !!}
        </div>

        <div class="mt-8">
            <a href="{{ route('blog.index') }}" class="text-indigo-600 hover:underline">
                ← Kembali ke Daftar Blog
            </a>
        </div>
    </div>
</x-app-layout>
