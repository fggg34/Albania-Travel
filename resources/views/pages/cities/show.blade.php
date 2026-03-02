@extends('layouts.site')

@section('title', $city->name . ' - ' . config('app.name'))
@section('description', Str::limit(strip_tags($city->description ?? ''), 160))

@push('meta')
<meta property="og:title" content="{{ $city->name }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($city->description ?? ''), 200) }}">
<meta property="og:url" content="{{ request()->url() }}">
@if($city->city_image_url)
<meta property="og:image" content="{{ request()->getSchemeAndHttpHost() . $city->city_image_url }}">
@endif
@endpush

@section('content')

{{-- ── INTRO: split image + info ────────────────────────────────────── --}}
<section class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-gray-400 mb-8">
            <a href="{{ route('home') }}" class="hover:text-[#0D9488] transition">Home</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <a href="{{ route('tours.index') }}" class="hover:text-[#0D9488] transition">Destinations</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <span class="text-gray-700 font-medium">{{ $city->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-start">

            {{-- ── Left: gallery ─────────────────────────────────────── --}}
            <div class="space-y-2.5">
                {{-- Main image --}}
                <div class="relative rounded-2xl overflow-hidden bg-gray-100 aspect-[4/3]">
                    @if($city->city_image_url)
                        <img src="{{ $city->city_image_url }}" alt="{{ $city->name }}"
                             class="w-full h-full object-cover" />
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                            <i class="fa-solid fa-city text-6xl text-gray-300"></i>
                        </div>
                    @endif
                </div>

                {{-- Gallery thumbnails --}}
                @if($city->gallery_urls && count($city->gallery_urls) > 0)
                <div class="grid grid-cols-4 gap-2.5">
                    @foreach(array_slice($city->gallery_urls, 0, 4) as $i => $url)
                    <a href="{{ $url }}" target="_blank" rel="noopener"
                       class="relative block rounded-xl overflow-hidden aspect-square bg-gray-100 group">
                        <img src="{{ $url }}" alt="{{ $city->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-400" />
                        {{-- "more" overlay on last thumb if there are more --}}
                        @if($i === 3 && count($city->gallery_urls) > 4)
                        <div class="absolute inset-0 bg-black/55 flex flex-col items-center justify-center gap-1">
                            <span class="text-white font-bold text-lg leading-none">+{{ count($city->gallery_urls) - 4 }}</span>
                            <span class="text-white/80 text-xs">photos</span>
                        </div>
                        @endif
                    </a>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- ── Right: info + description ─────────────────────────── --}}
            <div class="flex flex-col gap-6">

                {{-- Country badge --}}
                @if($city->country)
                <div class="inline-flex items-center gap-2 self-start bg-[#0D9488]/8 text-[#0D9488] text-xs font-bold tracking-[0.15em] uppercase px-3 py-1.5 rounded-full border border-[#0D9488]/20">
                    <i class="fa-solid fa-location-dot text-[10px]"></i>
                    {{ $city->country }}
                </div>
                @endif

                {{-- Title --}}
                <div>
                    <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 leading-tight">
                        {{ $city->name }}
                    </h1>
                </div>

                {{-- Stats row --}}
                @if($city->tours->isNotEmpty() || $city->highlights->isNotEmpty() || $city->hotels->isNotEmpty())
                <div class="flex flex-wrap gap-4 py-4 border-y border-gray-100">
                    @if($city->tours->isNotEmpty())
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-teal-50 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-map-location-dot text-[#0D9488] text-sm"></i>
                        </div>
                        <div>
                            <div class="text-base font-bold text-gray-900 leading-none">{{ $city->tours->count() }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ Str::plural('Tour', $city->tours->count()) }}</div>
                        </div>
                    </div>
                    @endif
                    @if($city->highlights->isNotEmpty())
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                        </div>
                        <div>
                            <div class="text-base font-bold text-gray-900 leading-none">{{ $city->highlights->count() }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ Str::plural('Highlight', $city->highlights->count()) }}</div>
                        </div>
                    </div>
                    @endif
                    @if($city->hotels->isNotEmpty())
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-hotel text-violet-500 text-sm"></i>
                        </div>
                        <div>
                            <div class="text-base font-bold text-gray-900 leading-none">{{ $city->hotels->count() }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ Str::plural('Hotel', $city->hotels->count()) }}</div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                {{-- Description --}}
                @if($city->description)
                <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed text-[15px]">
                    {!! $city->description !!}
                </div>
                @endif

                {{-- CTA --}}
                @if($city->tours->isNotEmpty())
                <div class="mt-2">
                    <a href="{{ route('tours.index', ['city' => $city->slug]) }}"
                       class="inline-flex items-center gap-2.5 px-6 py-3 bg-[#0D9488] text-white text-sm font-semibold rounded-xl hover:bg-[#0c8276] transition-colors duration-200 shadow-sm">
                        <i class="fa-solid fa-map-location-dot"></i>
                        Explore tours in {{ $city->name }}
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>

