@extends('layouts.site')

@section('title', 'Gallery - ' . config('app.name'))
@section('description', 'Browse our photo gallery of Albania tours, landscapes, culture, and travel experiences.')

@section('hero')
<section class="relative overflow-hidden bg-[#1e1e1e] py-12">
    @include('layouts.partials.hero-decorations')
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-px bg-amber-400/70"></div>
            <p class="text-xs font-bold tracking-[0.25em] uppercase text-amber-400">Through Our Lens</p>
        </div>
        <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4 leading-tight">Gallery</h1>
        <p class="text-gray-400 text-base max-w-xl leading-relaxed">A glimpse into the landscapes, culture, and unforgettable moments waiting for you in Albania.</p>
    </div>
</section>
@endsection

@section('content')

<section
    class="py-14 bg-white"
    x-data="galleryPage()"
    x-init="init()"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Category filter tabs --}}
        @if($categories->isNotEmpty())
        <div class="flex flex-wrap items-center gap-2 mb-10">
            <button
                @click="activeCategory = 'all'"
                :class="activeCategory === 'all'
                    ? 'bg-[#0D9488] text-white border-[#0D9488]'
                    : 'bg-white text-gray-600 border-gray-200 hover:border-[#0D9488] hover:text-[#0D9488]'"
                class="px-5 py-2 rounded-full text-sm font-semibold border transition-all duration-200">
                All
            </button>
            @foreach($categories as $cat)
            <button
                @click="activeCategory = '{{ e($cat) }}'"
                :class="activeCategory === '{{ e($cat) }}'
                    ? 'bg-[#0D9488] text-white border-[#0D9488]'
                    : 'bg-white text-gray-600 border-gray-200 hover:border-[#0D9488] hover:text-[#0D9488]'"
                class="px-5 py-2 rounded-full text-sm font-semibold border transition-all duration-200">
                {{ $cat }}
            </button>
            @endforeach
        </div>
        @endif

        {{-- Empty state --}}
        @if($images->isEmpty())
        <div class="text-center py-24 text-gray-400">
            <i class="fa-regular fa-image text-5xl mb-4 block"></i>
            <p class="text-lg font-medium text-gray-500">No photos yet</p>
            <p class="text-sm mt-1">Check back soon — we're adding photos all the time.</p>
        </div>
        @else

        {{-- Masonry grid --}}
        <div class="columns-1 sm:columns-2 lg:columns-3 gap-4 space-y-4">
            @foreach($images as $image)
            <div
                class="break-inside-avoid group relative overflow-hidden rounded-2xl cursor-pointer shadow-sm hover:shadow-xl transition-all duration-300"
                data-category="{{ e($image->category) }}"
                x-show="activeCategory === 'all' || activeCategory === '{{ e($image->category) }}'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                @click="openLightbox({{ $loop->index }})"
            >
                {{-- Image --}}
                <img
                    src="{{ $image->image_url }}"
                    alt="{{ $image->title ?? 'Gallery photo' }}"
                    class="w-full object-cover block group-hover:scale-105 transition-transform duration-500"
                    loading="lazy"
                >

                {{-- Hover overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5">
                    @if($image->title)
                    <p class="text-white font-semibold text-sm leading-snug">{{ $image->title }}</p>
                    @endif
                    @if($image->caption)
                    <p class="text-gray-300 text-xs mt-1">{{ $image->caption }}</p>
                    @endif
                    @if($image->category)
                    <span class="mt-2 self-start inline-flex items-center gap-1.5 bg-[#0D9488]/80 text-white text-xs font-semibold px-2.5 py-1 rounded-full">
                        <i class="fa-solid fa-tag text-[9px]"></i>
                        {{ $image->category }}
                    </span>
                    @endif
                    <div class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                        <i class="fa-solid fa-expand text-white text-xs"></i>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- No results message for filter --}}
        <div x-show="filteredCount === 0" class="text-center py-16 text-gray-400" x-cloak>
            <i class="fa-regular fa-image text-4xl mb-3 block"></i>
            <p class="text-gray-500">No photos in this category yet.</p>
        </div>

        @endif
    </div>

    {{-- ==================== LIGHTBOX ==================== --}}
    @if($images->isNotEmpty())
    <div
        x-show="lightboxOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 px-4"
        @click.self="closeLightbox()"
        @keydown.escape.window="closeLightbox()"
        @keydown.arrow-left.window="prevImage()"
        @keydown.arrow-right.window="nextImage()"
    >
        {{-- Close button --}}
        <button
            @click="closeLightbox()"
            class="absolute top-5 right-5 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition z-10">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        {{-- Prev --}}
        <button
            @click="prevImage()"
            x-show="images.length > 1"
            class="absolute left-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition z-10">
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        {{-- Image container --}}
        <div class="relative max-w-5xl w-full flex flex-col items-center">
            <template x-for="(img, index) in images" :key="index">
                <div x-show="lightboxIndex === index" class="w-full flex flex-col items-center">
                    <img
                        :src="img.url"
                        :alt="img.title || 'Gallery photo'"
                        class="max-h-[80vh] max-w-full object-contain rounded-xl shadow-2xl"
                    >
                    {{-- Caption bar --}}
                    <div class="mt-4 text-center" x-show="img.title || img.caption || img.category">
                        <p class="text-white font-semibold text-base" x-text="img.title" x-show="img.title"></p>
                        <p class="text-gray-400 text-sm mt-1" x-text="img.caption" x-show="img.caption"></p>
                        <span
                            class="mt-2 inline-flex items-center gap-1.5 bg-[#0D9488]/80 text-white text-xs font-semibold px-3 py-1 rounded-full"
                            x-show="img.category"
                            x-text="img.category">
                        </span>
                    </div>
                    {{-- Counter --}}
                    <p class="mt-3 text-gray-500 text-xs" x-text="`${index + 1} / ${images.length}`"></p>
                </div>
            </template>
        </div>

        {{-- Next --}}
        <button
            @click="nextImage()"
            x-show="images.length > 1"
            class="absolute right-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition z-10">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>
    @endif
</section>

@push('scripts')
<script>
function galleryPage() {
    const allImages = {!! $imagesJson !!};

    return {
        activeCategory: 'all',
        lightboxOpen: false,
        lightboxIndex: 0,
        images: allImages,
        filteredCount: allImages.length,

        init() {
            this.$watch('activeCategory', () => this.updateCount());
        },

        updateCount() {
            if (this.activeCategory === 'all') {
                this.filteredCount = this.images.length;
            } else {
                this.filteredCount = this.images.filter(img => img.category === this.activeCategory).length;
            }
        },

        openLightbox(index) {
            this.lightboxIndex = index;
            this.lightboxOpen = true;
            document.body.style.overflow = 'hidden';
        },

        closeLightbox() {
            this.lightboxOpen = false;
            document.body.style.overflow = '';
        },

        prevImage() {
            this.lightboxIndex = this.lightboxIndex === 0
                ? this.images.length - 1
                : this.lightboxIndex - 1;
        },

        nextImage() {
            this.lightboxIndex = this.lightboxIndex === this.images.length - 1
                ? 0
                : this.lightboxIndex + 1;
        },
    };
}
</script>
@endpush

@endsection
