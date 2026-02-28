@extends('layouts.site')

@section('title', 'Contact Us - ' . config('app.name'))
@section('description', 'Get in touch with ' . \App\Models\Setting::get('site_name', config('app.name')) . '. We\'d love to hear from you.')

@section('hero')
<section class="bg-[#0f1a1a] py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs font-bold tracking-[0.2em] uppercase text-teal-400 mb-3">We're here to help</p>
        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">Contact Us</h1>
        <p class="text-gray-400 text-sm max-w-xl">Have a question about a tour, need help planning your trip, or just want to say hello?</p>
    </div>
</section>
@endsection

@section('content')

<section class="pt-16 pb-10 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 lg:gap-16">

            {{-- Left: Contact info (2/5) --}}
            <div class="lg:col-span-2 space-y-8">
                <div>
                    <p class="text-xs font-bold tracking-[0.2em] uppercase text-[#0D9488] mb-3">Get in Touch</p>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">We'd Love to Hear From You</h2>
                    <p class="text-gray-500 leading-relaxed text-sm">Whether you have questions about our tours, need a custom itinerary, or want to discuss group bookings — our team is ready to assist you.</p>
                </div>

                <div class="space-y-5">
                    @php
                        $email = \App\Models\Setting::get('contact_email', '');
                        $phone = \App\Models\Setting::get('contact_phone', '');
                        $address = \App\Models\Setting::get('contact_address', '');
                    @endphp

                    @if($email)
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-11 h-11 bg-[#0D9488]/10 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-envelope text-[#0D9488]"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-0.5">Email</p>
                            <a href="mailto:{{ $email }}" class="text-gray-800 hover:text-[#0D9488] transition text-sm font-medium">{{ $email }}</a>
                        </div>
                    </div>
                    @endif

                    @if($phone)
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-11 h-11 bg-[#0D9488]/10 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-phone text-[#0D9488]"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-0.5">Phone</p>
                            <a href="tel:{{ $phone }}" class="text-gray-800 hover:text-[#0D9488] transition text-sm font-medium">{{ $phone }}</a>
                        </div>
                    </div>
                    @endif

                    @if($address)
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-11 h-11 bg-[#0D9488]/10 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-location-dot text-[#0D9488]"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-0.5">Address</p>
                            <p class="text-gray-800 text-sm font-medium">{{ $address }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Response time --}}
                <div class="bg-[#0D9488]/5 border border-[#0D9488]/20 rounded-2xl p-5">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-clock text-[#0D9488] mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm mb-1">Response Time</p>
                            <p class="text-sm text-gray-500 leading-relaxed">We typically respond within 2–4 hours during business hours (9:00 – 18:00 CET).</p>
                        </div>
                    </div>
                </div>

                {{-- Social links --}}
                @php
                    $facebook = \App\Models\Setting::get('facebook_url', '');
                    $instagram = \App\Models\Setting::get('instagram_url', '');
                @endphp
                @if($facebook || $instagram)
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Follow Us</p>
                    <div class="flex gap-3">
                        @if($facebook)
                        <a href="{{ $facebook }}" target="_blank" rel="noopener"
                            class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-500 hover:bg-[#0D9488]/10 hover:text-[#0D9488] transition">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                        @endif
                        @if($instagram)
                        <a href="{{ $instagram }}" target="_blank" rel="noopener"
                            class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-500 hover:bg-[#0D9488]/10 hover:text-[#0D9488] transition">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            {{-- Right: Contact form (3/5) --}}
            <div class="lg:col-span-3">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 lg:p-10">
                    <p class="text-xs font-bold tracking-[0.2em] uppercase text-[#0D9488] mb-3">Drop us a line</p>
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Send Us a Message</h3>

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-800 rounded-xl flex items-center gap-3 text-sm">
                            <i class="fa-solid fa-circle-check text-green-500 flex-shrink-0"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    placeholder="John Doe"
                                    class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#0D9488] focus:ring-1 focus:ring-[#0D9488] text-gray-900 text-sm py-2.5 px-3">
                                @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    placeholder="john@example.com"
                                    class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#0D9488] focus:ring-1 focus:ring-[#0D9488] text-gray-900 text-sm py-2.5 px-3">
                                @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div>
                            <label for="subject" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Subject <span class="text-red-500">*</span></label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                                placeholder="e.g. Question about a tour"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#0D9488] focus:ring-1 focus:ring-[#0D9488] text-gray-900 text-sm py-2.5 px-3">
                            @error('subject')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="message" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Message <span class="text-red-500">*</span></label>
                            <textarea name="message" id="message" rows="5" required
                                placeholder="Tell us how we can help you…"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#0D9488] focus:ring-1 focus:ring-[#0D9488] text-gray-900 text-sm py-2.5 px-3 resize-none">{{ old('message') }}</textarea>
                            @error('message')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="flex items-center gap-6">
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-8 py-3 bg-[#0D9488] text-white font-semibold rounded-xl hover:bg-[#0b8277] transition text-sm shadow-sm">
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                                Send Message
                            </button>
                            <p class="text-xs text-gray-400 flex items-center gap-1.5">
                                <i class="fa-solid fa-shield-halved text-[#0D9488]"></i>
                                Your info is safe with us
                            </p>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

@php $mapEmbed = \App\Models\Setting::get('map_embed', ''); @endphp
@if($mapEmbed)
<section class="pb-10 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl overflow-hidden shadow-sm border border-gray-100" style="height: 400px;">
            {!! $mapEmbed !!}
        </div>
    </div>
</section>
@endif

@endsection
