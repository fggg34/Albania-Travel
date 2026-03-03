@extends('layouts.site')

@section('title', \App\Models\Setting::get('seo_tours_index_meta_title') ?: 'Our Tours - ' . $siteName)
@section('description', \App\Models\Setting::get('seo_tours_index_meta_description') ?: 'Browse our handcrafted selection of Albanian tours — day trips, multi-day adventures, private & group experiences.')

@section('hero')
<section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://albaniatravelbysonilakosta.com/storage/heroes/breadcrumb.jpg');"></div>
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight">Our Tours</h1>
        <p class="mt-3 text-white/75 text-base max-w-xl leading-relaxed">Discover handcrafted experiences — from coastal day trips to multi-day mountain adventures, all led by expert local guides.</p>
    </div>
</section>
@endsection

@section('content')
@php
    $hasActiveFilters = request('city') || request('date') || request('adults') || request('category') || request('sort');
    $searchParams = array_filter([
        'city' => request('city'),
        'date' => request('date'),
        'adults' => request('adults'),
    ]);
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Filter bar --}}
    <form method="GET" action="{{ route('tours.index') }}"
          class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-5 mb-10"
          x-data="{ mobileOpen: false }">
        <input type="hidden" name="q" value="{{ request('q') }}">

        {{-- Mobile: toggle button --}}
        <button type="button" @click="mobileOpen = !mobileOpen"
                class="lg:hidden w-full flex items-center justify-between text-sm font-semibold text-gray-700">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-sliders text-brand-600"></i>
                Filters
                @if($hasActiveFilters)
                    <span class="w-2 h-2 rounded-full bg-brand-600"></span>
                @endif
            </span>
            <i class="fa-solid fa-chevron-down text-xs text-gray-400 transition-transform" :class="mobileOpen && 'rotate-180'"></i>
        </button>

        {{-- Filter fields --}}
        <div class="lg:flex lg:items-end lg:gap-4" :class="mobileOpen ? 'mt-4 space-y-4 lg:space-y-0' : 'hidden lg:flex'" x-cloak>
            <div class="flex-1 min-w-0">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">City</label>
                <select name="city"
                        class="w-full rounded-xl border-gray-200 text-sm text-gray-900 shadow-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 py-2.5">
                    <option value="">All cities</option>
                    @foreach($cities ?? [] as $city)
                        <option value="{{ $city->slug }}" {{ request('city') === $city->slug ? 'selected' : '' }}>{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-0" x-data="searchSidebarDate(@js(request('date')))" x-init="init()">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Date</label>
                <input type="text" x-ref="dateInput" name="date" value="{{ request('date') }}" placeholder="Anytime"
                       readonly
                       class="w-full rounded-xl border-gray-200 text-sm text-gray-900 shadow-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 bg-white cursor-pointer py-2.5">
            </div>

            <div class="flex-1 min-w-0 max-w-[120px]">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Adults</label>
                <input type="number" name="adults" min="1" value="{{ max(1, (int) request('adults', 2)) }}"
                       class="w-full rounded-xl border-gray-200 text-sm text-gray-900 shadow-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 py-2.5">
            </div>

            <div class="flex-1 min-w-0">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Category</label>
                <select name="category"
                        class="w-full rounded-xl border-gray-200 text-sm text-gray-900 shadow-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 py-2.5">
                    <option value="">All categories</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->slug }}" {{ request('category') === $c->slug ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-0">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Sort by</label>
                <select name="sort"
                        class="w-full rounded-xl border-gray-200 text-sm text-gray-900 shadow-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 py-2.5">
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest first</option>
                    <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low → High</option>
                    <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High → Low</option>
                    <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most popular</option>
                </select>
            </div>

            <div class="flex items-end gap-2 flex-shrink-0">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 transition shadow-sm">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    Search
                </button>
                @if($hasActiveFilters)
                    <a href="{{ route('tours.index') }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700 rounded-xl border border-gray-200 hover:bg-gray-50 transition">
                        <i class="fa-solid fa-xmark text-xs"></i>
                        Clear
                    </a>
                @endif
            </div>
        </div>
    </form>

    {{-- Results header --}}
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gray-500">
            @if($tours->total() > 0)
                Showing <span class="font-semibold text-gray-900">{{ $tours->firstItem() }}–{{ $tours->lastItem() }}</span> of <span class="font-semibold text-gray-900">{{ $tours->total() }}</span> tours
            @else
                No tours found
            @endif
        </p>
        @if($hasActiveFilters)
            <div class="hidden sm:flex items-center gap-2 flex-wrap">
                @if(request('city'))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-semibold">
                        <i class="fa-solid fa-location-dot text-[10px]"></i>
                        {{ $cities->firstWhere('slug', request('city'))?->name ?? request('city') }}
                    </span>
                @endif
                @if(request('category'))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-semibold">
                        <i class="fa-solid fa-tag text-[10px]"></i>
                        {{ $categories->firstWhere('slug', request('category'))?->name ?? request('category') }}
                    </span>
                @endif
                @if(request('date'))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-semibold">
                        <i class="fa-regular fa-calendar text-[10px]"></i>
                        {{ request('date') }}
                    </span>
                @endif
            </div>
        @endif
    </div>

    {{-- Tour grid --}}
    @if($tours->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            @foreach($tours as $tour)
                <x-tour-card :tour="$tour" :queryParams="$searchParams" :wishlisted="in_array($tour->id, $wishlistedIds ?? [])" />
            @endforeach
        </div>

        @if($tours->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $tours->withQueryString()->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-24">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                <i class="fa-solid fa-compass text-gray-300 text-2xl"></i>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 mb-2">No tours found</h2>
            <p class="text-gray-400 text-sm mb-6">Try adjusting your filters or browse all our tours.</p>
            @if($hasActiveFilters)
                <a href="{{ route('tours.index') }}"
                   class="inline-flex items-center gap-2 px-6 py-2.5 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 transition">
                    <i class="fa-solid fa-arrow-rotate-left text-xs"></i>
                    View all tours
                </a>
            @endif
        </div>
    @endif

</div>
@endsection
