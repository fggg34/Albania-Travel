@extends('layouts.site')

@section('title', \App\Models\Setting::get('site_name', config('app.name')) . ' - ' . \App\Models\Setting::get('site_tagline', 'Discover your next adventure'))
@section('description', \App\Models\Setting::get('hero_subtitle', 'Explore stunning destinations with expert guides.'))

@section('hero')
@php
    $hero = $hero ?? null;
    $heroTitle = $hero?->title ?? \App\Models\Setting::get('hero_title', 'Adventure Simplified');
    $heroSubtitle = $hero?->subtitle ?? \App\Models\Setting::get('hero_subtitle', 'Guides, local transport, accommodation, and like-minded travelers are always included. Book securely & flexibly.');
    $bgImage = $hero && $hero->banner_type === 'image' && $hero->banner_image ? $hero->banner_image_url : 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1920';
    $bgVideo = $hero && $hero->banner_type === 'video' && $hero->banner_video ? $hero->banner_video_url : null;
@endphp
<section class="relative w-full rounded-b-3xl md:rounded-b-[2rem] min-h-[420px] md:min-h-[520px] flex flex-col justify-center items-center text-white" style="min-height: 600px;">
    @if($bgVideo)
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ $bgVideo }}" type="video/mp4">
        </video>
    @else
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $bgImage }}');"></div>
    @endif
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative z-10 w-full max-w-5xl mx-auto px-4 text-center pt-12 pb-8 flex flex-col items-center flex-1 justify-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-8 drop-shadow-sm">{{ $heroTitle }}</h1>
        <p class="text-lg md:text-xl text-white/95 max-w-5xl mb-8 drop-shadow-sm">{{ $heroSubtitle }}</p>
        <div class="w-full mt-4 pb-4">
            <x-hero-search-form :action="route('tours.index')" :cities="$cities ?? collect()" />
        </div>
    </div>
</section>
@endsection

@section('content')
{{-- Featured Tours Slider (4 per view, right arrow) --}}
@if($featuredTours->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" x-data="homeSlider({ fixedSlideBy: 4 })">
    <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-8">
        @if(request()->get('city') && $cityName = $cities->firstWhere('slug', request()->get('city'))?->name)
            Based on your search in {{ $cityName }}
        @else
            Featured Tours
        @endif
    </h2>
    <div class="relative flex items-stretch">
        <div class="flex-1 overflow-x-auto scroll-smooth scrollbar-hide" x-ref="track" style="scrollbar-width: none; -ms-overflow-style: none;">
            <div class="flex gap-5 pb-4" style="scroll-snap-type: x mandatory;" data-slider-gap="20">
                @foreach($featuredTours as $tour)
                    <div class="flex-shrink-0" style="scroll-snap-align: start;">
                        <x-tour-card :tour="$tour" :queryParams="[]" :wishlisted="in_array($tour->id, $wishlistedIds ?? [])" :slider="true" />
                    </div>
                @endforeach
            </div>
        </div>
        <button type="button" @click="scrollNext()" class="flex-shrink-0 w-12 h-12 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center ml-4 hover:bg-sky-200 transition-colors self-center shadow-sm" aria-label="Scroll right">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>
</section>
@endif

{{-- Things to do wherever you're going (6 per view) --}}
@if(isset($destinationCities) && $destinationCities->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" x-data="homeSlider({ fixedSlideBy: 6 })">
    <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-8">Things to do wherever you're going</h2>
    <div class="relative flex items-stretch">
        <div class="flex-1 overflow-x-auto scroll-smooth scrollbar-hide" x-ref="track" style="scrollbar-width: none; -ms-overflow-style: none;">
            <div class="flex gap-5 pb-4" style="scroll-snap-type: x mandatory;" data-slider-gap="20">
                @foreach($destinationCities as $city)
                    <div class="flex-shrink-0" style="scroll-snap-align: start;">
                        <x-destination-card :city="$city" />
                    </div>
                @endforeach
            </div>
        </div>
        <button type="button" @click="scrollNext()" class="flex-shrink-0 w-12 h-12 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center ml-4 hover:bg-sky-200 transition-colors self-center shadow-sm" aria-label="Scroll right">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>
</section>
@endif

<section class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-10">Categories</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($categories as $cat)
                <a href="{{ route('tours.index', ['category' => $cat->slug]) }}" class="block p-6 bg-white rounded-xl shadow hover:shadow-md text-center transition">
                    <h3 class="font-semibold text-gray-900">{{ $cat->name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ Str::limit(strip_tags($cat->description ?? ''), 40) }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-gray-900 text-center mb-10">Why Choose Us</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
        <div class="p-6">
            <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="font-semibold text-gray-900">Easy Booking</h3>
            <p class="text-gray-600 mt-2">Book online in minutes with our simple process.</p>
        </div>
        <div class="p-6">
            <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <h3 class="font-semibold text-gray-900">Trusted Guides</h3>
            <p class="text-gray-600 mt-2">Expert local guides for an authentic experience.</p>
        </div>
        <div class="p-6">
            <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
            <h3 class="font-semibold text-gray-900">Best Value</h3>
            <p class="text-gray-600 mt-2">Competitive prices with no hidden fees.</p>
        </div>
    </div>
</section>

@if($latestPosts->isNotEmpty())
<section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-10">Latest from the Blog</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($latestPosts as $post)
                <x-blog-card :post="$post" />
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <h2 class="text-3xl font-bold text-gray-900 mb-4">Ready to explore?</h2>
    <p class="text-gray-600 mb-6">Browse our tours and find your next adventure.</p>
    <a href="{{ route('tours.index') }}" class="inline-flex items-center px-6 py-3 bg-amber-600 text-white font-medium rounded-lg hover:bg-amber-700">View all tours</a>
</section> -->
@endsection
