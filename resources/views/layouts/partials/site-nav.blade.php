@php
    $siteLogo = \App\Models\Setting::get('logo', '');
    $siteLogoUrl = $siteLogo ? \Illuminate\Support\Facades\Storage::disk('public')->url($siteLogo) : null;
    $siteName = \App\Models\Setting::get('site_name', config('app.name'));
@endphp
<header class="z-50 bg-white border-b border-gray-200 shadow-sm">
    @include('layouts.partials.topbar')
    <nav x-data="{ open: false }" class="bg-white">

        {{-- Main navbar bar --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-[95px]">

                {{-- Logo --}}
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        @if($siteLogoUrl)
                            <img src="{{ $siteLogoUrl }}" alt="{{ $siteName }}" class="h-[80px] w-auto object-contain">
                        @else
                            <span class="text-xl font-bold text-brand-600 hover:text-brand-700 transition">{{ $siteName }}</span>
                        @endif
                    </a>
                </div>

                {{-- Desktop links --}}
                <div class="hidden lg:flex lg:items-center lg:gap-2 lg:space-x-1">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('home') ? 'text-brand-600 bg-brand-50' : 'text-gray-700 hover:text-brand-600 hover:bg-gray-50' }}">Home</a>
                    <a href="{{ route('tours.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('tours.*') ? 'text-brand-600 bg-brand-50' : 'text-gray-700 hover:text-brand-600 hover:bg-gray-50' }}">Our Tours</a>
                    <a href="{{ route('about') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('about') ? 'text-brand-600 bg-brand-50' : 'text-gray-700 hover:text-brand-600 hover:bg-gray-50' }}">About Us</a>
                    <a href="{{ route('gallery') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('gallery') ? 'text-brand-600 bg-brand-50' : 'text-gray-700 hover:text-brand-600 hover:bg-gray-50' }}">Gallery</a>
                    <a href="{{ route('blog.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('blog.*') ? 'text-brand-600 bg-brand-50' : 'text-gray-700 hover:text-brand-600 hover:bg-gray-50' }}">Blog</a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('contact') ? 'text-brand-600 bg-brand-50' : 'text-gray-700 hover:text-brand-600 hover:bg-gray-50' }}">Contact Us</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-brand-600 transition" title="Wishlist & bookings">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-brand-600 transition" title="Account">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-brand-600 transition" title="Wishlist">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </a>
                        <a href="{{ route('login') }}" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-brand-600 transition" title="Account / Login">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </a>
                    @endauth
                </div>

                {{-- Hamburger (mobile) --}}
                <div class="flex items-center lg:hidden">
                    <button @click="open = true" type="button" class="p-2 rounded-md text-gray-500 hover:bg-gray-100 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile side-drawer backdrop --}}
        <div x-show="open"
             x-cloak
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="open = false"
             class="lg:hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-40">
        </div>

        {{-- Mobile side-drawer panel --}}
        <div x-show="open"
             x-cloak
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="lg:hidden fixed inset-y-0 left-0 w-72 bg-white z-50 flex flex-col shadow-2xl">

            {{-- Drawer header --}}
            <div class="flex items-center justify-between px-5 h-16 border-b border-gray-100 flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center" @click="open = false">
                    @if($siteLogoUrl)
                        <img src="{{ $siteLogoUrl }}" alt="{{ $siteName }}" class="h-7 w-auto object-contain">
                    @else
                        <span class="text-lg font-bold text-brand-600">{{ $siteName }}</span>
                    @endif
                </a>
                <button @click="open = false" class="p-2 rounded-md text-gray-400 hover:bg-gray-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Nav links --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">
                <a href="{{ route('home') }}" @click="open = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('home') ? 'bg-brand-50 text-brand-600' : 'text-gray-700 hover:bg-gray-50 hover:text-brand-600' }}">
                    <i class="fa-solid fa-house w-4 text-center text-gray-400 {{ request()->routeIs('home') ? 'text-brand-500' : '' }}"></i>
                    Home
                </a>
                <a href="{{ route('tours.index') }}" @click="open = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('tours.*') ? 'bg-brand-50 text-brand-600' : 'text-gray-700 hover:bg-gray-50 hover:text-brand-600' }}">
                    <i class="fa-solid fa-map-location-dot w-4 text-center text-gray-400 {{ request()->routeIs('tours.*') ? 'text-brand-500' : '' }}"></i>
                    Our Tours
                </a>
                <a href="{{ route('about') }}" @click="open = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('about') ? 'bg-brand-50 text-brand-600' : 'text-gray-700 hover:bg-gray-50 hover:text-brand-600' }}">
                    <i class="fa-solid fa-circle-info w-4 text-center text-gray-400 {{ request()->routeIs('about') ? 'text-brand-500' : '' }}"></i>
                    About Us
                </a>
                <a href="{{ route('gallery') }}" @click="open = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('gallery') ? 'bg-brand-50 text-brand-600' : 'text-gray-700 hover:bg-gray-50 hover:text-brand-600' }}">
                    <i class="fa-solid fa-images w-4 text-center text-gray-400 {{ request()->routeIs('gallery') ? 'text-brand-500' : '' }}"></i>
                    Gallery
                </a>
                <a href="{{ route('blog.index') }}" @click="open = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('blog.*') ? 'bg-brand-50 text-brand-600' : 'text-gray-700 hover:bg-gray-50 hover:text-brand-600' }}">
                    <i class="fa-solid fa-newspaper w-4 text-center text-gray-400 {{ request()->routeIs('blog.*') ? 'text-brand-500' : '' }}"></i>
                    Blog
                </a>
                <a href="{{ route('contact') }}" @click="open = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('contact') ? 'bg-brand-50 text-brand-600' : 'text-gray-700 hover:bg-gray-50 hover:text-brand-600' }}">
                    <i class="fa-solid fa-envelope w-4 text-center text-gray-400 {{ request()->routeIs('contact') ? 'text-brand-500' : '' }}"></i>
                    Contact Us
                </a>
            </nav>

            {{-- Drawer footer: account actions --}}
            <div class="flex-shrink-0 border-t border-gray-100 px-3 py-4 space-y-0.5">
                @auth
                    <a href="{{ route('dashboard') }}" @click="open = false"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-brand-600 transition">
                        <i class="fa-solid fa-heart w-4 text-center text-gray-400"></i>
                        My Bookings
                    </a>
                    <a href="{{ route('profile.edit') }}" @click="open = false"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-brand-600 transition">
                        <i class="fa-solid fa-user w-4 text-center text-gray-400"></i>
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-red-500 hover:bg-red-50 transition">
                            <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" @click="open = false"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-brand-600 hover:bg-brand-50 transition">
                        <i class="fa-solid fa-right-to-bracket w-4 text-center"></i>
                        Login
                    </a>
                    <a href="{{ route('register') }}" @click="open = false"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-brand-600 transition">
                        <i class="fa-solid fa-user-plus w-4 text-center text-gray-400"></i>
                        Register
                    </a>
                @endauth
            </div>

        </div>

    </nav>
</header>
