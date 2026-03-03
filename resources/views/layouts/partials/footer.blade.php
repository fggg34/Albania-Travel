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

<footer class="bg-[#111111] text-gray-400 mt-0">

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
                       class="w-9 h-9 rounded-full border border-white/10 flex items-center justify-center text-gray-400 hover:border-brand-500 hover:text-brand-400 transition">
                        <i class="fa-brands fa-facebook-f text-xs"></i>
                    </a>
                    @endif
                    @if($instagram)
                    <a href="{{ $instagram }}" target="_blank" rel="noopener"
                       class="w-9 h-9 rounded-full border border-white/10 flex items-center justify-center text-gray-400 hover:border-brand-500 hover:text-brand-400 transition">
                        <i class="fa-brands fa-instagram text-xs"></i>
                    </a>
                    @endif
                    @if($tripadvisor)
                    <a href="{{ $tripadvisor }}" target="_blank" rel="noopener"
                       class="w-9 h-9 rounded-full border border-white/10 flex items-center justify-center text-gray-400 hover:border-brand-500 hover:text-brand-400 transition">
                        <i class="fa-brands fa-tripadvisor text-xs"></i>
                    </a>
                    @endif
                    {{-- Fallback: always show placeholder icons if no settings --}}
                    @if(!$facebook && !$instagram && !$tripadvisor)
                    <a href="#" class="w-9 h-9 rounded-full border border-white/10 flex items-center justify-center text-gray-500 hover:border-brand-500 hover:text-brand-400 transition">
                        <i class="fa-brands fa-facebook-f text-xs"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full border border-white/10 flex items-center justify-center text-gray-500 hover:border-brand-500 hover:text-brand-400 transition">
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
                            <i class="fa-solid fa-envelope text-[#CC1021] text-xs"></i>
                        </span>
                        <a href="mailto:{{ $email }}" class="hover:text-white transition pt-1.5">{{ $email }}</a>
                    </li>
                    @endif
                    @if($phone)
                    <li class="flex items-start gap-3">
                        <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center">
                            <i class="fa-solid fa-phone text-[#CC1021] text-xs"></i>
                        </span>
                        <a href="tel:{{ $phone }}" class="hover:text-white transition pt-1.5">{{ $phone }}</a>
                    </li>
                    @endif
                    @if($address)
                    <li class="flex items-start gap-3">
                        <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center">
                            <i class="fa-solid fa-location-dot text-[#CC1021] text-xs"></i>
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
            <a href="https://impactdigitalagency.com" target="_blank" rel="noopener" class="inline-flex items-center gap-2 hover:text-gray-400 transition">
                <span>Powered by</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 30.32 36.12" class="flex-shrink-0">
                    <defs>
                        <style>.footer-logo-fill{fill:#fff;fill-rule:evenodd}.footer-logo-accent{fill:#f10066}</style>
                    </defs>
                    <path class="footer-logo-accent" d="M3.31,0h0c1.81,0,3.27,1.46,3.27,3.27h0c0,1.81-1.46,3.27-3.27,3.27h0C1.5,6.54.04,5.08.04,3.27H.04C.05,1.46,1.51,0,3.31,0Z"/>
                    <path class="footer-logo-fill" d="M28.5,32.31c-.58.79-1.41,1.48-2.51,2.11-1.58.9-4.33,1.77-12.69,1.33-6.75-.36-8.82-1.18-10.28-2.56-.89-.85-1.52-1.9-1.63-2.1l-.31-.58c-.53-1.03-.83-2.18-.83-3.32V11.09c0-1.51,1.22-2.72,2.73-2.72.76,0,1.44.3,1.92.8.5.5.8,1.18.8,1.92v4.98c0,.43.01.86.02,1.28.03,1.24.03,2.1.03,2.35v2.02c.02,3.83.03,5.94,1.4,7.67.4.5.88.93,1.45,1.29,1.18.76,2.27.89,4.33.99,1.26.07,3.37.17,6.72-.06,1.7-.1,2.61-.21,3.57-.89,1.04-.75,1.6-1.61,1.68-2.59.08-1-.41-1.77-.61-2.07-.23-.38-.74-.97-2.32-1.71-.95-.45-1.65-.65-2.82-.99l-.98-.29c-1.21-.35-1.89-.54-2.35-.72-2.25-.86-3.75-1.42-4.7-2.86-.92-1.4-.88-2.97-.86-3.49v-.14c0-4.98,4.79-7.58,9.53-7.58,7.04,0,9.26,4.11,9.85,7.78h-5.33c-.18-1.36-.75-2.46-1.63-3.18-.12-.1-.24-.18-.37-.27-1.63-1.07-3.99-.97-5.37.22-.63.55-1.04,1.35-1.12,2.19s.17,1.69.69,2.36c.45.58,1.1,1.04,2.04,1.45.39.17.82.33,1.3.5.59.18,1.19.36,1.79.53l.35.11c1.27.37,2.51.76,3.68,1.33,1.88.91,3.05,1.96,3.72,3.29,1.35,2.65.49,5.85-.88,7.71h-.01Z"/>
                </svg>
                <span>Impact Digital Agency</span>
            </a>
        </div>
    </div>

</footer>
