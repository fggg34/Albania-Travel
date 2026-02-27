@extends('layouts.site')

@section('title', 'About Us - ' . config('app.name'))
@section('description', 'Learn about ' . \App\Models\Setting::get('site_name', config('app.name')) . ' – your trusted Albania travel partner.')

@section('hero')
<section class="relative w-full min-h-[340px] flex items-center justify-center text-white" style="background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%);">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="relative z-10 text-center px-4 py-16">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">About Us</h1>
        <p class="text-lg text-white/80 max-w-2xl mx-auto">Discover the story behind {{ \App\Models\Setting::get('site_name', config('app.name')) }} and why thousands of travellers trust us with their Albanian adventure.</p>
    </div>
</section>
@endsection

@section('content')

{{-- Story Section --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-block text-sm font-semibold text-teal-600 uppercase tracking-wide mb-2">Our Story</span>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Passionate About Albania, Dedicated to You</h2>
                <div class="space-y-4 text-gray-600 leading-relaxed">
                    <p>Founded with a deep love for Albania and its hidden treasures, {{ \App\Models\Setting::get('site_name', config('app.name')) }} was born from a simple idea: that everyone deserves to experience the beauty, culture, and warmth of this incredible country through the eyes of those who know it best.</p>
                    <p>From the turquoise waters of the Albanian Riviera to the ancient streets of Berat and Gjirokastër, we craft journeys that go beyond sightseeing. Our local expertise, combined with a personal approach, means every trip is tailored to create lasting memories.</p>
                    <p>Whether you're seeking adrenaline-fuelled adventures, cultural immersion, or a peaceful escape, our team of experienced local guides will ensure your journey through Albania is nothing short of extraordinary.</p>
                </div>
            </div>
            <div class="bg-gray-100 rounded-2xl aspect-[4/3] flex items-center justify-center overflow-hidden">
                <div class="text-center text-gray-400 p-8">
                    <i class="fa-solid fa-mountain-sun text-5xl mb-4 block"></i>
                    <p class="text-sm">Upload a team or landscape photo in the admin panel</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Mission & Vision --}}
<section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="inline-block text-sm font-semibold text-teal-600 uppercase tracking-wide mb-2">What Drives Us</span>
            <h2 class="text-3xl font-bold text-gray-900">Our Mission & Vision</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl p-8 shadow-sm">
                <div class="w-14 h-14 bg-teal-100 rounded-xl flex items-center justify-center mb-5">
                    <i class="fa-solid fa-bullseye text-teal-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Our Mission</h3>
                <p class="text-gray-600 leading-relaxed">To make Albania's beauty accessible to travellers worldwide through thoughtfully designed tours, authentic local experiences, and uncompromising service quality — all while supporting local communities and preserving the environment.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-sm">
                <div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center mb-5">
                    <i class="fa-solid fa-eye text-amber-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Our Vision</h3>
                <p class="text-gray-600 leading-relaxed">To become the most trusted name in Albanian tourism, known for creating transformative travel experiences that inspire a deeper connection between visitors and this remarkable country.</p>
            </div>
        </div>
    </div>
</section>

{{-- Why Choose Us --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="inline-block text-sm font-semibold text-teal-600 uppercase tracking-wide mb-2">Why Travel With Us</span>
            <h2 class="text-3xl font-bold text-gray-900">What Sets Us Apart</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-teal-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-user-tie text-teal-600 text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Local Expert Guides</h3>
                <p class="text-sm text-gray-600">Born and raised in Albania, our guides share insider knowledge you won't find in any guidebook.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-users text-amber-600 text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Small Group Sizes</h3>
                <p class="text-sm text-gray-600">We keep groups intimate for a more personal, immersive experience at every destination.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-tag text-emerald-600 text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Transparent Pricing</h3>
                <p class="text-sm text-gray-600">No hidden fees, no surprises. The price you see is the price you pay.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-violet-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-calendar-check text-violet-600 text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Flexible Booking</h3>
                <p class="text-sm text-gray-600">Plans change — we get it. Enjoy free cancellation and easy rescheduling on most tours.</p>
            </div>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="bg-gray-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-amber-400 mb-1">10+</div>
                <p class="text-gray-400 text-sm">Years of Experience</p>
            </div>
            <div>
                <div class="text-4xl font-bold text-amber-400 mb-1">5,000+</div>
                <p class="text-gray-400 text-sm">Happy Travellers</p>
            </div>
            <div>
                <div class="text-4xl font-bold text-amber-400 mb-1">50+</div>
                <p class="text-gray-400 text-sm">Unique Tours</p>
            </div>
            <div>
                <div class="text-4xl font-bold text-amber-400 mb-1">4.9</div>
                <p class="text-gray-400 text-sm">Average Rating</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Ready to Explore Albania?</h2>
        <p class="text-gray-600 mb-8 max-w-2xl mx-auto">Browse our handcrafted tours and let us show you the Albania that most visitors never see. Your adventure starts here.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('tours.index') }}" class="px-8 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition">Browse Tours</a>
            <a href="{{ route('contact') }}" class="px-8 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:border-gray-400 transition">Get in Touch</a>
        </div>
    </div>
</section>

@endsection
