@props(['post'])

@php
    $imageUrl = $post->featured_image
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image)
        : null;

    $wordCount = str_word_count(strip_tags($post->content ?? $post->excerpt ?? ''));
    $readTime  = max(1, (int) ceil($wordCount / 200));
@endphp

<article class="group bg-white rounded-2xl overflow-hidden relative flex flex-col border border-gray-100 hover:border-gray-200 hover:shadow-xl transition-all duration-300">

    {{-- Image --}}
    <a href="{{ route('blog.show', $post->slug) }}" class="block relative overflow-hidden bg-gray-100" style="aspect-ratio: 16/9;">
        @if($imageUrl)
        <img src="{{ $imageUrl }}" alt="{{ $post->title }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
        @else
        <div class="w-full h-full bg-gradient-to-br from-[#0f1a1a] to-[#0D9488]/30 flex items-center justify-center">
            <i class="fa-solid fa-newspaper text-white/20 text-4xl"></i>
        </div>
        @endif

        {{-- Category badge over image --}}
        @if($post->category)
        <!-- <div class="absolute top-4 left-4">
            <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}"
               class="inline-flex items-center gap-1.5 bg-[#0f1a1a]/75 backdrop-blur-sm text-teal-400 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider hover:bg-[#0D9488] hover:text-white transition-colors">
                {{ $post->category->name }}
            </a>
        </div> -->
        @endif
    </a>

    {{-- Body --}}
    <div class="flex flex-col flex-1 p-6">

        {{-- Date + read time --}}
        <div class="flex items-center gap-2 text-xs text-gray-400 mb-4">
            <i class="fa-regular fa-calendar text-gray-300"></i>
            <span>{{ $post->published_at?->format('d M Y') }}</span>
            <span class="w-1 h-1 rounded-full bg-gray-200 flex-shrink-0"></span>
            <i class="fa-regular fa-clock text-gray-300"></i>
            <span>{{ $readTime }} min read</span>
        </div>

        {{-- Title --}}
        <a href="{{ route('blog.show', $post->slug) }}" class="block flex-1 mb-4">
            <h3 class="text-base font-bold text-gray-900 leading-snug line-clamp-2 mb-2 group-hover:text-[#0D9488] transition-colors duration-200">
                {{ $post->title }}
            </h3>
            <p class="text-sm text-gray-400 leading-relaxed line-clamp-2">
                {{ Str::limit(strip_tags($post->excerpt ?? ''), 110) }}
            </p>
        </a>

        {{-- Footer --}}
        <div class="flex items-center justify-between pt-5 border-t border-gray-100 mt-auto">
            <a href="{{ route('blog.show', $post->slug) }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-[#0D9488]">
                Read article
                <span class="w-6 h-6 rounded-full bg-[#0D9488]/10 group-hover:bg-[#0D9488] group-hover:text-white flex items-center justify-center transition-all duration-300">
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </span>
            </a>
        </div>
    </div>
</article>
