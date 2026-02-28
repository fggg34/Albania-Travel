@props(['post'])

@php
    $imageUrl = $post->featured_image
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image)
        : 'https://placehold.co/600x400/e5e7eb/6b7280?text=Blog';
@endphp

<article class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl hover:border-gray-200 transition-all duration-300 flex flex-col">
    <a href="{{ route('blog.show', $post->slug) }}" class="block">
        <div class="aspect-[16/10] overflow-hidden bg-gray-100">
            <img src="{{ $imageUrl }}" alt="{{ $post->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </div>
    </a>
    <div class="p-6 flex flex-col flex-1">
        {{-- Meta --}}
        <div class="flex items-center gap-3 mb-3">
            @if($post->category)
            <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}"
               class="text-xs font-semibold text-[#0D9488] uppercase tracking-wide hover:underline">
                {{ $post->category->name }}
            </a>
            <span class="text-gray-200">·</span>
            @endif
            <span class="text-xs text-gray-400">{{ $post->published_at?->format('d M Y') }}</span>
        </div>

        {{-- Title --}}
        <a href="{{ route('blog.show', $post->slug) }}" class="block">
            <h3 class="text-base font-bold text-gray-900 leading-snug line-clamp-2 mb-3 group-hover:text-[#0D9488] transition-colors">
                {{ $post->title }}
            </h3>
        </a>

        {{-- Excerpt --}}
        <p class="text-sm text-gray-500 leading-relaxed line-clamp-2 flex-1">
            {{ Str::limit(strip_tags($post->excerpt ?? ''), 120) }}
        </p>

        {{-- Read more --}}
        <a href="{{ route('blog.show', $post->slug) }}"
           class="inline-flex items-center gap-1.5 mt-5 text-sm font-semibold text-[#0D9488] hover:gap-2.5 transition-all">
            Read article <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
    </div>
</article>
