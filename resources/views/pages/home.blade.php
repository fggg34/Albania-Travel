@extends('layouts.site')

@section('title', $siteName . ' - ' . \App\Models\Setting::get('site_tagline', 'Discover your next adventure'))
@section('description', \App\Models\Setting::get('hero_subtitle', 'Explore stunning destinations with expert guides.'))

@section('hero')
@php
    $hero = $hero ?? null;
    $heroTitle = $hero?->title ?? \App\Models\Setting::get('hero_title', 'Adventure Simplified');
    $heroSubtitle = $hero?->subtitle ?? \App\Models\Setting::get('hero_subtitle', 'Guides, local transport, accommodation, and like-minded travelers are always included. Book securely & flexibly.');
    $bgImage = $hero && $hero->banner_type === 'image' && $hero->banner_image ? $hero->banner_image_url : 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1920';
    $bgVideo = $hero && $hero->banner_type === 'video' && $hero->banner_video ? $hero->banner_video_url : null;
@endphp
<section class="relative w-full rounded-b-3xl md:rounded-b-[2rem] flex flex-col justify-center items-center text-white" style="min-height: 70vh;" x-data x-init="if (window.innerWidth >= 768) $el.style.minHeight = 'calc(100vh - 120px)'">
    @if($bgVideo)
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ $bgVideo }}" type="video/mp4">
        </video>
    @else
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $bgImage }}');"></div>
    @endif
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative z-10 w-full max-w-5xl mx-auto px-4 text-center pt-12 pb-8 flex flex-col items-center flex-1 justify-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-8 drop-shadow-sm">{{ $heroTitle }}</h1>
        <p class="text-lg md:text-xl text-white/95 max-w-5xl mb-8 drop-shadow-sm">{{ $heroSubtitle }}</p>
        <div class="w-full mt-4 pb-4">
            <x-hero-search-form :action="route('tours.index')" :cities="$cities ?? collect()" />
        </div>
    </div>
</section>
@endsection

