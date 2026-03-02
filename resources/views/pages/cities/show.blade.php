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

@section('hero')
{{-- Hero: city image as background, dark overlay, title --}}
<section class="relative w-full flex flex-col justify-end overflow-hidden" style="min-height:420px;">

    {{-- Background image or fallback --}}
    @if($city->city_image_url)
    <div class="absolute inset-0">
        <img src="{{ $city->city_image_url }}" alt="{{ $city->name }}"
             class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>
    </div>
    @else
    <div class="absolute inset-0 bg-[#1e1e1e]">
        @include('layouts.partials.hero-decorations')
    </div>
    @endif

    {{-- Content --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-white/60 mb-4">
            <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <a href="{{ route('tours.index') }}" class="hover:text-white transition">Destinations</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-white/90">{{ $city->name }}</span>
        </div>

        {{-- Eyebrow --}}
        <div class="flex items-center gap-3 mb-3">
            <div class="w-8 h-px bg-amber-400/70"></div>
            <p class="text-xs font-bold tracking-[0.25em] uppercase text-amber-400">
                <i class="fa-solid fa-location-dot mr-1.5"></i>{{ $city->country ?? 'Destination' }}
            </p>
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight">
            {{ $city->name }}
        </h1>

        {{-- Stats row --}}
        <div class="flex flex-wrap items-center gap-5 mt-5">
            @if($city->tours->isNotEmpty())
            <div class="flex items-center gap-2 text-white/80 text-sm">
                <i class="fa-solid fa-map-location-dot text-amber-400"></i>
                <span>{{ $city->tours->count() }} {{ Str::plural('tour', $city->tours->count()) }}</span>
            </div>
            @endif
            @if($city->highlights->isNotEmpty())
            <div class="flex items-center gap-2 text-white/80 text-sm">
                <i class="fa-solid fa-star text-amber-400"></i>
                <span>{{ $city->highlights->count() }} {{ Str::plural('highlight', $city->highlights->count()) }}</span>
            </div>
            @endif
            @if($city->hotels->isNotEmpty())
            <div class="flex items-center gap-2 text-white/80 text-sm">
                <i class="fa-solid fa-hotel text-amber-400"></i>
                <span>{{ $city->hotels->count() }} {{ Str::plural('hotel', $city->hotels->count()) }}</span>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section('content')

{{-- Description + Gallery --}}
@if($city->description || ($city->gallery_urls && count($city->gallery_urls) > 0))
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 items-start">

            {{-- Description --}}
            @if($city->description)
            <div class="{{ ($city->gallery_urls && count($city->gallery_urls) > 0) ? 'lg:col-span-3' : 'lg:col-span-5' }}">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-px bg-[#0D9488]/70"></div>
                    <p class="text-xs font-bold tracking-[0.25em] uppercase text-[#0D9488]">About the destination</p>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6">Discover {{ $city->name }}</h2>
                <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed">
                    {!! $city->description !!}
                </div>
            </div>
            @endif

            {{-- Gallery grid (sidebar style) --}}
            @if($city->gallery_urls && count($city->gallery_urls) > 0)
            <div class="{{ $city->description ? 'lg:col-span-2' : 'lg:col-span-5' }}">
                <div class="grid grid-cols-2 gap-2">
                    @foreach(array_slice($city->gallery_urls, 0, 6) as $i => $url)
                    <a href="{{ $url }}" target="_blank" rel="noopener"
                       class="block overflow-hidden rounded-xl bg-gray-100 {{ $i === 0 ? 'col-span-2 aspect-video' : 'aspect-square' }} group">
                        <img src="{{ $url }}" alt="{{ $city->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</section>
@endif

{{-- Highlights --}}
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

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
            @foreach($city->highlights as $highlight)
            <a href="{{ route('cities.highlights.show', [$city->slug, $highlight->slug]) }}"
               class="group text-center">
                <div class="relative mx-auto w-28 h-28 sm:w-32 sm:h-32 rounded-2xl overflow-hidden bg-gray-200 mb-3 shadow-sm group-hover:shadow-md transition-shadow duration-300">
                    @if($highlight->image_url)
                    <img src="{{ $highlight->image_url }}" alt="{{ $highlight->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
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

{{-- Tours --}}
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
            <a href="{{ route('tours.index', ['city' => $city->slug]) }}"
               class="flex-shrink-0 inline-flex items-center gap-2 text-sm font-semibold text-[#0D9488] group">
                View all
                <span class="w-6 h-6 rounded-full bg-[#0D9488]/10 group-hover:bg-[#0D9488] group-hover:text-white flex items-center justify-center transition-all duration-300">
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($city->tours->take(6) as $tour)
            <x-tour-card :tour="$tour" :queryParams="[]" :wishlisted="false" :slider="false" />
            @endforeach
        </div>

    </div>
</section>
@endif

{{-- Hotels --}}
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

                {{-- Image --}}
                <div class="relative aspect-video overflow-hidden bg-gray-100">
                    @if($hotel->image_url)
                    <img src="{{ $hotel->image_url }}" alt="{{ $hotel->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                        <i class="fa-solid fa-hotel text-4xl text-gray-300"></i>
                    </div>
                    @endif

                    {{-- Stars badge --}}
                    @if($hotel->stars_rating)
                    <div class="absolute top-3 left-3 flex items-center gap-0.5 bg-black/50 backdrop-blur-sm rounded-full px-2.5 py-1">
                        @for($s = 0; $s < (int)$hotel->stars_rating; $s++)
                        <i class="fa-solid fa-star text-amber-400 text-[10px]"></i>
                        @endfor
                    </div>
                    @endif
                </div>

                {{-- Info --}}
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
