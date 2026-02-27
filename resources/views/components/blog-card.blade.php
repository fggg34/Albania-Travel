@props(['post'])

@php
    $imageUrl = $post->featured_image
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image)
        : 'https://placehold.co/600x400/e5e7eb/6b7280?text=Blog';
@endphp
<article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    <a href="{{ route('blog.show', $post->slug) }}" class="block">
        <div class="aspect-[16/10] overflow-hidden bg-gray-200">
            <img src="{{ $imageUrl }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
        </div>
        <div class="p-4">
            <p class="text-xs text-gray-500">{{ $post->published_at?->format('d M Y') }}</p>
            <h3 class="mt-1 text-lg font-semibold text-gray-900 line-clamp-2">{{ $post->title }}</h3>
            <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ Str::limit(strip_tags($post->excerpt ?? ''), 120) }}</p>
        </div>
    </a>
</article>
