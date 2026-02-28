@php
    $siteName    = \App\Models\Setting::get('site_name', config('app.name'));
    $tagline     = \App\Models\Setting::get('site_tagline', 'Discover your next adventure');
    $email       = \App\Models\Setting::get('contact_email', '');
    $phone       = \App\Models\Setting::get('contact_phone', '');
    $address     = \App\Models\Setting::get('contact_address', '');
    $facebook    = \App\Models\Setting::get('facebook_url', '');
    $instagram   = \App\Models\Setting::get('instagram_url', '');
    $tripadvisor = \App\Models\Setting::get('tripadvisor_url', '');
@endphp

<footer class="bg-[#0f1a1a] text-gray-400 mt-0">

    {{-- Main grid --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-12">

            {{-- Brand col --}}
            <div class="lg:col-span-4">
                <a href="{{ route('home') }}" class="text-white text-xl font-bold tracking-tight">
                    {{ $siteName }}
                </a>
                <p class="mt-4 text-sm leading-relaxed max-w-xs">{{ $tagline }}</p>

                {{-- Social --}}
                <div class="flex gap-3 mt-6">
                    @if($facebook)
                    <a href="{{ $facebook }}" target="_blank" rel="noopener"
                       class="w-9 h-9 rounded-full border border-white/10 flex items-center justify-center text-gray-400 hover:border-teal-500 hover:text-teal-400 transition">
                        <i class="fa-brands fa-facebook-f text-xs"></i>
                    </a>
                    @endif
                    @if($instagram)
                    <a href="{{ $instagram }}" target="_blank" rel="noopener"
                       class="w-9 h-9 rounded-full border border-white/10 flex items-center justify-center text-gray-400 hover:border-teal-500 hover:text-teal-400 transition">
                        <i class="fa-brands fa-instagram text-xs"></i>
                    </a>
                    @endif
                    @if($tripadvisor)
                    <a href="{{ $tripadvisor }}" target="_blank" rel="noopener"
                       class="w-9 h-9 rounded-full border border-white/10 flex items-center justify-center text-gray-400 hover:border-teal-500 hover:text-teal-400 transition">
                        <i class="fa-brands fa-tripadvisor text-xs"></i>
                    </a>
                    @endif
                    {{-- Fallback: always show placeholder icons if no settings --}}
                    @if(!$facebook && !$instagram && !$tripadvisor)
                    <a href="#" class="w-9 h-9 rounded-full border border-white/10 flex items-center justify-center text-gray-500 hover:border-teal-500 hover:text-teal-400 transition">
                        <i class="fa-brands fa-facebook-f text-xs"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full border border-white/10 flex items-center justify-center text-gray-500 hover:border-teal-500 hover:text-teal-400 transition">
                        <i class="fa-brands fa-instagram text-xs"></i>
                    </a>
                    @endif
                </div>
            </div>

            {{-- Explore links --}}
            <div class="lg:col-span-2">
                <p class="text-xs font-bold tracking-[0.18em] uppercase text-gray-500 mb-5">Explore</p>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('home') }}"         class="hover:text-white transition">Home</a></li>
                    <li><a href="{{ route('tours.index') }}"  class="hover:text-white transition">Our Tours</a></li>
                    <li><a href="{{ route('cities.index') }}" class="hover:text-white transition">Destinations</a></li>
                    <li><a href="{{ route('blog.index') }}"   class="hover:text-white transition">Blog</a></li>
                </ul>
            </div>

            {{-- Company links --}}
            <div class="lg:col-span-2">
                <p class="text-xs font-bold tracking-[0.18em] uppercase text-gray-500 mb-5">Company</p>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('about') }}"   class="hover:text-white transition">About Us</a></li>
                    <li><a href="{{ route('faq') }}"     class="hover:text-white transition">FAQ</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition">Contact Us</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="lg:col-span-4">
                <p class="text-xs font-bold tracking-[0.18em] uppercase text-gray-500 mb-5">Get in Touch</p>
                <ul class="space-y-4 text-sm">
                    @if($email)
                    <li class="flex items-start gap-3">
                        <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center">
                            <i class="fa-solid fa-envelope text-[#0D9488] text-xs"></i>
                        </span>
                        <a href="mailto:{{ $email }}" class="hover:text-white transition pt-1.5">{{ $email }}</a>
                    </li>
                    @endif
                    @if($phone)
                    <li class="flex items-start gap-3">
                        <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center">
                            <i class="fa-solid fa-phone text-[#0D9488] text-xs"></i>
                        </span>
                        <a href="tel:{{ $phone }}" class="hover:text-white transition pt-1.5">{{ $phone }}</a>
                    </li>
                    @endif
                    @if($address)
                    <li class="flex items-start gap-3">
                        <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center">
                            <i class="fa-solid fa-location-dot text-[#0D9488] text-xs"></i>
                        </span>
                        <span class="pt-1.5">{{ $address }}</span>
                    </li>
                    @endif
                    @if(!$email && !$phone && !$address)
                    <li class="text-gray-600 text-xs italic">Contact details coming soon</li>
                    @endif
                </ul>
            </div>

        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-600">
            <span>&copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.</span>
            <div class="flex gap-6">
                <a href="{{ route('faq') }}"     class="hover:text-gray-400 transition">FAQ</a>
                <a href="{{ route('contact') }}" class="hover:text-gray-400 transition">Contact</a>
                <a href="{{ route('about') }}"   class="hover:text-gray-400 transition">About</a>
            </div>
        </div>
    </div>

</footer>
