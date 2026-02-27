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

@push('styles')
<style>
.hide-scrollbar::-webkit-scrollbar { display: none; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            @if($city->city_image_url)
                <div class="aspect-video rounded-xl overflow-hidden bg-gray-200">
                    <img src="{{ $city->city_image_url }}" alt="{{ $city->name }}" class="w-full h-full object-cover">
                </div>
            @endif

            @if($city->gallery_urls && count($city->gallery_urls) > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 sm:gap-3">
                    @foreach($city->gallery_urls as $url)
                        <a href="{{ $url }}" target="_blank" rel="noopener" class="block aspect-[4/3] rounded-lg overflow-hidden bg-gray-200 ring-1 ring-gray-200 hover:ring-amber-400 transition">
                            <img src="{{ $url }}" alt="{{ $city->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        </a>
                    @endforeach
                </div>
            @endif

            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $city->name }}</h1>
                <p class="mt-1 text-gray-600">{{ $city->country }}</p>
            </div>

            @if($city->description)
                <div class="prose max-w-none">
                    {!! $city->description !!}
                </div>
            @endif

            @if($city->highlights->isNotEmpty())
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 text-center">Places to visit in {{ $city->name }}</h2>
                    <div class="relative" x-data="{ index: 0, total: {{ $city->highlights->count() }} }">
                        <div class="flex overflow-x-auto gap-6 pb-4 snap-x snap-mandatory scroll-smooth hide-scrollbar" x-ref="carousel" style="scrollbar-width: none; -ms-overflow-style: none;">
                            @foreach($city->highlights as $highlight)
                                <a href="{{ route('cities.highlights.show', [$city->slug, $highlight->slug]) }}" class="flex-shrink-0 w-[180px] snap-center text-center block group" style="scroll-snap-align: center;">
                                    <div class="w-32 h-32 mx-auto rounded-full overflow-hidden bg-gray-200 border-4 border-white shadow-lg group-hover:border-amber-400 transition">
                                        @if($highlight->image_url)
                                            <img src="{{ $highlight->image_url }}" alt="{{ $highlight->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">No image</div>
                                        @endif
                                    </div>
                                    <p class="mt-3 text-sm font-medium text-gray-900 group-hover:text-amber-600 transition">{{ $highlight->title }}</p>
                                </a>
                            @endforeach
                        </div>
                        <button type="button" @click="$refs.carousel.scrollBy({ left: -200, behavior: 'smooth' })" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2 w-10 h-10 rounded-full bg-white shadow-md border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 transition z-10" aria-label="Previous">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button type="button" @click="$refs.carousel.scrollBy({ left: 200, behavior: 'smooth' })" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 w-10 h-10 rounded-full bg-white shadow-md border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 transition z-10" aria-label="Next">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
            @endif

            @if($city->tours->isNotEmpty())
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Tours</h2>
                    <div class="space-y-3">
                        @foreach($city->tours as $tour)
                            <a href="{{ route('tours.show', $tour->slug) }}" class="block border border-gray-200 rounded-lg p-4 hover:border-amber-500 hover:bg-amber-50/30 transition">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-semibold text-gray-900">{{ $tour->title }}</h3>
                                        @if($tour->short_description)
                                            <p class="text-sm text-gray-500 mt-1">{{ Str::limit($tour->short_description, 100) }}</p>
                                        @endif
                                    </div>
                                    @if($tour->price !== null)
                                        <span class="text-amber-600 font-semibold whitespace-nowrap">€{{ number_format($tour->price, 0) }}</span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($city->hotels->isNotEmpty())
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Hotels</h2>
                    <div class="space-y-3">
                        @foreach($city->hotels as $hotel)
                            <a href="{{ route('hotels.show', $hotel->slug) }}" class="block border border-gray-200 rounded-lg p-4 hover:border-amber-500 hover:bg-amber-50/30 transition">
                                <div class="flex items-start gap-4">
                                    @if($hotel->image_url)
                                        <img src="{{ $hotel->image_url }}" alt="{{ $hotel->name }}" class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                                    @else
                                        <div class="w-20 h-20 bg-gray-200 rounded-lg flex-shrink-0"></div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-semibold text-gray-900">{{ $hotel->name }}</h3>
                                        @if($hotel->stars_rating)
                                            <p class="text-sm text-amber-600 mt-0.5">{{ $hotel->stars_rating }} ★</p>
                                        @endif
                                        @if($hotel->location)
                                            <p class="text-sm text-gray-500 mt-1">{{ $hotel->location }}</p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="lg:col-span-1">
            {{-- Optional sidebar --}}
        </div>
    </div>
</div>
@endsection
