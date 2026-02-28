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
<section class="relative w-full rounded-b-3xl md:rounded-b-[2rem] min-h-[420px] md:min-h-[520px] flex flex-col justify-center items-center text-white" style="min-height: calc(100vh - 120px);">
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
{{-- Tour Info Points (under hero) --}}
@if(isset($tourInfoPoints) && $tourInfoPoints->isNotEmpty())
<section class="bg-slate-50/80 py-12 md:py-[20px] border-b border-slate-200/60" style="background-color: #F0F6F3;">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-10">
            @foreach($tourInfoPoints as $point)
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-16 h-16 rounded-full bg-white flex items-center justify-center overflow-hidden">
                    @if($point->icon)
                    <img src="{{ $point->icon_url }}" alt="" class="w-full h-full object-contain" />
                    @else
                    <svg class="w-8 h-8 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-lg" style="color: #41235A;">{{ $point->title }}</h3>
                    <p class="text-slate-500 text-sm mt-1 leading-relaxed">{{ $point->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Featured Tours (3-column grid on desktop) --}}
@if($featuredTours->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-8">
        @if(request()->get('city') && $cityName = $cities->firstWhere('slug', request()->get('city'))?->name)
            Based on your search in {{ $cityName }}
        @else
            Featured Tours
        @endif
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($featuredTours->take(3) as $tour)
            <x-tour-card :tour="$tour" :queryParams="[]" :wishlisted="in_array($tour->id, $wishlistedIds ?? [])" :slider="false" />
        @endforeach
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
                <a href="{{ route('tours.index', ['category' => $cat->slug]) }}" class="block bg-white rounded-xl shadow hover:shadow-md text-center transition overflow-hidden">
                    <div class="aspect-[4/3] w-full overflow-hidden bg-gray-100">
                        @if($cat->image_url)
                        <img src="{{ $cat->image_url }}" alt="{{ $cat->name }}" class="w-full h-full object-cover" loading="lazy" />
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <i class="fa-solid fa-compass text-4xl"></i>
                        </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="font-semibold text-gray-900">{{ $cat->name }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit(strip_tags($cat->description ?? ''), 40) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- @if(isset($homepageAbout) && $homepageAbout && $homepageAbout->is_active)
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">
            {{-- Left column (50%): title + description --}}
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ $homepageAbout->title }}</h2>
                <div class="text-gray-600 leading-relaxed prose prose-lg max-w-none">
                    {!! nl2br(e($homepageAbout->description ?? '')) !!}
                </div>
            </div>
            {{-- Right column (50%): 2 sub-columns - left: main image, right: highlight box + image --}}
            <div class="grid grid-cols-2 gap-4" style="grid-template-rows: auto 1fr;">
                {{-- Main image: spans both rows --}}
                <div class="row-span-2 min-h-[300px]">
                    @if($homepageAbout->image_1)
                    <img src="{{ $homepageAbout->image_1_url }}" alt="" class="w-full h-full min-h-[300px] object-cover rounded-xl" />
                    @else
                    <div class="w-full h-full min-h-[300px] bg-gray-200 rounded-xl flex items-center justify-center text-gray-400">Main image</div>
                    @endif
                </div>
                {{-- Highlight box --}}
                <div>
                    @if($homepageAbout->highlight_text || $homepageAbout->highlight_subtext)
                    <div class="bg-gray-900 text-white rounded-xl px-6 py-8 text-center">
                        <span class="text-4xl font-bold block">{{ $homepageAbout->highlight_text }}</span>
                        <span class="text-4xl font-bold block">{{ $homepageAbout->highlight_subtext }}</span>
                    </div>
                    @endif
                </div>
                {{-- Secondary image --}}
                <div class="self-end">
                    @if($homepageAbout->image_2)
                    <img src="{{ $homepageAbout->image_2_url }}" alt="" class="w-full h-40 sm:h-48 object-cover rounded-xl" />
                    @else
                    <div class="w-full h-40 sm:h-48 bg-gray-200 rounded-xl flex items-center justify-center text-gray-400">Image 2</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif -->

{{-- Why Choose Us --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-end mb-16">
            <div>
                <p class="text-xs font-bold tracking-[0.2em] uppercase text-teal-600 mb-3">Why Travel With Us</p>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">The Albania experience you won't find anywhere else</h2>
            </div>
            <p class="text-gray-500 leading-relaxed lg:text-right">
                We're not a marketplace — we're a local team that lives and breathes Albania. Every tour is designed, guided, and run by people who call this place home.
            </p>
        </div>

        {{-- Feature cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['fa-solid fa-map-location-dot', 'teal',   'Local Guides Only',     'Every guide was born and raised here. They know the shortcuts, the stories, and the spots no app can find.'],
                ['fa-solid fa-people-group',     'violet', 'Small Groups',          'We cap group sizes so every trip feels personal — never rushed, never crowded, always memorable.'],
                ['fa-solid fa-circle-check',     'emerald','Transparent Pricing',   'No hidden fees, no surprises at checkout. The price you see is the exact price you pay.'],
                ['fa-solid fa-calendar-check',   'amber',  'Free Cancellation',     'Plans change. Most of our tours allow free cancellation up to 48 hours before departure.'],
            ] as $f)
            <div class="group relative p-7 rounded-2xl border border-gray-100 bg-gray-50 hover:bg-white hover:shadow-lg hover:border-gray-200 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl mb-6 flex items-center justify-center
                    {{ $f[1] === 'teal'   ? 'bg-teal-50'   : '' }}
                    {{ $f[1] === 'violet' ? 'bg-violet-50' : '' }}
                    {{ $f[1] === 'emerald'? 'bg-emerald-50': '' }}
                    {{ $f[1] === 'amber'  ? 'bg-amber-50'  : '' }}">
                    <i class="{{ $f[0] }} text-lg
                        {{ $f[1] === 'teal'   ? 'text-teal-600'   : '' }}
                        {{ $f[1] === 'violet' ? 'text-violet-600' : '' }}
                        {{ $f[1] === 'emerald'? 'text-emerald-600': '' }}
                        {{ $f[1] === 'amber'  ? 'text-amber-600'  : '' }}"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">{{ $f[2] }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $f[3] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Bottom CTA strip --}}
        <div class="mt-14 rounded-2xl bg-[#0D9488] px-10 py-10 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
                <p class="text-white font-bold text-lg">Ready to start your Albanian adventure?</p>
                <p class="text-teal-100 text-sm mt-1">Browse 50+ handcrafted tours — day trips, multi-day, private & group.</p>
            </div>
            <a href="{{ route('tours.index') }}"
               class="flex-shrink-0 px-8 py-3.5 bg-white text-[#0D9488] text-sm font-bold rounded-full hover:bg-teal-50 transition shadow-md whitespace-nowrap">
                View All Tours
            </a>
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
