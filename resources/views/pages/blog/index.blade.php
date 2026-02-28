@extends('layouts.site')

@section('title', 'Blog — ' . config('app.name'))
@section('description', 'Travel tips, destination guides and stories from Albania.')

@section('hero')
<section class="bg-[#0f1a1a] py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs font-bold tracking-[0.2em] uppercase text-teal-400 mb-3">Stories & Guides</p>
        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">Our Blog</h1>
        <p class="text-gray-400 text-sm">Travel tips, destination guides and tales from the road.</p>
    </div>
</section>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Category filter --}}
    @if($categories->isNotEmpty())
    <div class="flex flex-wrap gap-2 mb-10">
        <a href="{{ route('blog.index') }}"
           class="px-4 py-2 rounded-full text-sm font-semibold transition
                  {{ !request('category') ? 'bg-[#0D9488] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            All
        </a>
        @foreach($categories as $c)
        <a href="{{ route('blog.index', ['category' => $c->slug]) }}"
           class="px-4 py-2 rounded-full text-sm font-semibold transition
                  {{ request('category') === $c->slug ? 'bg-[#0D9488] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
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
