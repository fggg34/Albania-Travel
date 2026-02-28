@extends('layouts.site')

@section('title', 'FAQ - ' . config('app.name'))
@section('description', 'Frequently asked questions about tours, bookings, payments, and travel in Albania.')

@section('hero')
<section class="bg-[#0f1a1a] py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs font-bold tracking-[0.2em] uppercase text-teal-400 mb-3">Everything You Need to Know</p>
        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">Frequently Asked Questions</h1>
        <p class="text-gray-400 text-sm max-w-xl">Everything you need to know about travelling with us in Albania.</p>
    </div>
</section>
@endsection

@section('content')

<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($faqGroups->isEmpty())
            <div class="text-center py-16 text-gray-400">
                <i class="fa-solid fa-circle-question text-4xl mb-4 block"></i>
                <p>No FAQs have been added yet.</p>
            </div>
        @else
            @php $groupIndex = 0; @endphp
            @foreach($faqGroups as $categoryName => $items)
                @php
                    $first = $items->first();
                    $icon  = $first->category_icon ?? 'fa-solid fa-circle-question';
                    $isLast = $loop->last;
                @endphp

                <div class="{{ $isLast ? 'mb-4' : 'mb-12' }}">
                    {{-- Category heading --}}
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-[#0D9488]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="{{ $icon }} text-[#0D9488]"></i>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900">{{ $categoryName }}</h2>
                    </div>

                    {{-- Accordion --}}
                    <div class="space-y-3" x-data="{ open: null }">
                        @foreach($items as $idx => $faq)
                        @php $uid = $groupIndex . '_' . $idx; @endphp
                        <div class="border border-gray-100 rounded-2xl overflow-hidden bg-gray-50/50">
                            <button @click="open === '{{ $uid }}' ? open = null : open = '{{ $uid }}'"
                                class="w-full flex items-center justify-between px-6 py-4 text-left hover:bg-gray-50 transition">
                                <span class="font-semibold text-gray-900 text-sm pr-4">{{ $faq->question }}</span>
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-[#0D9488]/10 flex items-center justify-center">
                                    <i class="fa-solid fa-chevron-down text-[#0D9488] text-xs transition-transform"
                                       :class="open === '{{ $uid }}' && 'rotate-180'"></i>
                                </span>
                            </button>
                            <div x-show="open === '{{ $uid }}'" x-collapse>
                                <div class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100 pt-4">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                @if(!$isLast)
                    <div class="border-t border-gray-100 mb-12"></div>
                @endif

                @php $groupIndex++; @endphp
            @endforeach
        @endif

    </div>
</section>

@endsection
