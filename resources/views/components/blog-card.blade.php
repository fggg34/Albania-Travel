@props(['post'])

@php
    $imageUrl = $post->featured_image
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image)
        : null;

    $wordCount = str_word_count(strip_tags($post->content ?? $post->excerpt ?? ''));
    $readTime  = max(1, (int) ceil($wordCount / 200));
@endphp

<article class="group flex flex-col bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden">
    <a href="{{ route('blog.show', $post->slug) }}" class="block relative overflow-hidden bg-gray-100" style="aspect-ratio: 16/10;">
        @if($imageUrl)
        <img src="{{ $imageUrl }}" alt="{{ $post->title }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
            <i class="fa-solid fa-newspaper text-gray-300 text-3xl"></i>
        </div>
        @endif
    </a>

    <div class="p-5 flex flex-col flex-1">
        <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
            <span>{{ $readTime }} min read</span>
        </div>

        <a href="{{ route('blog.show', $post->slug) }}" class="block flex-1">
            <h3 class="text-lg font-bold text-gray-900 leading-snug line-clamp-2 group-hover:text-brand-600 transition-colors duration-200">
                {{ $post->title }}
            </h3>
            @if($post->excerpt)
            <p class="text-sm text-gray-500 leading-relaxed line-clamp-2 mt-2">
                {{ Str::limit(strip_tags($post->excerpt), 100) }}
            </p>
            @endif
        </a>

        <a href="{{ route('blog.show', $post->slug) }}"
           class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 mt-4 group-hover:gap-2.5 transition-all duration-200">
            Read more <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>
</article>
