@extends('layouts.site')

@section('title', $highlight->title . ' - ' . $city->name . ' - ' . $siteName)
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

{{-- ── INTRO ──────────────────────────────────────────────────────────── --}}
<section class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-gray-400 mb-8 flex-wrap">
            <a href="{{ route('home') }}" class="hover:text-[#CC1021] transition">Home</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <a href="{{ route('cities.show', $city->slug) }}" class="hover:text-[#CC1021] transition">{{ $city->name }}</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <span class="text-gray-700 font-medium">{{ $highlight->title }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-start">

            {{-- ── Left: image ─────────────────────────────────────────── --}}
            <div>
                <div class="rounded-2xl overflow-hidden bg-gray-100 aspect-[4/3]">
                    @if($highlight->image_url)
                        <img src="{{ $highlight->image_url }}" alt="{{ $highlight->title }}"
                             class="w-full h-full object-cover" />
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fa-solid fa-mountain-sun text-6xl text-gray-300"></i>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ── Right: info + description ────────────────────────────── --}}
            <div class="flex flex-col gap-5">

                {{-- Location badge --}}
                <div class="inline-flex items-center gap-2 self-start bg-[#CC1021]/8 text-[#CC1021] text-xs font-bold tracking-[0.15em] uppercase px-3 py-1.5 rounded-full border border-[#CC1021]/20">
                    <i class="fa-solid fa-location-dot text-[10px]"></i>
                    {{ $city->name }}@if($city->country), {{ $city->country }}@endif
                </div>

                {{-- Title --}}
                <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 leading-tight">
                    {{ $highlight->title }}
                </h1>

                {{-- Divider --}}
                <div class="w-12 h-1 rounded-full bg-[#CC1021]/40"></div>

                {{-- Description --}}
                @if($highlight->description)
                <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed text-[15px]">
                    {!! $highlight->description !!}
                </div>
                @endif

                {{-- Back to city CTA --}}
                <div class="mt-2">
                    <a href="{{ route('cities.show', $city->slug) }}"
                       class="inline-flex items-center gap-2 text-sm font-semibold text-[#CC1021] group">
                        <span class="w-7 h-7 rounded-full bg-[#CC1021]/10 group-hover:bg-[#CC1021] group-hover:text-white flex items-center justify-center transition-all duration-300">
                            <i class="fa-solid fa-arrow-left text-[10px]"></i>
                        </span>
                        Back to {{ $city->name }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ── OTHER HIGHLIGHTS ────────────────────────────────────────────────── --}}
@if($otherHighlights->isNotEmpty())
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center gap-3 mb-3">
            <div class="w-8 h-px bg-[#CC1021]/70"></div>
            <p class="text-xs font-bold tracking-[0.25em] uppercase text-[#CC1021]">Explore more</p>
        </div>
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-10">
            Other places to visit in {{ $city->name }}
        </h2>

        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-5">
            @foreach($otherHighlights as $other)
            <a href="{{ route('cities.highlights.show', [$city->slug, $other->slug]) }}"
               class="group text-center">
                <div class="relative mx-auto w-full aspect-square rounded-2xl overflow-hidden bg-gray-200 mb-3 shadow-sm group-hover:shadow-md transition-all duration-300 group-hover:-translate-y-1">
                    @if($other->image_url)
                    <img src="{{ $other->image_url }}" alt="{{ $other->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/15 transition-colors duration-300"></div>
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fa-solid fa-mountain-sun text-2xl text-gray-300"></i>
                    </div>
                    @endif
                </div>
                <p class="text-xs sm:text-sm font-semibold text-gray-800 group-hover:text-[#CC1021] transition-colors leading-snug line-clamp-2">
                    {{ $other->title }}
                </p>
            </a>
            @endforeach
        </div>

    </div>
</section>
@endif

@endsection