{{-- ── HIGHLIGHTS ───────────────────────────────────────────────────── --}}
@if($city->highlights->isNotEmpty())
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center gap-3 mb-3">
            <div class="w-8 h-px bg-[#0D9488]/70"></div>
            <p class="text-xs font-bold tracking-[0.25em] uppercase text-[#0D9488]">Must-see</p>
        </div>
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-10">
            Places to visit in {{ $city->name }}
        </h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-5">
            @foreach($city->highlights as $highlight)
            <a href="{{ route('cities.highlights.show', [$city->slug, $highlight->slug]) }}"
               class="group text-center">
                <div class="relative mx-auto w-28 h-28 sm:w-32 sm:h-32 rounded-2xl overflow-hidden bg-gray-200 mb-3 shadow-sm group-hover:shadow-md transition-all duration-300 group-hover:-translate-y-1">
                    @if($highlight->image_url)
                    <img src="{{ $highlight->image_url }}" alt="{{ $highlight->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/15 transition-colors duration-300"></div>
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fa-solid fa-mountain-sun text-3xl text-gray-300"></i>
                    </div>
                    @endif
                </div>
                <p class="text-sm font-semibold text-gray-800 group-hover:text-[#0D9488] transition-colors leading-snug">
                    {{ $highlight->title }}
                </p>
            </a>
            @endforeach
        </div>

    </div>
</section>
@endif

{{-- ── TOURS ─────────────────────────────────────────────────────────── --}}
@if($city->tours->isNotEmpty())
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-end justify-between gap-4 mb-10">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-px bg-[#0D9488]/70"></div>
                    <p class="text-xs font-bold tracking-[0.25em] uppercase text-[#0D9488]">Explore</p>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">
                    Tours in {{ $city->name }}
                </h2>
            </div>
            @if($city->tours->count() > 3)
            <a href="{{ route('tours.index', ['city' => $city->slug]) }}"
               class="flex-shrink-0 inline-flex items-center gap-2 text-sm font-semibold text-[#0D9488] group">
                View all
                <span class="w-6 h-6 rounded-full bg-[#0D9488]/10 group-hover:bg-[#0D9488] group-hover:text-white flex items-center justify-center transition-all duration-300">
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </span>
            </a>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($city->tours->take(6) as $tour)
            <x-tour-card :tour="$tour" :queryParams="[]" :wishlisted="false" :slider="false" />
            @endforeach
        </div>

    </div>
</section>
@endif

{{-- ── HOTELS ────────────────────────────────────────────────────────── --}}
@if($city->hotels->isNotEmpty())
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center gap-3 mb-3">
            <div class="w-8 h-px bg-[#0D9488]/70"></div>
            <p class="text-xs font-bold tracking-[0.25em] uppercase text-[#0D9488]">Where to stay</p>
        </div>
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-10">
            Hotels in {{ $city->name }}
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($city->hotels as $hotel)
            <a href="{{ route('hotels.show', $hotel->slug) }}"
               class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md border border-gray-100 hover:border-[#0D9488]/30 transition-all duration-300">
                <div class="relative aspect-video overflow-hidden bg-gray-100">
                    @if($hotel->image_url)
                    <img src="{{ $hotel->image_url }}" alt="{{ $hotel->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                        <i class="fa-solid fa-hotel text-4xl text-gray-300"></i>
                    </div>
                    @endif
                    @if($hotel->stars_rating)
                    <div class="absolute top-3 left-3 flex items-center gap-0.5 bg-black/50 backdrop-blur-sm rounded-full px-2.5 py-1">
                        @for($s = 0; $s < (int)$hotel->stars_rating; $s++)
                        <i class="fa-solid fa-star text-amber-400 text-[10px]"></i>
                        @endfor
                    </div>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 group-hover:text-[#0D9488] transition-colors">
                        {{ $hotel->name }}
                    </h3>
                    @if($hotel->location)
                    <p class="text-sm text-gray-500 mt-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-location-dot text-gray-400 text-xs"></i>
                        {{ $hotel->location }}
                    </p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>

    </div>
</section>
@endif

@endsection
