@extends('layouts.site')

@section('title', 'Our Tours — ' . config('app.name'))
@section('description', 'Browse our handcrafted Albania tours and find your perfect adventure.')

@section('hero')
<section class="bg-[#0f1a1a] py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs font-bold tracking-[0.2em] uppercase text-teal-400 mb-3">Explore Albania</p>
        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">All Tours</h1>
        <p class="text-gray-400 text-sm">{{ $tours->total() }} tour{{ $tours->total() !== 1 ? 's' : '' }} available</p>
    </div>
</section>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Filter bar --}}
    <form method="GET" action="{{ route('tours.index') }}"
          class="bg-white border border-gray-100 rounded-2xl shadow-sm px-6 py-5 mb-10"
          x-data="searchSidebarDate(@js(request('date')))">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 items-end">

            {{-- Search --}}
            <div class="col-span-2 sm:col-span-3 lg:col-span-2">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Search</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Tour name…"
                       class="w-full rounded-xl border-gray-200 text-sm focus:border-teal-500 focus:ring-teal-500">
            </div>

            {{-- City --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">City</label>
                <select name="city" class="w-full rounded-xl border-gray-200 text-sm focus:border-teal-500 focus:ring-teal-500">
                    <option value="">All cities</option>
                    @foreach($cities ?? [] as $city)
                        <option value="{{ $city->slug }}" {{ request('city') === $city->slug ? 'selected' : '' }}>{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Category --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Category</label>
                <select name="category" class="w-full rounded-xl border-gray-200 text-sm focus:border-teal-500 focus:ring-teal-500">
                    <option value="">All</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->slug }}" {{ request('category') === $c->slug ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Sort --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Sort by</label>
                <select name="sort" class="w-full rounded-xl border-gray-200 text-sm focus:border-teal-500 focus:ring-teal-500">
                    <option value="newest"     {{ request('sort') === 'newest'     ? 'selected' : '' }}>Newest</option>
                    <option value="price_low"  {{ request('sort') === 'price_low'  ? 'selected' : '' }}>Price: Low → High</option>
                    <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High → Low</option>
                    <option value="popular"    {{ request('sort') === 'popular'    ? 'selected' : '' }}>Popular</option>
                </select>
            </div>

            {{-- Submit --}}
            <div class="flex gap-2">
                <button type="submit"
                        class="flex-1 py-2.5 bg-[#0D9488] text-white text-sm font-semibold rounded-xl hover:bg-teal-400 transition">
                    Filter
                </button>
                @if(request()->hasAny(['q','city','category','sort','date','adults']))
                <a href="{{ route('tours.index') }}"
                   class="px-3 py-2.5 border border-gray-200 text-gray-500 text-sm rounded-xl hover:bg-gray-50 transition" title="Clear filters">
                    <i class="fa-solid fa-xmark"></i>
                </a>
                @endif
            </div>

        </div>

        {{-- Active filter pills --}}
        @if(request()->hasAny(['q','city','category','sort','date']))
        <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-100">
            @if(request('q'))
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-50 text-teal-700 text-xs font-medium">
                    Search: {{ request('q') }}
                </span>
            @endif
            @if(request('city'))
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-50 text-teal-700 text-xs font-medium">
                    City: {{ $cities->firstWhere('slug', request('city'))?->name ?? request('city') }}
                </span>
            @endif
            @if(request('category'))
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-50 text-teal-700 text-xs font-medium">
                    Category: {{ $categories->firstWhere('slug', request('category'))?->name ?? request('category') }}
                </span>
            @endif
            @if(request('sort') && request('sort') !== 'newest')
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-50 text-teal-700 text-xs font-medium">
                    Sort: {{ ['price_low'=>'Price ↑','price_high'=>'Price ↓','popular'=>'Popular'][request('sort')] ?? request('sort') }}
                </span>
            @endif
        </div>
        @endif
    </form>

    {{-- Grid --}}
    @php
        $searchParams = array_filter([
            'city'   => request('city'),
            'date'   => request('date'),
            'adults' => request('adults'),
        ]);
    @endphp

    @if($tours->isEmpty())
    <div class="text-center py-24">
        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
            <i class="fa-solid fa-compass text-gray-300 text-2xl"></i>
        </div>
        <h2 class="text-lg font-semibold text-gray-900 mb-2">No tours found</h2>
        <p class="text-gray-400 text-sm mb-6">Try adjusting your filters or clearing them to see all available tours.</p>
        <a href="{{ route('tours.index') }}"
           class="inline-block px-6 py-2.5 bg-[#0D9488] text-white text-sm font-semibold rounded-full hover:bg-teal-400 transition">
            Clear Filters
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-7">
        @foreach($tours as $tour)
            <x-tour-card :tour="$tour" :queryParams="$searchParams" :wishlisted="in_array($tour->id, $wishlistedIds ?? [])" />
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-12 flex justify-center">
        {{ $tours->links() }}
    </div>
    @endif

</div>
@endsection
