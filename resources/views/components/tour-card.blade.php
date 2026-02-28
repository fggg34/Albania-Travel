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
        : ($tour->duration_hours ? $tour->duration_hours . ' hrs' : null);
    $startTimeFormatted = $tour->start_time
        ? \Carbon\Carbon::parse($tour->start_time)->format('g:i A')
        : null;
@endphp

<article {{ $attributes->merge(['class' => 'group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl hover:border-gray-200 transition-all duration-300' . ($slider ? ' flex-shrink-0 w-[300px]' : '')]) }}
         @if($slider) data-slider-card @endif>
    <a href="{{ $tourUrl }}" class="block">

        {{-- Image --}}
        <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
            <img src="{{ $imageUrl }}" alt="{{ $tour->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

            {{-- Duration badge --}}
            @if($durationLabel)
            <span class="absolute bottom-3 left-3 px-2.5 py-1 bg-black/60 backdrop-blur-sm text-white text-xs font-semibold rounded-full">
                <i class="fa-regular fa-clock mr-1"></i>{{ $durationLabel }}
            </span>
            @endif

            {{-- Wishlist --}}
            @auth
                @if($wishlisted)
                    <form method="POST" action="{{ route('wishlist.destroy', $tour) }}"
                          class="absolute top-3 right-3 z-10" onclick="event.stopPropagation()">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-rose-500 hover:bg-white transition shadow-sm"
                                aria-label="Remove from wishlist">
                            <i class="fa-solid fa-heart text-xs"></i>
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('wishlist.store', $tour) }}"
                          class="absolute top-3 right-3 z-10" onclick="event.stopPropagation()">
                        @csrf
                        <button type="submit"
                                class="w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-gray-400 hover:text-rose-500 hover:bg-white transition shadow-sm"
                                aria-label="Add to wishlist">
                            <i class="fa-regular fa-heart text-xs"></i>
                        </button>
                    </form>
                @endif
            @endauth
        </div>

        {{-- Body --}}
        <div class="p-5">

            {{-- Location --}}
            @if($tour->start_location)
            <p class="text-xs text-gray-400 mb-2 flex items-center gap-1.5 truncate">
                <i class="fa-solid fa-location-dot text-[#0D9488] text-[10px]"></i>
                {{ $tour->start_location }}
            </p>
            @endif

            {{-- Title --}}
            <h3 class="text-base font-bold text-gray-900 leading-snug line-clamp-2 mb-4">{{ $tour->title }}</h3>

            {{-- Meta row --}}
            <div class="flex items-center gap-3 text-xs text-gray-500 mb-4">
                @if($startTimeFormatted)
                <span class="flex items-center gap-1">
                    <i class="fa-regular fa-clock"></i> {{ $startTimeFormatted }}
                </span>
                @endif
                @if($tour->end_location && $tour->end_location !== $tour->start_location)
                <span class="flex items-center gap-1 truncate">
                    <i class="fa-solid fa-flag-checkered"></i>
                    <span class="truncate">{{ $tour->end_location }}</span>
                </span>
                @endif
            </div>

            {{-- Footer: rating + price --}}
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <div>
                    @if($rating)
                    <div class="flex items-center gap-1">
                        <x-review-stars :rating="(float) $rating" />
                        @if($reviewCount)
                        <span class="text-xs text-gray-400 ml-0.5">({{ $reviewCount }})</span>
                        @endif
                    </div>
                    @else
                    <span class="text-xs text-gray-400">No reviews yet</span>
                    @endif
                </div>
                <div class="text-right">
                    <span class="text-xs text-gray-400">From</span>
                    <span class="block text-lg font-bold text-[#0D9488] leading-tight">€{{ number_format($tour->price ?? 0, 0) }}</span>
                </div>
            </div>

        </div>
    </a>
</article>
