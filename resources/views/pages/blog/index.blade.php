@extends('layouts.site')

@section('title', \App\Models\Setting::get('seo_blog_index_meta_title') ?: 'Blog — ' . $siteName)
@section('description', \App\Models\Setting::get('seo_blog_index_meta_description') ?: 'Travel tips, destination guides and stories from Albania.')

@section('hero')
<section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://albaniatravelbysonilakosta.com/storage/heroes/breadcrumb.jpg');"></div>
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight">Our Blog</h1>
        <p class="mt-3 text-white/75 text-base max-w-xl leading-relaxed">Travel tips, destination guides and tales from the road.</p>
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
                  {{ !request('category') ? 'bg-[#CC1021] text-white border-[#CC1021]' : 'bg-white text-gray-600 border-gray-200 hover:border-[#CC1021] hover:text-[#CC1021]' }}">
            All
        </a>
        @foreach($categories as $c)
        <a href="{{ route('blog.index', ['category' => $c->slug]) }}"
           class="px-5 py-2 rounded-full text-sm font-semibold border transition-all duration-200
                  {{ request('category') === $c->slug ? 'bg-[#CC1021] text-white border-[#CC1021]' : 'bg-white text-gray-600 border-gray-200 hover:border-[#CC1021] hover:text-[#CC1021]' }}">
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
