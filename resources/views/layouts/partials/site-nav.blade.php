<header class="z-50 bg-white border-b border-gray-200 shadow-sm">
    @include('layouts.partials.topbar')
    <nav x-data="{ open: false }" class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-teal-600 hover:text-teal-700 transition">
                        {{ \App\Models\Setting::get('site_name', config('app.name')) }}
                    </a>
                </div>
                <div class="hidden lg:flex lg:items-center lg:gap-2 lg:space-x-1">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('home') ? 'text-teal-600 bg-teal-50' : 'text-gray-700 hover:text-teal-600 hover:bg-gray-50' }}">Home</a>
                    <a href="{{ route('tours.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('tours.*') ? 'text-teal-600 bg-teal-50' : 'text-gray-700 hover:text-teal-600 hover:bg-gray-50' }}">Our Tours</a>
                    <a href="{{ route('about') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('about') ? 'text-teal-600 bg-teal-50' : 'text-gray-700 hover:text-teal-600 hover:bg-gray-50' }}">About Us</a>
                    <a href="{{ route('gallery') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('gallery') ? 'text-teal-600 bg-teal-50' : 'text-gray-700 hover:text-teal-600 hover:bg-gray-50' }}">Gallery</a>
                    <a href="{{ route('blog.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('blog.*') ? 'text-teal-600 bg-teal-50' : 'text-gray-700 hover:text-teal-600 hover:bg-gray-50' }}">Blog</a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md {{ request()->routeIs('contact') ? 'text-teal-600 bg-teal-50' : 'text-gray-700 hover:text-teal-600 hover:bg-gray-50' }}">Contact Us</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-teal-600 transition" title="Wishlist & bookings">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-teal-600 transition" title="Account">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-teal-600 transition" title="Wishlist">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </a>
                        <a href="{{ route('login') }}" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 hover:text-teal-600 transition" title="Account / Login">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </a>
                    @endauth
                </div>
                <div class="flex items-center lg:hidden">
                    <button @click="open = !open" type="button" class="p-2 rounded-md text-gray-500 hover:bg-gray-100">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>
        <div x-show="open" x-cloak class="lg:hidden border-t border-gray-200 bg-white">
            <div class="pt-2 pb-3 space-y-1 px-4">
                <a href="{{ route('home') }}" class="block px-4 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-gray-50">Home</a>
                <a href="{{ route('tours.index') }}" class="block px-4 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-gray-50">Our Tours</a>
                <a href="{{ route('about') }}" class="block px-4 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-gray-50">About Us</a>
                <a href="{{ route('gallery') }}" class="block px-4 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-gray-50">Gallery</a>
                <a href="{{ route('blog.index') }}" class="block px-4 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-gray-50">Blog</a>
                <a href="{{ route('contact') }}" class="block px-4 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-gray-50">Contact Us</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-700">My Bookings</a>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-700">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-700">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-teal-600">Login</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-teal-600">Register</a>
                @endauth
            </div>
        </div>
    </nav>
</header>
