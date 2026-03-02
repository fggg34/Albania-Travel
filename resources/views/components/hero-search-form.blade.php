@props(['action' => route('tours.index'), 'cities' => collect()])

@php
    $initialCity = request('city');
    $initialDate = request('date');
    $initialAdults = max(1, (int) request('adults', 2));
    $citiesData = $cities->map(fn ($c) => ['slug' => $c->slug, 'name' => $c->name, 'label' => $c->country ?? 'City'])->values()->toArray();
@endphp

<div class="w-full max-w-4xl mx-auto" x-data="heroSearchForm({
    action: @js($action),
    cities: @js($citiesData),
    initialCity: @js($initialCity),
    initialDate: @js($initialDate),
    initialAdults: {{ $initialAdults }},
})" x-init="init()">
    <form :action="action" method="GET" class="w-full" @submit="submitForm">
        <input type="hidden" name="city" :value="selectedCity">
        <input type="hidden" name="date" :value="selectedDate">
        <input type="hidden" name="adults" :value="adults">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 flex flex-col md:flex-row md:items-stretch md:divide-x md:divide-gray-200 md:h-14" style="min-height: 75px; padding: 10px 0;">
            {{-- Where to? (custom dropdown) --}}
            <div class="flex-1 min-w-0 relative md:h-full">
                <div class="flex items-center gap-2 min-h-[52px] md:min-h-0 md:h-full px-4 cursor-pointer" @click="cityOpen = !cityOpen; dateOpen = false; adultsOpen = false">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #111827"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="flex-1 text-left text-sm md:text-base truncate" style="color: #111827" x-text="selectedCityName || 'Where to?'"></span>
                </div>
                {{-- City dropdown --}}
                <div x-show="cityOpen" x-cloak @click.outside="cityOpen = false"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-100"
                    class="absolute left-0 right-0 top-full mt-4 z-50 bg-white rounded-xl shadow-xl border border-gray-200"
                    style="display: none;">
                    <div class="max-h-64 overflow-y-auto py-2">
                        <button type="button" @click="selectCity(null); cityOpen = false"
                            class="w-full flex items-center justify-between px-4 py-3 text-left hover:bg-gray-50 text-gray-900">
                            <span>Any destination</span>
                        </button>
                        <template x-for="city in cities" :key="city.slug">
                            <button type="button" @click="selectCity(city.slug); cityOpen = false"
                                class="w-full flex items-center justify-between px-4 py-3 text-left hover:bg-gray-50"
                                :class="selectedCity === city.slug ? 'bg-brand-50 text-brand-700' : 'text-gray-900'">
                                <span x-text="city.name"></span>
                                <span class="text-gray-500 text-sm ml-2" x-text="city.label || 'City'"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
            {{-- Date (flatpickr, Anytime placeholder) --}}
            <div class="flex-1 min-w-0 relative border-t md:border-t-0 md:border-l border-gray-200 md:h-full">
                <div class="flex items-center gap-2 min-h-[52px] md:min-h-0 md:h-full px-4 cursor-pointer" @click="(dateOpen && fp) ? fp.close() : (fp && fp.open()); cityOpen = false; adultsOpen = false">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #111827"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="flex-1 text-left text-sm md:text-base" style="color: #111827" x-text="selectedDate ? formatDate(selectedDate) : 'Anytime'"></span>
                </div>
                <input type="text" x-ref="dateInput" placeholder="Anytime" readonly class="sr-only" aria-label="Select date">
                <div x-show="dateOpen" x-cloak x-ref="dateContainer" class="absolute left-0 top-full mt-1 z-50 min-w-[280px]" style="display: none;"></div>
            </div>
            {{-- Adults (popup with + / -) --}}
            <div class="flex-1 min-w-0 relative border-t md:border-t-0 md:border-l border-gray-200 md:h-full">
                <div class="flex items-center gap-2 min-h-[52px] md:min-h-0 px-4 cursor-pointer md:h-full" @click="adultsOpen = !adultsOpen; cityOpen = false; dateOpen = false">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #111827"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span class="flex-1 text-left text-sm md:text-base" style="color: #111827" x-text="adults + ' Adult' + (adults !== 1 ? 's' : '')"></span>
                </div>
                {{-- Adults popup --}}
                <div x-show="adultsOpen" x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-150"
                    class="fixed inset-0 z-50 flex items-center justify-center p-4 md:block md:relative md:inset-auto md:p-0"
                    @click.self="adultsOpen = false"
                    style="display: none;">
                    <div class="absolute inset-0 bg-black/50 md:hidden" @click="adultsOpen = false"></div>
                    <div style="border: 1px solid rgb(229, 231, 235);" class="relative bg-white rounded-xl shadow-xl max-w-sm w-full p-6 md:absolute md:left-0 md:right-auto md:top-full md:mt-4 md:min-w-[220px]"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900">Adults</h3>
                            <button type="button" @click="adultsOpen = false" class="rounded-full p-1.5 text-gray-400 hover:bg-gray-100 md:hidden">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <div class="flex items-center gap-3 rounded-lg border border-gray-300 p-3">
                            <button type="button" @click="if(adults > 1) adults--"
                                class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 font-medium text-xl transition">−</button>
                            <span class="flex-1 text-center text-lg font-semibold text-gray-900" x-text="adults"></span>
                            <button type="button" @click="if(adults < 99) adults++"
                                class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 font-medium text-xl transition">+</button>
                        </div>
                        <button type="button" @click="adultsOpen = false"
                            class="mt-4 w-full py-2.5 bg-brand-600 text-white font-medium rounded-lg hover:bg-brand-700 md:hidden">
                            Done
                        </button>
                    </div>
                </div>
            </div>
            {{-- Search button --}}
            <div class="flex items-center justify-center md:h-full p-2 md:py-0" style="border-left:0;">
                <button type="submit" class="w-full md:w-auto md:min-w-[120px] h-12 md:h-full md:min-h-[48px] px-6 bg-brand-600 hover:bg-brand-700 text-white font-medium rounded-xl md:rounded-lg transition flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search
                </button>
            </div>
        </div>
    </form>
    <p class="text-center text-white/90 text-xs mt-3 flex items-center justify-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
        24/7 customer support to help with bookings and on-tour support
    </p>
</div>
