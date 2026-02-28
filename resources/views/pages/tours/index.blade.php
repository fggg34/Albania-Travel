@extends('layouts.site')

@section('title', 'Tours - ' . config('app.name'))
@section('description', 'Browse our selection of tours and book your next adventure.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Tours</h1>

    <div class="flex flex-col lg:flex-row gap-8">
        <aside class="lg:w-64 shrink-0">
            <form method="GET" action="{{ route('tours.index') }}" class="space-y-4 bg-white p-4 rounded-xl shadow">
                <input type="hidden" name="q" value="{{ request('q') }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <select name="city" class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        <option value="">All cities</option>
                        @foreach($cities ?? [] as $city)
                            <option value="{{ $city->slug }}" {{ request('city') === $city->slug ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div x-data="searchSidebarDate(@js(request('date')))" x-init="init()">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="text" x-ref="dateInput" name="date" value="{{ request('date') }}" placeholder="Select date" readonly class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 bg-white cursor-pointer">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Adults</label>
                    <input type="number" name="adults" min="1" value="{{ max(1, (int) request('adults', 2)) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        <option value="">All</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->slug }}" {{ request('category') === $c->slug ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort</label>
                    <select name="sort" class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Popular</option>
                    </select>
                </div>
                <button type="submit" class="w-full py-2 bg-amber-600 text-white text-sm font-medium rounded-md hover:bg-amber-700">Apply filters</button>
            </form>
        </aside>

        <div class="flex-1">
            @php
                $searchParams = array_filter([
                    'city' => request('city'),
                    'date' => request('date'),
                    'adults' => request('adults'),
                ]);
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($tours as $tour)
                    <x-tour-card :tour="$tour" :queryParams="$searchParams" :wishlisted="in_array($tour->id, $wishlistedIds ?? [])" />
                @empty
                    <p class="col-span-full text-gray-500 text-center py-12">No tours found. Try adjusting your filters.</p>
                @endforelse
            </div>
            <div class="mt-8">
                {{ $tours->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
