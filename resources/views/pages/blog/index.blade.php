@extends('layouts.site')

@section('title', 'Blog — ' . config('app.name'))
@section('description', 'Travel tips, destination guides and stories from Albania.')

@section('hero')
<section class="relative overflow-hidden bg-[#1e1e1e] py-12">
    @include('layouts.partials.hero-decorations')
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-px bg-amber-400/70"></div>
            <p class="text-xs font-bold tracking-[0.25em] uppercase text-amber-400">Stories & Guides</p>
        </div>
        <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4 leading-tight">Our Blog</h1>
        <p class="text-gray-400 text-base max-w-xl leading-relaxed">Travel tips, destination guides and tales from the road.</p>
    </div>
</section>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">

    {{-- Category filter --}}
    @if($categories->isNotEmpty())
    <div class="flex flex-wrap items-center gap-2 mb-10">
        <a href="{{ route('blog.index') }}"
           class="px-5 py-2 rounded-full text-sm font-semibold border transition-all duration-200
                  {{ !request('category') ? 'bg-[#0D9488] text-white border-[#0D9488]' : 'bg-white text-gray-600 border-gray-200 hover:border-[#0D9488] hover:text-[#0D9488]' }}">
            All
        </a>
        @foreach($categories as $c)
        <a href="{{ route('blog.index', ['category' => $c->slug]) }}"
           class="px-5 py-2 rounded-full text-sm font-semibold border transition-all duration-200
                  {{ request('category') === $c->slug ? 'bg-[#0D9488] text-white border-[#0D9488]' : 'bg-white text-gray-600 border-gray-200 hover:border-[#0D9488] hover:text-[#0D9488]' }}">
            {{ $c->name }}
        </a>
        @endforeach
    </div>
    @endif

    {{-- Grid --}}
    @if($posts->isEmpty())
    <div class="text-center py-24">
        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
            <i class="fa-solid fa-newspaper text-gray-300 text-2xl"></i>
        </div>
        <h2 class="text-lg font-semibold text-gray-900 mb-2">No articles yet</h2>
        <p class="text-gray-400 text-sm">Check back soon — we're working on some great stories.</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($posts as $post)
            <x-blog-card :post="$post" />
        @endforeach
    </div>

    <div class="mt-12 flex justify-center">
        {{ $posts->links() }}
    </div>
    @endif

</div>
@endsection
