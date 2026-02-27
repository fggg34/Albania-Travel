@extends('layouts.site')

@section('title', $highlight->title . ' - ' . $city->name . ' - ' . config('app.name'))
@section('description', Str::limit(strip_tags($highlight->description), 160))

@push('meta')
<meta property="og:title" content="{{ $highlight->title }} - {{ $city->name }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($highlight->description), 200) }}">
<meta property="og:url" content="{{ request()->url() }}">
@if($highlight->image_url)
<meta property="og:image" content="{{ request()->getSchemeAndHttpHost() . $highlight->image_url }}">
@endif
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center gap-1.5 flex-wrap">
            <li><a href="{{ route('home') }}" class="text-amber-600 hover:text-amber-700 transition">Home</a></li>
            <li aria-hidden="true"><span>&gt;</span></li>
            <li><a href="{{ route('cities.index') }}" class="text-amber-600 hover:text-amber-700 transition">Cities</a></li>
            <li aria-hidden="true"><span>&gt;</span></li>
            <li><a href="{{ route('cities.show', $city->slug) }}" class="text-amber-600 hover:text-amber-700 transition">{{ $city->name }}</a></li>
            <li aria-hidden="true"><span>&gt;</span></li>
            <li class="text-gray-700" aria-current="page">{{ $highlight->title }}</li>
        </ol>
    </nav>

    {{-- Title + description (65%) | Image (35%) --}}
    <div class="grid grid-cols-1 lg:grid-cols-[65fr_35fr] gap-8 lg:gap-10 mb-12">
        <div class="order-2 lg:order-1">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">{{ $highlight->title }}</h1>
            <p class="text-sm text-gray-500 mb-4">{{ $city->name }}, {{ $city->country }}</p>
            @if($highlight->description)
                <div class="prose prose-gray max-w-none text-gray-600">
                    {!! $highlight->description !!}
                </div>
            @else
                <p class="text-gray-600">No description available.</p>
            @endif
        </div>
        <div class="order-1 lg:order-2">
            @if($highlight->image_url)
                <div class="rounded-xl overflow-hidden bg-gray-200 aspect-[4/3] lg:aspect-auto lg:min-h-[280px]">
                    <img src="{{ $highlight->image_url }}" alt="{{ $highlight->title }}" class="w-full h-full object-cover">
                </div>
            @else
                <div class="rounded-xl bg-gray-200 aspect-[4/3] lg:min-h-[280px] flex items-center justify-center text-gray-400">No image</div>
            @endif
        </div>
    </div>

    {{-- Other places to visit in this city --}}
    @if($otherHighlights->isNotEmpty())
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-4">Other places to visit in {{ $city->name }}</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($otherHighlights as $other)
                    <a href="{{ route('cities.highlights.show', [$city->slug, $other->slug]) }}" class="group block text-center">
                        <div class="w-24 h-24 sm:w-28 sm:h-28 mx-auto rounded-full overflow-hidden bg-gray-200 border-2 border-white shadow-md group-hover:border-amber-400 transition">
                            @if($other->image_url)
                                <img src="{{ $other->image_url }}" alt="{{ $other->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No image</div>
                            @endif
                        </div>
                        <p class="mt-2 text-sm font-medium text-gray-900 group-hover:text-amber-600 transition line-clamp-2">{{ $other->title }}</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
