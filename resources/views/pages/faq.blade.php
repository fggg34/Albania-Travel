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

        {{-- Booking & Reservations --}}
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-[#0D9488]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-calendar-check text-[#0D9488]"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Booking &amp; Reservations</h2>
                </div>
            </div>

            <div class="space-y-3" x-data="{ open: null }">
                @foreach([
                    ['How do I book a tour?', 'You can book directly on our website by selecting a tour, choosing your preferred date and number of travellers, and completing the booking form. You\'ll receive a confirmation email with all the details. No account is required.'],
                    ['Do I need to pay in advance?', 'Yes, we require payment at the time of booking to secure your spot. This helps us manage group sizes and ensure the best experience for everyone.'],
                    ['Can I book a private tour?', 'Absolutely! We offer private and customised tours for individuals, couples, families, and groups. Contact us with your preferences and we\'ll create a tailored itinerary just for you.'],
                    ['How far in advance should I book?', 'We recommend booking at least 3–5 days in advance, especially during peak season (June–September). Popular tours can fill up quickly, so the earlier the better.'],
                    ['Can I book for a large group?', 'Yes! We accommodate groups of all sizes. For parties of 10 or more, please contact us directly so we can arrange the best experience and pricing for your group.'],
                ] as $i => $faq)
                <div class="border border-gray-100 rounded-2xl overflow-hidden bg-gray-50/50">
                    <button @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                        class="w-full flex items-center justify-between px-6 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900 text-sm pr-4">{{ $faq[0] }}</span>
                        <span class="flex-shrink-0 w-6 h-6 rounded-full bg-[#0D9488]/10 flex items-center justify-center">
                            <i class="fa-solid fa-chevron-down text-[#0D9488] text-xs transition-transform" :class="open === {{ $i }} && 'rotate-180'"></i>
                        </span>
                    </button>
                    <div x-show="open === {{ $i }}" x-collapse>
                        <div class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100 pt-4">{{ $faq[1] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="border-t border-gray-100 mb-12"></div>

        {{-- Payments & Pricing --}}
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-[#0D9488]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-credit-card text-[#0D9488]"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Payments &amp; Pricing</h2>
                </div>
            </div>

            <div class="space-y-3" x-data="{ open: null }">
                @foreach([
                    ['What payment methods do you accept?', 'We accept major credit and debit cards (Visa, Mastercard, American Express). For some tours, bank transfers and cash payment on arrival may be available. Payment options are shown during checkout.'],
                    ['Are there any hidden fees?', 'No. The price you see on our website is the total price. All entrance fees, guide services, and transport (when listed) are included. We believe in full transparency.'],
                    ['Do you offer discounts for children?', 'Yes, children under 12 typically receive a reduced rate, and infants (under 2) are often free. Specific pricing is shown on each tour page.'],
                    ['What currency are your prices in?', 'All prices on our website are displayed in Euros (€). Payments are processed in EUR.'],
                ] as $i => $faq)
                <div class="border border-gray-100 rounded-2xl overflow-hidden bg-gray-50/50">
                    <button @click="open === {{ $i + 10 }} ? open = null : open = {{ $i + 10 }}"
                        class="w-full flex items-center justify-between px-6 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900 text-sm pr-4">{{ $faq[0] }}</span>
                        <span class="flex-shrink-0 w-6 h-6 rounded-full bg-[#0D9488]/10 flex items-center justify-center">
                            <i class="fa-solid fa-chevron-down text-[#0D9488] text-xs transition-transform" :class="open === {{ $i + 10 }} && 'rotate-180'"></i>
                        </span>
                    </button>
                    <div x-show="open === {{ $i + 10 }}" x-collapse>
                        <div class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100 pt-4">{{ $faq[1] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="border-t border-gray-100 mb-12"></div>

        {{-- Cancellations & Changes --}}
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-[#0D9488]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-rotate-left text-[#0D9488]"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Cancellations &amp; Changes</h2>
                </div>
            </div>

            <div class="space-y-3" x-data="{ open: null }">
                @foreach([
                    ['What is your cancellation policy?', 'Free cancellation is available up to 48 hours before the tour start time. Cancellations within 48 hours may be subject to a fee. Specific policies are noted on each tour page.'],
                    ['Can I change my booking date?', 'Yes, you can reschedule your tour at no additional cost, subject to availability. Contact us at least 48 hours before your original tour date.'],
                    ['What happens if a tour is cancelled due to weather?', 'Safety is our priority. If a tour is cancelled due to severe weather, you will be offered an alternative date or a full refund. We will notify you as soon as possible.'],
                    ['How do I request a refund?', 'Contact us via email or phone with your booking reference. Refunds are processed within 5–10 business days to the original payment method.'],
                ] as $i => $faq)
                <div class="border border-gray-100 rounded-2xl overflow-hidden bg-gray-50/50">
                    <button @click="open === {{ $i + 20 }} ? open = null : open = {{ $i + 20 }}"
                        class="w-full flex items-center justify-between px-6 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900 text-sm pr-4">{{ $faq[0] }}</span>
                        <span class="flex-shrink-0 w-6 h-6 rounded-full bg-[#0D9488]/10 flex items-center justify-center">
                            <i class="fa-solid fa-chevron-down text-[#0D9488] text-xs transition-transform" :class="open === {{ $i + 20 }} && 'rotate-180'"></i>
                        </span>
                    </button>
                    <div x-show="open === {{ $i + 20 }}" x-collapse>
                        <div class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100 pt-4">{{ $faq[1] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="border-t border-gray-100 mb-12"></div>

        {{-- Travelling in Albania --}}
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-[#0D9488]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-plane text-[#0D9488]"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Travelling in Albania</h2>
                </div>
            </div>

            <div class="space-y-3" x-data="{ open: null }">
                @foreach([
                    ['Is Albania safe for tourists?', 'Yes, Albania is considered very safe for tourists. Albanians are known for their hospitality and warmth. As with any destination, we recommend standard precautions like watching your belongings in crowded areas.'],
                    ['Do I need a visa to visit Albania?', 'EU, US, UK, Canadian, and Australian citizens can visit Albania visa-free for up to 90 days. Check the Albanian Ministry of Foreign Affairs website for the latest entry requirements for your nationality.'],
                    ['What is the best time to visit Albania?', 'The best time for tours is from April to October. Summer (June–August) is ideal for the coast and beaches. Spring and autumn are perfect for hiking, cultural tours, and avoiding crowds.'],
                    ['What should I pack for a tour in Albania?', 'Comfortable walking shoes, sunscreen, a hat, and layered clothing (temperatures can vary). For beach/coastal tours, bring swimwear. For mountain tours, we recommend waterproof outerwear.'],
                    ['What language is spoken in Albania?', 'The official language is Albanian. English is widely spoken in tourist areas, especially by younger Albanians. Our guides are fluent in English and several other languages.'],
                    ['What is the local currency?', 'The local currency is the Albanian Lek (ALL). Euros are widely accepted in tourist areas. ATMs are readily available in cities and towns. Credit cards are accepted at most hotels and restaurants.'],
                ] as $i => $faq)
                <div class="border border-gray-100 rounded-2xl overflow-hidden bg-gray-50/50">
                    <button @click="open === {{ $i + 30 }} ? open = null : open = {{ $i + 30 }}"
                        class="w-full flex items-center justify-between px-6 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900 text-sm pr-4">{{ $faq[0] }}</span>
                        <span class="flex-shrink-0 w-6 h-6 rounded-full bg-[#0D9488]/10 flex items-center justify-center">
                            <i class="fa-solid fa-chevron-down text-[#0D9488] text-xs transition-transform" :class="open === {{ $i + 30 }} && 'rotate-180'"></i>
                        </span>
                    </button>
                    <div x-show="open === {{ $i + 30 }}" x-collapse>
                        <div class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100 pt-4">{{ $faq[1] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="border-t border-gray-100 mb-12"></div>

        {{-- Tour Experience --}}
        <div class="mb-4">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-[#0D9488]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-compass text-[#0D9488]"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Tour Experience</h2>
                </div>
            </div>

            <div class="space-y-3" x-data="{ open: null }">
                @foreach([
                    ['What is included in the tour price?', 'Each tour page lists exactly what is included. Typically this covers guide services, transport, entrance fees, and any meals mentioned. Check the "What\'s Included" section on each tour for specifics.'],
                    ['How large are the tour groups?', 'Most of our tours run with 2–15 people per group. Private tours are available for those who prefer a more exclusive experience.'],
                    ['Are your tours suitable for children?', 'Many of our tours are family-friendly. Each tour page indicates the recommended minimum age and difficulty level. Contact us if you need advice on the best tour for your family.'],
                    ['Do I need to be physically fit for hiking tours?', 'Fitness requirements vary by tour. Each tour has a difficulty rating (Easy, Moderate, Challenging). We recommend reading the tour description carefully and contacting us if you are unsure.'],
                    ['Are meals included in the tours?', 'Some tours include meals (usually lunch or a traditional Albanian food experience). This is clearly stated on each tour page. For day tours, you may want to bring snacks and water.'],
                ] as $i => $faq)
                <div class="border border-gray-100 rounded-2xl overflow-hidden bg-gray-50/50">
                    <button @click="open === {{ $i + 40 }} ? open = null : open = {{ $i + 40 }}"
                        class="w-full flex items-center justify-between px-6 py-4 text-left hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900 text-sm pr-4">{{ $faq[0] }}</span>
                        <span class="flex-shrink-0 w-6 h-6 rounded-full bg-[#0D9488]/10 flex items-center justify-center">
                            <i class="fa-solid fa-chevron-down text-[#0D9488] text-xs transition-transform" :class="open === {{ $i + 40 }} && 'rotate-180'"></i>
                        </span>
                    </button>
                    <div x-show="open === {{ $i + 40 }}" x-collapse>
                        <div class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100 pt-4">{{ $faq[1] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

@endsection
