@extends('layouts.site')

@section('title', $post->meta_title ?: $post->title . ' — ' . config('app.name'))
@section('description', $post->meta_description ?: Str::limit(strip_tags($post->excerpt ?? ''), 160))

@section('hero')
<section class="bg-[#0f1a1a] py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-teal-400 transition">Home</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <a href="{{ route('blog.index') }}" class="hover:text-teal-400 transition">Blog</a>
            @if($post->category)
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}"
               class="hover:text-teal-400 transition">{{ $post->category->name }}</a>
            @endif
        </nav>

        {{-- Category + date --}}
        <div class="flex items-center gap-3 mb-4">
            @if($post->category)
            <span class="text-xs font-bold uppercase tracking-widest text-teal-400">{{ $post->category->name }}</span>
            <span class="text-gray-700">·</span>
            @endif
            <span class="text-xs text-gray-400">{{ $post->published_at?->format('F j, Y') }}</span>
        </div>

        <h1 class="text-3xl sm:text-4xl font-bold text-white leading-tight">{{ $post->title }}</h1>

        @if($post->excerpt)
        <p class="mt-4 text-gray-400 text-base leading-relaxed">{{ Str::limit(strip_tags($post->excerpt), 200) }}</p>
        @endif
    </div>
</section>
@endsection

@section('content')

{{-- Featured image --}}
@if($post->featured_image)
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-0 pt-10">
    <div class="w-full rounded-2xl overflow-hidden aspect-[16/7] bg-gray-100">
        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image) }}"
             alt="{{ $post->title }}"
             class="w-full h-full object-cover">
    </div>
</div>
@endif

{{-- Article body --}}
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="prose prose-lg max-w-none
                prose-headings:font-bold prose-headings:text-gray-900
                prose-p:text-gray-600 prose-p:leading-relaxed
                prose-a:text-[#0D9488] prose-a:no-underline hover:prose-a:underline
                prose-strong:text-gray-900
                prose-img:rounded-xl prose-img:shadow-md
                prose-blockquote:border-l-[#0D9488] prose-blockquote:text-gray-500 prose-blockquote:not-italic
                prose-code:text-[#0D9488] prose-code:bg-teal-50 prose-code:px-1 prose-code:rounded">
        {!! $post->content !!}
    </div>

    {{-- Tags & category --}}
    @if($post->category || $post->tags->isNotEmpty())
    <div class="mt-12 pt-8 border-t border-gray-100 flex flex-wrap gap-4 items-center">
        @if($post->category)
        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Category</span>
            <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}"
               class="px-3 py-1 rounded-full bg-teal-50 text-teal-700 text-xs font-semibold hover:bg-teal-100 transition">
                {{ $post->category->name }}
            </a>
        </div>
        @endif
        @if($post->tags->isNotEmpty())
        <div class="flex items-center gap-2 flex-wrap">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Tags</span>
            @foreach($post->tags as $tag)
            <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}"
               class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold hover:bg-gray-200 transition">
                {{ $tag->name }}
            </a>
            @endforeach
        </div>
        @endif
    </div>
    @endif

    {{-- Back to blog --}}
    <div class="mt-10">
        <a href="{{ route('blog.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-[#0D9488] hover:gap-3 transition-all">
            <i class="fa-solid fa-arrow-left text-xs"></i> Back to Blog
        </a>
    </div>
</div>

{{-- Related articles --}}
@if($related->isNotEmpty())
<section class="bg-gray-50 border-t border-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
            <div>
                <p class="text-xs font-bold tracking-[0.2em] uppercase text-teal-600 mb-2">Keep Reading</p>
                <h2 class="text-2xl font-bold text-gray-900">Related Articles</h2>
            </div>
            <a href="{{ route('blog.index') }}"
               class="hidden sm:inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-[#0D9488] transition">
                All articles <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($related as $p)
                <x-blog-card :post="$p" />
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
