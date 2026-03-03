@extends('layouts.site')

@section('title', $post->meta_title ?: $post->title . ' — ' . $siteName)
@section('description', $post->meta_description ?: Str::limit(strip_tags($post->excerpt ?? ''), 160))

@push('meta')
<meta property="og:title" content="{{ $post->meta_title ?: $post->title . ' — ' . $siteName }}">
<meta property="og:description" content="{{ $post->meta_description ?: Str::limit(strip_tags($post->excerpt ?? ''), 160) }}">
<meta property="og:url" content="{{ request()->url() }}">
@if($post->featured_image)
<meta property="og:image" content="{{ request()->getSchemeAndHttpHost() . \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image) }}">
@endif
@endpush

@section('content')
<div class="bg-gray-100 -mt-px">

{{-- Featured image --}}
@if($post->featured_image)
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
    <div class="rounded-2xl overflow-hidden shadow-md" style="aspect-ratio: 16/9;">
        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image) }}"
             alt="{{ $post->title }}"
             class="w-full h-full object-cover">
    </div>
</div>
@endif

{{-- White content card --}}
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-2xl px-6 sm:px-10 lg:px-8 py-10 sm:py-8 shadow-sm">
        {{-- Meta --}}
        <div class="flex items-center gap-3 text-sm text-gray-400 mb-5">
            <span>{{ $post->published_at?->format('d M Y') }}</span>
        </div>

        {{-- Title --}}
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">{{ $post->title }}</h1>

        {{-- Divider --}}
        <!-- <div class="mt-8 mb-8 border-t border-gray-100"></div> -->

        {{-- Article body --}}
        <div class="mt-8 prose prose-lg max-w-none
                    prose-headings:font-bold prose-headings:text-gray-900
                    prose-p:text-gray-600 prose-p:leading-relaxed
                    prose-a:text-[#CC1021] prose-a:no-underline hover:prose-a:underline
                    prose-strong:text-gray-900
                    prose-img:rounded-xl prose-img:shadow-md
                    prose-blockquote:border-l-[#CC1021] prose-blockquote:text-gray-500 prose-blockquote:not-italic
                    prose-code:text-[#CC1021] prose-code:bg-brand-50 prose-code:px-1 prose-code:rounded">
            {!! $post->content !!}
        </div>

        {{-- Tags & category --}}
        @if($post->category || $post->tags->isNotEmpty())
        <div class="mt-12 pt-8 border-t border-gray-100 flex flex-wrap gap-4 items-center">
            @if($post->category)
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Category</span>
                <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}"
                   class="px-3 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-semibold hover:bg-brand-100 transition">
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
               class="inline-flex items-center gap-2 text-sm font-semibold text-[#CC1021] hover:gap-3 transition-all">
                <i class="fa-solid fa-arrow-left text-xs"></i> Back to Blog
            </a>
        </div>
    </div>
</div>
</div>

{{-- Related articles --}}
@if($related->isNotEmpty())
<section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
            <div>
                <p class="text-xs font-bold tracking-[0.2em] uppercase text-brand-600 mb-2">Keep Reading</p>
                <h2 class="text-2xl font-bold text-gray-900">Related Articles</h2>
            </div>
            <a href="{{ route('blog.index') }}"
               class="hidden sm:inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-[#CC1021] transition">
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
