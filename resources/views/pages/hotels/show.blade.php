@extends('layouts.site')

@section('title', $hotel->name . ' - ' . )
@section('description', Str::limit(strip_tags($hotel->description), 160))

@push('meta')
<meta property="og:title" content="{{ $hotel->name }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($hotel->description), 200) }}">
<meta property="og:url" content="{{ request()->url() }}">
@if($hotel->image_url)
<meta property="og:image" content="{{ request()->getSchemeAndHttpHost() . $hotel->image_url }}">
@endif
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Name + rating + reviews above the gallery --}}
    <div class="mb-4">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $hotel->name }}</h1>
        <div class="mt-2 flex flex-wrap items-center gap-3 text-gray-600">
            @if($hotel->stars_rating)
                <span class="flex items-center gap-0.5 text-amber-500" aria-label="{{ $hotel->stars_rating }} stars">
                    @for($i = 1; $i <= 5; $i++)
                        <span>{{ $i <= $hotel->stars_rating ? '★' : '☆' }}</span>
                    @endfor
                </span>
            @endif
            <span class="text-sm">
                @if($hotel->total_reviews > 0)
                    {{ $hotel->total_reviews }} {{ Str::plural('review', $hotel->total_reviews) }}
                @else
                    No reviews yet
                @endif
            </span>
            @if($hotel->city)
                <span class="text-sm">·</span>
                <a href="{{ route('cities.show', $hotel->city->slug) }}" class="text-amber-600 hover:underline text-sm">{{ $hotel->city->name }}, {{ $hotel->city->country }}</a>
            @endif
        </div>
    </div>

    {{-- Gallery: 50/50 layout – left: single image, right: 4 images in 2x2 grid (GLightbox) --}}
    @php
        $allImages = $hotel->getAllImageUrls();
        $hasGallery = count($allImages) > 0;
        $gridImages = array_slice($allImages, 1, 4);
    @endphp
    @if($hasGallery)
        <div class="mb-8 hotel-gallery">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4 overflow-hidden rounded-xl bg-gray-200" style="height: 500px;">
                <a href="{{ $allImages[0] }}" class="glightbox block relative overflow-hidden h-full" data-gallery="hotel-gallery-{{ $hotel->id }}">
                    <img src="{{ $allImages[0] }}" alt="{{ $hotel->name }}" class="absolute inset-0 w-full h-full object-cover cursor-pointer hover:opacity-95 transition-opacity">
                </a>
                <div class="hotel-gallery grid grid-cols-2 grid-rows-2 gap-2 h-full">
                    @for($i = 0; $i < 4; $i++)
                        @if(isset($gridImages[$i]))
                            <a href="{{ $gridImages[$i] }}" class="glightbox block relative overflow-hidden bg-gray-300" data-gallery="hotel-gallery-{{ $hotel->id }}">
                                <img src="{{ $gridImages[$i] }}" alt="{{ $hotel->name }} - {{ $i + 2 }}" class="absolute inset-0 w-full h-full object-cover cursor-pointer hover:opacity-95 transition-opacity" loading="lazy">
                            </a>
                        @else
                            <div class="relative overflow-hidden bg-gray-300"></div>
                        @endif
                    @endfor
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            {{-- About this hotel --}}
            @if($hotel->description)
                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">About this hotel</h2>
                    <div class="prose prose-gray max-w-none text-gray-600">
                        {!! $hotel->description !!}
                    </div>
                </section>
            @endif

            {{-- Map + View in Google Maps --}}
            @if($hotel->map_lat && $hotel->map_lng || $hotel->location)
                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Location</h2>
                    <div class="rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                        @if($hotel->map_lat && $hotel->map_lng)
                            <div class="aspect-video w-full relative">
                                <iframe
                                    title="Map showing hotel location"
                                    src="https://www.google.com/maps?q={{ urlencode((string)$hotel->map_lat . ',' . (string)$hotel->map_lng) }}&z=15&output=embed"
                                    class="absolute inset-0 w-full h-full border-0"
                                    allowfullscreen
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"
                                ></iframe>
                            </div>
                        @else
                            <div class="aspect-video w-full flex items-center justify-center text-gray-500 bg-gray-100">
                                <p class="text-sm">{{ $hotel->location }}</p>
                            </div>
                        @endif
                        @if($hotel->google_maps_url)
                            <div class="p-3 border-t border-gray-200">
                                <a href="{{ $hotel->google_maps_url }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2.5 rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 transition">
                                    View in Google Maps
                                </a>
                            </div>
                        @endif
                    </div>
                    @if($hotel->location)
                        <p class="mt-2 text-sm text-gray-600">{{ $hotel->location }}</p>
                    @endif
                </section>
            @endif

            {{-- Hotel amenities --}}
            @if($hotel->amenities->isNotEmpty())
                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Hotel facilities</h2>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($hotel->amenities as $amenity)
                            <li class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 bg-white">
                                @if($amenity->icon)
                                    <span class="w-6 h-6 flex items-center justify-center text-amber-600 flex-shrink-0"><i class="{{ $amenity->icon }} text-lg" aria-hidden="true"></i></span>
                                @else
                                    <span class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-3.5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </span>
                                @endif
                                <span class="text-gray-700 text-sm">{{ $amenity->name }}</span>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif

            {{-- House rules --}}
            @if($hotel->house_rules && count($hotel->house_rules) > 0)
                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Rules</h2>
                    <ul class="space-y-2">
                        @foreach($hotel->house_rules as $rule)
                            @if(!empty($rule['label']) || !empty($rule['value']))
                                <li class="flex justify-between gap-4 py-2 border-b border-gray-100 last:border-0">
                                    <span class="font-medium text-gray-700">{{ $rule['label'] ?? '—' }}</span>
                                    <span class="text-gray-600">{{ $rule['value'] ?? '—' }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </section>
            @endif
        </div>

        {{-- Sidebar: Contact --}}
        <div class="lg:col-span-1 space-y-6">
            @if($hotel->phone || $hotel->email || $hotel->website)
                <div class="border border-gray-200 rounded-xl p-6 bg-gray-50/50 sticky top-24">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Contact</h2>
                    <ul class="space-y-3 text-sm">
                        @if($hotel->phone)
                            <li>
                                <span class="font-medium text-gray-700">Phone:</span>
                                <a href="tel:{{ $hotel->phone }}" class="text-amber-600 hover:underline ml-1">{{ $hotel->phone }}</a>
                            </li>
                        @endif
                        @if($hotel->email)
                            <li>
                                <span class="font-medium text-gray-700">Email:</span>
                                <a href="mailto:{{ $hotel->email }}" class="text-amber-600 hover:underline ml-1 break-all">{{ $hotel->email }}</a>
                            </li>
                        @endif
                        @if($hotel->website)
                            <li>
                                <span class="font-medium text-gray-700">Website:</span>
                                <a href="{{ $hotel->website }}" target="_blank" rel="noopener" class="text-amber-600 hover:underline ml-1 break-all">{{ Str::limit($hotel->website, 40) }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif

            @if($hotel->city)
                <a href="{{ route('cities.show', $hotel->city->slug) }}" class="block border border-gray-200 rounded-xl p-4 hover:border-amber-500 hover:bg-amber-50/30 transition text-center">
                    <span class="text-gray-600">Explore</span>
                    <span class="font-semibold text-gray-900 block">{{ $hotel->city->name }}</span>
                </a>
            @endif
        </div>
    </div>

    {{-- Related hotels in the same city (last section) --}}
    <section class="mt-12 pt-8 border-t border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900 mb-1">
            @if($hotel->city)
                Related hotels in {{ $hotel->city->name }}
            @else
                Related hotels
            @endif
        </h2>
        <p class="text-sm text-gray-500 mb-4">Other places to stay in the same city.</p>
        @if(isset($otherHotels) && $otherHotels->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($otherHotels as $other)
                    <a href="{{ route('hotels.show', $other->slug) }}" class="group block border border-gray-200 rounded-xl overflow-hidden hover:border-amber-500 hover:shadow-md transition">
                        <div class="aspect-[4/3] bg-gray-200 overflow-hidden">
                            @if($other->image_url)
                                <img src="{{ $other->image_url }}" alt="{{ $other->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">No image</div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 group-hover:text-amber-600 transition">{{ $other->name }}</h3>
                            @if($other->location)
                                <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $other->location }}</p>
                            @endif
                            <div class="mt-2 flex items-center gap-2 text-sm">
                                @if($other->stars_rating)
                                    <span class="text-amber-500">{{ $other->stars_rating }} ★</span>
                                @endif
                                <span class="text-gray-500">
                                    @if($other->total_reviews > 0)
                                        {{ $other->total_reviews }} {{ Str::plural('review', $other->total_reviews) }}
                                    @else
                                        No reviews yet
                                    @endif
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm">No other hotels in this city yet.</p>
            @if($hotel->city)
                <a href="{{ route('cities.show', $hotel->city->slug) }}" class="inline-block mt-2 text-amber-600 hover:underline text-sm">Explore {{ $hotel->city->name }} →</a>
            @endif
        @endif
    </section>
</div>
@endsection

@push('scripts')
@vite(['resources/js/tour-gallery.js'])
@endpush