@section('content')
{{-- Tour Info Points --}}
@if(isset($tourInfoPoints) && $tourInfoPoints->isNotEmpty())
<section class="border-b border-slate-200/60 py-5" style="background-color: #F0F6F3;">

    {{-- Desktop: auto grid --}}
    <div class="hidden lg:grid grid-cols-2 xl:grid-cols-4 gap-6 px-4 sm:px-6 lg:px-8">
        @foreach($tourInfoPoints as $point)
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-14 h-14 flex items-center justify-center overflow-hidden">
                @if($point->icon)
                <img src="{{ $point->icon_url }}" alt="" class="w-full h-full object-contain" />
                @else
                <svg class="w-8 h-8 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-base" style="color:#41235A;">{{ $point->title }}</h3>
                <p class="text-slate-500 text-sm mt-1 leading-relaxed">{{ $point->description }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Mobile/tablet: drag slider --}}
    <div class="lg:hidden relative" x-data="dragSlider()">
        {{-- Arrows: absolute top-right --}}
        <div class="pl-4 sm:pl-6 pt-2">
            <div class="overflow-x-auto scrollbar-hide cursor-grab select-none"
                 x-ref="track"
                 @mousedown="startDrag($event)" @mousemove="onDrag($event)" @mouseup="stopDrag()" @mouseleave="stopDrag()"
                 style="scrollbar-width:none;-ms-overflow-style:none;scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch;touch-action:pan-x;">
                <div class="flex gap-4 pb-1 pr-4 sm:pr-6">
                    @foreach($tourInfoPoints as $point)
                    <div class="flex-shrink-0 flex items-start gap-4 w-[82vw] sm:w-80" style="scroll-snap-align:start;">
                        <div class="flex-shrink-0 w-14 h-14 flex items-center justify-center overflow-hidden">
                            @if($point->icon)
                            <img src="{{ $point->icon_url }}" alt="" class="w-full h-full object-contain pointer-events-none" />
                            @else
                            <svg class="w-8 h-8 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-base" style="color:#41235A;">{{ $point->title }}</h3>
                            <p class="text-slate-500 text-sm mt-1 leading-relaxed">{{ $point->description }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</section>
@endif

{{-- Featured Tours --}}
@if($featuredTours->isNotEmpty())
<section class="py-16" x-data="dragSlider()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Title row — arrows on both mobile and desktop --}}
        <div class="relative mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-slate-800">
                @if(request()->get('city') && $cityName = $cities->firstWhere('slug', request()->get('city'))?->name)
                    Based on your search in {{ $cityName }}
                @else
                    Featured Tours
                @endif
            </h2>
            <div class="absolute right-0 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
                <button @click="scrollPrev()" class="w-8 h-8 rounded-full border border-gray-200 bg-white text-gray-500 flex items-center justify-center shadow-sm hover:bg-gray-50">
                    <i class="fa-solid fa-chevron-left text-[10px]"></i>
                </button>
                <button @click="scrollNext()" class="w-8 h-8 rounded-full border border-gray-200 bg-white text-gray-500 flex items-center justify-center shadow-sm hover:bg-gray-50">
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </button>
            </div>
        </div>

        {{-- Slider for all screen sizes --}}
        <div class="mt-2">
            <div class="overflow-x-auto scrollbar-hide cursor-grab select-none"
                 x-ref="track"
                 @mousedown="startDrag($event)" @mousemove="onDrag($event)" @mouseup="stopDrag()" @mouseleave="stopDrag()"
                 style="scrollbar-width:none;-ms-overflow-style:none;scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch;touch-action:pan-x;">
                <div class="flex gap-4 pb-2 pr-4 sm:pr-6">
                    @foreach($featuredTours as $tour)
                    <div class="flex-shrink-0 w-[82vw] sm:w-72 lg:w-80" style="scroll-snap-align:start;">
                        <x-tour-card :tour="$tour" :queryParams="[]" :wishlisted="in_array($tour->id, $wishlistedIds ?? [])" :slider="false" />
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Things to do wherever you're going (5 per view) --}}
@if(isset($destinationCities) && $destinationCities->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" x-data="homeSlider({ fixedSlideBy: 5 })">
    <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-8">Things to do wherever you're going</h2>
    <div class="relative flex items-stretch">
        <div class="flex-1 overflow-x-auto scroll-smooth scrollbar-hide" x-ref="track" style="scrollbar-width: none; -ms-overflow-style: none;">
            <div class="flex gap-5 pb-4" style="scroll-snap-type: x mandatory;" data-slider-gap="20">
                @foreach($destinationCities as $city)
                    <div class="flex-shrink-0" style="scroll-snap-align: start;">
                        <x-destination-card :city="$city" />
                    </div>
                @endforeach
            </div>
        </div>
        <button type="button" @click="scrollNext()" class="flex-shrink-0 w-12 h-12 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center ml-4 hover:bg-brand-100 transition-colors self-center shadow-sm" aria-label="Scroll right">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>
</section>
@endif

<section class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-10">Categories</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($categories as $cat)
                <a href="{{ route('tours.index', ['category' => $cat->slug]) }}"
                   class="group relative block rounded-2xl overflow-hidden aspect-[4/3] bg-gray-900 shadow-md hover:shadow-xl transition-all duration-300">

                    {{-- Image --}}
                    @if($cat->image_url)
                    <img src="{{ $cat->image_url }}" alt="{{ $cat->name }}"
                         class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" />
                    @else
                    <div class="absolute inset-0 flex items-center justify-center bg-gray-800">
                        <i class="fa-solid fa-compass text-5xl text-white/20"></i>
                    </div>
                    @endif

                    {{-- Gradient overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent group-hover:from-black/90 transition-all duration-300"></div>

                    {{-- Text --}}
                    <div class="absolute bottom-0 left-0 right-0 p-5">
                        <h3 class="font-bold text-white text-2xl leading-snug">{{ $cat->name }}</h3>
                        @if($cat->description)
                        <p class="text-gray-300 text-base mt-2 leading-relaxed line-clamp-2">
                            {{ Str::limit(strip_tags($cat->description), 70) }}
                        </p>
                        @endif
                        <span class="inline-flex items-center gap-1.5 mt-3 text-sm font-bold text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            Explore <i class="fa-solid fa-arrow-right text-xs"></i>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

@if(isset($homepageAbout) && $homepageAbout && $homepageAbout->is_active)
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">
            {{-- Left column (50%): title + description --}}
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ $homepageAbout->title }}</h2>
                <div class="text-gray-600 leading-relaxed prose prose-lg max-w-none mb-6">
                    {!! nl2br(e($homepageAbout->description ?? '')) !!}
                </div>
                <a href="{{ route('about') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#CC1021] px-5 py-2.5 text-sm font-semibold text-white shadow hover:bg-[#a00d1a] focus:outline-none focus:ring-2 focus:ring-[#CC1021] focus:ring-offset-2">
                    Learn more
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
            {{-- Right column (50%): 2 sub-columns - left: main image, right: highlight box + image --}}
            <div class="grid grid-cols-2 gap-4" style="grid-template-rows: auto 1fr;">
                {{-- Main image: full-width on mobile, spans both rows on desktop --}}
                <div class="col-span-2 lg:col-span-1 lg:row-span-2 min-h-[300px]">
                    @if($homepageAbout->image_1)
                    <img src="{{ $homepageAbout->image_1_url }}" alt="" class="w-full h-full min-h-[300px] object-cover rounded-xl" />
                    @else
                    <div class="w-full h-full min-h-[300px] bg-gray-200 rounded-xl flex items-center justify-center text-gray-400">Main image</div>
                    @endif
                </div>
                {{-- Highlight box --}}
                <div class="col-span-2 lg:col-span-1">
                    @if($homepageAbout->highlight_text || $homepageAbout->highlight_subtext)
                    <div class="bg-gray-900 text-white rounded-xl px-6 py-8 text-center">
                        <span class="text-4xl font-bold block">{{ $homepageAbout->highlight_text }}</span>
                        <span class="text-4xl font-bold block">{{ $homepageAbout->highlight_subtext }}</span>
                    </div>
                    @endif
                </div>
                {{-- Secondary image --}}
                <div class="col-span-2 lg:col-span-1 self-end">
                    @if($homepageAbout->image_2)
                    <img src="{{ $homepageAbout->image_2_url }}" alt="" class="w-full h-40 sm:h-48 object-cover rounded-xl" />
                    @else
                    <div class="w-full h-40 sm:h-48 bg-gray-200 rounded-xl flex items-center justify-center text-gray-400">Image 2</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- {{-- Why Choose Us --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-end mb-16">
            <div>
                <p class="text-xs font-bold tracking-[0.2em] uppercase text-brand-600 mb-3">Why Travel With Us</p>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">The Albania experience you won't find anywhere else</h2>
            </div>
            <p class="text-gray-500 leading-relaxed lg:text-right">
                We're not a marketplace — we're a local team that lives and breathes Albania. Every tour is designed, guided, and run by people who call this place home.
            </p>
        </div>

        {{-- Feature cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['fa-solid fa-map-location-dot', 'teal',   'Local Guides Only',     'Every guide was born and raised here. They know the shortcuts, the stories, and the spots no app can find.'],
                ['fa-solid fa-people-group',     'violet', 'Small Groups',          'We cap group sizes so every trip feels personal — never rushed, never crowded, always memorable.'],
                ['fa-solid fa-circle-check',     'emerald','Transparent Pricing',   'No hidden fees, no surprises at checkout. The price you see is the exact price you pay.'],
                ['fa-solid fa-calendar-check',   'amber',  'Free Cancellation',     'Plans change. Most of our tours allow free cancellation up to 48 hours before departure.'],
            ] as $f)
            <div class="group relative p-7 rounded-2xl border border-gray-100 bg-gray-50 hover:bg-white hover:shadow-lg hover:border-gray-200 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl mb-6 flex items-center justify-center
                    {{ $f[1] === 'teal'   ? 'bg-brand-50'   : '' }}
                    {{ $f[1] === 'violet' ? 'bg-violet-50' : '' }}
                    {{ $f[1] === 'emerald'? 'bg-emerald-50': '' }}
                    {{ $f[1] === 'amber'  ? 'bg-amber-50'  : '' }}">
                    <i class="{{ $f[0] }} text-lg
                        {{ $f[1] === 'teal'   ? 'text-brand-600'   : '' }}
                        {{ $f[1] === 'violet' ? 'text-violet-600' : '' }}
                        {{ $f[1] === 'emerald'? 'text-emerald-600': '' }}
                        {{ $f[1] === 'amber'  ? 'text-amber-600'  : '' }}"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">{{ $f[2] }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $f[3] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Bottom CTA strip --}}
        <div class="mt-14 rounded-2xl bg-[#CC1021] px-10 py-10 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
                <p class="text-white font-bold text-lg">Ready to start your Albanian adventure?</p>
                <p class="text-brand-100 text-sm mt-1">Browse 50+ handcrafted tours — day trips, multi-day, private & group.</p>
            </div>
            <a href="{{ route('tours.index') }}"
               class="flex-shrink-0 px-8 py-3.5 bg-white text-[#CC1021] text-sm font-bold rounded-full hover:bg-brand-50 transition shadow-md whitespace-nowrap">
                View All Tours
            </a>
        </div>

    </div>
</section> -->

@if($featuredReviews->isNotEmpty())
{{-- Testimonials --}}
@php $reviewCount = $featuredReviews->count(); @endphp
<section class="py-24 bg-[#f3f4f6] relative overflow-hidden"
         x-data="testimonialsSlider({{ $reviewCount }})">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
            <div>
                <p class="text-xs font-bold tracking-[0.2em] uppercase text-brand-600 mb-3">Real Travellers</p>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">What our guests say</h2>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3 flex-shrink-0">
                    <div class="flex items-center gap-0.5">
                        @for($i = 0; $i < 5; $i++)<i class="fa-solid fa-star text-amber-400 text-sm"></i>@endfor
                    </div>
                    <span class="text-gray-900 font-bold">{{ number_format($featuredReviews->avg('rating'), 1) }}</span>
                    <span class="text-gray-400 text-sm">· {{ $featuredReviews->count() }} reviews</span>
                </div>
                @if($reviewCount > 3)
                <div class="flex items-center gap-2">
                    <button @click="prev()" class="w-10 h-10 rounded-full border border-gray-200 bg-white hover:bg-brand-50 hover:border-brand-300 text-gray-500 hover:text-brand-600 transition flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </button>
                    <button @click="next()" class="w-10 h-10 rounded-full border border-gray-200 bg-white hover:bg-brand-50 hover:border-brand-300 text-gray-500 hover:text-brand-600 transition flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </button>
                </div>
                @endif
            </div>
        </div>

        {{-- Slider track --}}
        <div class="overflow-hidden">
            <div class="flex transition-transform duration-500 ease-in-out gap-6"
                 :style="`transform: translateX(calc(-${current} * (100% / ${perView} + ${gap}px / ${perView}) - ${current} * ${gap}px / ${perView}))`">
                @foreach($featuredReviews as $review)
                @php
                    $reviewerName = $review->user?->name ?? 'Guest';
                    $initial = mb_strtoupper(mb_substr($reviewerName, 0, 1));
                    $tourTitle = $review->tour?->title ?? '';
                @endphp
                <div class="flex-shrink-0 w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] relative group rounded-3xl p-8 border border-gray-100 bg-white hover:shadow-lg transition-all duration-300 flex flex-col min-h-[260px]">
                    <span class="absolute top-5 right-7 text-6xl font-serif text-brand-600/10 leading-none select-none">"</span>

                    {{-- Tour tag --}}
                    @if($tourTitle)
                    <div class="inline-flex items-center gap-2 bg-brand-50 text-brand-700 text-xs font-semibold px-3 py-1.5 rounded-full mb-5 self-start max-w-full truncate">
                        <i class="fa-solid fa-compass text-[10px] flex-shrink-0"></i>
                        <span class="truncate">{{ Str::limit($tourTitle, 30) }}</span>
                    </div>
                    @endif

                    {{-- Stars --}}
                    <div class="flex items-center gap-0.5 mb-4">
                        @for($i = 0; $i < $review->rating; $i++)
                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                        @endfor
                        @for($i = $review->rating; $i < 5; $i++)
                            <i class="fa-regular fa-star text-gray-200 text-xs"></i>
                        @endfor
                    </div>

                    {{-- Title --}}
                    @if($review->title)
                    <p class="text-gray-900 text-sm font-semibold mb-2">{{ $review->title }}</p>
                    @endif

                    {{-- Comment --}}
                    <p class="text-gray-500 text-sm leading-relaxed flex-1 mb-6">{{ Str::limit($review->comment, 180) }}</p>

                    {{-- Reviewer --}}
                    <div class="flex items-center gap-3 mt-auto pt-5 border-t border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-600 to-brand-700 flex items-center justify-center text-white text-sm font-bold flex-shrink-0 shadow-md">
                            {{ $initial }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-gray-900 text-sm font-semibold truncate">{{ $reviewerName }}</p>
                            <p class="text-gray-400 text-xs">{{ $review->created_at->format('M Y') }}</p>
                        </div>
                        <div class="ml-auto w-7 h-7 rounded-full bg-green-50 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-check text-green-500 text-[10px]"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Dot indicators --}}
        @if($reviewCount > 3)
        <div class="flex items-center justify-center gap-2 mt-10">
            @for($d = 0; $d < $reviewCount; $d++)
            <button @click="goTo({{ $d }})"
                :class="current === {{ $d }} ? 'bg-brand-600 w-6' : 'bg-gray-300 w-2'"
                class="h-2 rounded-full transition-all duration-300"></button>
            @endfor
        </div>
        @endif

    </div>
</section>

@push('scripts')
<script>
function testimonialsSlider(total) {
    return {
        current: 0,
        total: total,
        perView: 3,
        gap: 24,
        init() {
            this.updatePerView();
            window.addEventListener('resize', () => this.updatePerView());
        },
        updatePerView() {
            if (window.innerWidth < 640) this.perView = 1;
            else if (window.innerWidth < 1024) this.perView = 2;
            else this.perView = 3;
            const max = Math.max(0, this.total - this.perView);
            if (this.current > max) this.current = max;
        },
        next() {
            const max = Math.max(0, this.total - this.perView);
            this.current = this.current >= max ? 0 : this.current + 1;
        },
        prev() {
            const max = Math.max(0, this.total - this.perView);
            this.current = this.current <= 0 ? max : this.current - 1;
        },
        goTo(index) {
            this.current = index;
        }
    }
}
</script>
@endpush
@endif

@if($galleryImages->isNotEmpty())
<section class="bg-white py-20" x-data="gallerySlider({{ $galleryImages->count() }}, {{ $galleryImages->map(fn($img) => ['url' => $img->image_url, 'title' => $img->title ?? '', 'caption' => $img->caption ?? ''])->toJson() }})">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between gap-4 mb-10">
            <div>
                <p class="text-xs font-bold tracking-[0.2em] uppercase text-brand-600 mb-3">Photo Gallery</p>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">Explore Albania</h2>
            </div>
            <div class="flex items-center gap-3">
                <button @click="prev()" class="w-10 h-10 rounded-full border border-gray-200 bg-white hover:bg-brand-50 hover:border-brand-300 text-gray-500 hover:text-brand-600 transition flex items-center justify-center shadow-sm">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </button>
                <button @click="next()" class="w-10 h-10 rounded-full border border-gray-200 bg-white hover:bg-brand-50 hover:border-brand-300 text-gray-500 hover:text-brand-600 transition flex items-center justify-center shadow-sm">
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </button>
                <a href="{{ route('gallery') }}"
                   class="hidden sm:inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-brand-600 transition ml-2">
                    View all <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <div class="overflow-hidden" x-ref="galleryViewport">
            <div class="flex transition-transform duration-500 ease-out cursor-grab select-none"
                 :style="`transform: translateX(-${offset}px)`"
                 x-ref="galleryTrack"
                 @mousedown="startDrag($event)"
                 @mousemove.window="onDrag($event)"
                 @mouseup.window="stopDrag()"
                 @touchstart.passive="startDrag($event)"
                 @touchmove.passive="onDrag($event)"
                 @touchend="stopDrag()">
                @foreach($galleryImages as $image)
                <div class="flex-shrink-0 px-2" :style="`width: ${itemWidth}px`">
                    <div class="group relative overflow-hidden rounded-xl cursor-pointer" style="aspect-ratio: 4/3;"
                         @click="openLightbox({{ $loop->index }})">
                        <img src="{{ $image->image_url }}" alt="{{ $image->title ?? 'Gallery photo' }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                            @if($image->title)
                            <p class="text-white font-semibold text-sm">{{ $image->title }}</p>
                            @endif
                            <div class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                <i class="fa-solid fa-expand text-white text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="sm:hidden text-center mt-8">
            <a href="{{ route('gallery') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600">
                View full gallery <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>

    {{-- Lightbox --}}
    <div x-show="lightboxOpen" x-cloak
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 px-4"
         @click.self="closeLightbox()"
         @keydown.escape.window="closeLightbox()"
         @keydown.arrow-left.window="lightboxOpen && lightboxPrev()"
         @keydown.arrow-right.window="lightboxOpen && lightboxNext()">

        <button @click="closeLightbox()" class="absolute top-5 right-5 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition z-10">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        <button @click="lightboxPrev()" x-show="images.length > 1" class="absolute left-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition z-10">
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        <div class="relative max-w-5xl w-full flex flex-col items-center">
            <template x-for="(img, idx) in images" :key="idx">
                <div x-show="lightboxIndex === idx" class="w-full flex flex-col items-center">
                    <img :src="img.url" :alt="img.title || 'Gallery photo'" class="max-h-[80vh] max-w-full object-contain rounded-xl shadow-2xl">
                    <div class="mt-4 text-center" x-show="img.title || img.caption">
                        <p class="text-white font-semibold text-base" x-text="img.title" x-show="img.title"></p>
                        <p class="text-gray-400 text-sm mt-1" x-text="img.caption" x-show="img.caption"></p>
                    </div>
                    <p class="mt-3 text-gray-500 text-xs" x-text="`${idx + 1} / ${images.length}`"></p>
                </div>
            </template>
        </div>

        <button @click="lightboxNext()" x-show="images.length > 1" class="absolute right-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition z-10">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>
</section>
@endif

@if($latestPosts->isNotEmpty())
<section class="bg-gray-50 py-20" x-data="dragSlider()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between gap-4 mb-10">
            <div>
                <p class="text-xs font-bold tracking-[0.2em] uppercase text-brand-600 mb-3">From Our Journal</p>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">Latest from the Blog</h2>
            </div>
            <a href="{{ route('blog.index') }}"
               class="hidden sm:inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-brand-600 transition">
                View all <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        {{-- Desktop: 3-column grid --}}
        <div class="hidden lg:grid grid-cols-3 gap-8">
            @foreach($latestPosts as $post)
                <x-blog-card :post="$post" />
            @endforeach
        </div>
    </div>

    {{-- Mobile/tablet: drag slider --}}
    <div class="lg:hidden pl-4 sm:pl-6 mt-2">
        <div class="overflow-x-auto scrollbar-hide cursor-grab select-none"
             x-ref="track"
             @mousedown="startDrag($event)" @mousemove="onDrag($event)" @mouseup="stopDrag()" @mouseleave="stopDrag()"
             style="scrollbar-width:none;-ms-overflow-style:none;scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch;touch-action:pan-x;">
            <div class="flex gap-5 pb-2 pr-4 sm:pr-6">
                @foreach($latestPosts as $post)
                <div class="flex-shrink-0 w-[82vw] sm:w-80" style="scroll-snap-align:start;">
                    <x-blog-card :post="$post" />
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="sm:hidden max-w-7xl mx-auto px-4 mt-8 text-center">
        <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600">
            View all articles <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
    </div>
</section>
@endif

<!-- <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <h2 class="text-3xl font-bold text-gray-900 mb-4">Ready to explore?</h2>
    <p class="text-gray-600 mb-6">Browse our tours and find your next adventure.</p>
    <a href="{{ route('tours.index') }}" class="inline-flex items-center px-6 py-3 bg-amber-600 text-white font-medium rounded-lg hover:bg-amber-700">View all tours</a>
</section> -->

@push('scripts')
<script>
function gallerySlider(total, images) {
    return {
        total,
        images,
        current: 0,
        perView: 4,
        itemWidth: 0,
        offset: 0,
        isDragging: false,
        dragStartX: 0,
        dragStartOffset: 0,
        dragMoved: false,
        lightboxOpen: false,
        lightboxIndex: 0,

        init() {
            this.calcSizes();
            window.addEventListener('resize', () => this.calcSizes());
        },

        calcSizes() {
            const vw = this.$refs.galleryViewport.offsetWidth;
            if (vw < 640) this.perView = 1;
            else if (vw < 1024) this.perView = 2;
            else this.perView = 3;
            this.itemWidth = vw / this.perView;
            const max = Math.max(0, this.total - this.perView);
            if (this.current > max) this.current = max;
            this.offset = this.current * this.itemWidth;
        },

        next() {
            const max = Math.max(0, this.total - this.perView);
            this.current = this.current >= max ? 0 : this.current + 1;
            this.offset = this.current * this.itemWidth;
        },

        prev() {
            const max = Math.max(0, this.total - this.perView);
            this.current = this.current <= 0 ? max : this.current - 1;
            this.offset = this.current * this.itemWidth;
        },

        startDrag(e) {
            this.isDragging = true;
            this.dragMoved = false;
            this.dragStartX = e.touches ? e.touches[0].clientX : e.clientX;
            this.dragStartOffset = this.offset;
            this.$refs.galleryTrack.style.transition = 'none';
        },

        onDrag(e) {
            if (!this.isDragging) return;
            const x = e.touches ? e.touches[0].clientX : e.clientX;
            const diff = this.dragStartX - x;
            if (Math.abs(diff) > 5) this.dragMoved = true;
            const maxOffset = Math.max(0, this.total - this.perView) * this.itemWidth;
            this.offset = Math.max(0, Math.min(maxOffset, this.dragStartOffset + diff));
        },

        stopDrag() {
            if (!this.isDragging) return;
            this.isDragging = false;
            this.$refs.galleryTrack.style.transition = '';
            this.current = Math.round(this.offset / this.itemWidth);
            const max = Math.max(0, this.total - this.perView);
            this.current = Math.max(0, Math.min(max, this.current));
            this.offset = this.current * this.itemWidth;
        },

        openLightbox(index) {
            if (this.dragMoved) return;
            this.lightboxIndex = index;
            this.lightboxOpen = true;
            document.body.style.overflow = 'hidden';
        },

        closeLightbox() {
            this.lightboxOpen = false;
            document.body.style.overflow = '';
        },

        lightboxPrev() {
            this.lightboxIndex = this.lightboxIndex === 0 ? this.images.length - 1 : this.lightboxIndex - 1;
        },

        lightboxNext() {
            this.lightboxIndex = this.lightboxIndex === this.images.length - 1 ? 0 : this.lightboxIndex + 1;
        }
    };
}
</script>
@endpush

@push('scripts')
<script>
function dragSlider() {
    return {
        isDragging: false,
        startX: 0,
        startScrollLeft: 0,
        velX: 0,
        lastX: 0,
        rafId: null,

        // Mouse-only drag — touch is handled by native iOS scroll
        startDrag(e) {
            if (e.touches) return;
            this.isDragging = true;
            this.startX = e.clientX;
            this.startScrollLeft = this.$refs.track.scrollLeft;
            this.velX = 0;
            this.lastX = e.clientX;
            cancelAnimationFrame(this.rafId);
            this.$refs.track.style.cursor = 'grabbing';
            this.$refs.track.style.userSelect = 'none';
        },

        onDrag(e) {
            if (!this.isDragging || e.touches) return;
            e.preventDefault();
            this.velX = e.clientX - this.lastX;
            this.lastX = e.clientX;
            const walk = this.startX - e.clientX;
            this.$refs.track.scrollLeft = this.startScrollLeft + walk;
        },

        stopDrag() {
            if (!this.isDragging) return;
            this.isDragging = false;
            this.$refs.track.style.cursor = 'grab';
            this.$refs.track.style.userSelect = '';
            // Momentum glide after mouse release
            let vel = this.velX * -1;
            const glide = () => {
                if (Math.abs(vel) < 0.5) return;
                this.$refs.track.scrollLeft += vel;
                vel *= 0.92;
                this.rafId = requestAnimationFrame(glide);
            };
            this.rafId = requestAnimationFrame(glide);
        },

        scrollPrev() {
            const track = this.$refs.track;
            const item = track.querySelector('[style*="scroll-snap-align"]');
            const step = item ? item.offsetWidth + 16 : track.clientWidth * 0.85;
            track.scrollBy({ left: -step, behavior: 'smooth' });
        },

        scrollNext() {
            const track = this.$refs.track;
            const item = track.querySelector('[style*="scroll-snap-align"]');
            const step = item ? item.offsetWidth + 16 : track.clientWidth * 0.85;
            track.scrollBy({ left: step, behavior: 'smooth' });
        }
    }
}
</script>
@endpush

@endsection
