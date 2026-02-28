@props(['tour', 'queryParams' => [], 'wishlisted' => false, 'slider' => false])

@php
    $firstImg = $tour->images->first();
    $imageUrl = $firstImg?->url ?? 'https://placehold.co/600x400/e5e7eb/6b7280?text=Tour';
    $rating = $tour->average_rating ?? $tour->approvedReviews->avg('rating');
    $reviewCount = $tour->approvedReviews->count();
    $tourUrl = route('tours.show', $tour->slug);
    if (!empty($queryParams)) {
        $tourUrl .= '?' . http_build_query($queryParams);
    }
    $durationLabel = $tour->duration_days
        ? $tour->duration_days . ' day' . ($tour->duration_days > 1 ? 's' : '')
        : ($tour->duration_hours ? $tour->duration_hours . ' hours' : null);
    $startTimeFormatted = $tour->start_time
        ? \Carbon\Carbon::parse($tour->start_time)->format('g:i A')
        : null;
@endphp
<article
    {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300' . ($slider ? ' flex-shrink-0 w-[300px]' : '')]) }}
    @if($slider) data-slider-card @endif
>
    <a href="{{ $tourUrl }}" class="block">
        <div class="relative aspect-[4/3] overflow-hidden bg-gray-200">
            <img src="{{ $imageUrl }}" alt="{{ $tour->title }}" class="w-full h-full object-cover">
            @auth
                @if($wishlisted)
                    <form method="POST" action="{{ route('wishlist.destroy', $tour) }}" class="absolute top-3 right-3 z-10" onclick="event.stopPropagation()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-9 h-9 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-rose-500 hover:bg-white transition-colors" aria-label="Remove from wishlist">
                            <i class="fa-solid fa-heart"></i>
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('wishlist.store', $tour) }}" class="absolute top-3 right-3 z-10" onclick="event.stopPropagation()">
                        @csrf
                        <button type="submit" class="w-9 h-9 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-gray-600 hover:text-rose-500 hover:bg-white transition-colors" aria-label="Add to wishlist">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    </form>
                @endif
            @endauth
        </div>
        <div class="p-4">
            <h3 class="text-base font-bold text-gray-900 line-clamp-2 leading-snug">{{ $tour->title }}</h3>

            {{-- Tour details: 2x2 grid - Tour starts, Starting time, Duration, Ending place --}}
            <div class="mt-3 grid grid-cols-2 gap-3">
                <div class="flex gap-2">
                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-flag text-slate-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-gray-600">Tour starts</p>
                        <p class="text-xs text-sky-600 truncate" title="{{ $tour->start_location }}">{{ $tour->start_location ?: '—' }}</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                        <i class="fa-regular fa-clock text-slate-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-gray-600">Starting time</p>
                        <p class="text-xs text-sky-600">{{ $startTimeFormatted ?: 'Flexible' }}</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-sun text-slate-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-gray-600">Duration</p>
                        <p class="text-xs text-sky-600">{{ $durationLabel ?: '—' }}</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-suitcase text-slate-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-gray-600">Ending place</p>
                        <p class="text-xs text-sky-600 truncate" title="{{ $tour->end_location }}">{{ $tour->end_location ?: ($tour->start_location ?: '—') }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-3 flex items-center justify-between gap-2">
                @if($rating || $reviewCount)
                    <p class="flex items-center gap-1 text-sm text-gray-600">
                        @if($rating)<x-review-stars :rating="(float) $rating" />@endif
                        <span class="text-gray-500">({{ number_format($reviewCount) }})</span>
                    </p>
                @endif
                <div class="flex items-baseline gap-1 ml-auto">
                    <span class="text-sm text-gray-500">From</span>
                    <span class="text-lg font-bold text-rose-600">€{{ number_format($tour->price ?? 0, 0) }}</span>
                </div>
            </div>
        </div>
    </a>
</article>
