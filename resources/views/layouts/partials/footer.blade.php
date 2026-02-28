<footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-white font-semibold text-lg mb-4">{{ \App\Models\Setting::get('site_name', config('app.name')) }}</h3>
                <p class="text-sm leading-relaxed">{{ \App\Models\Setting::get('site_tagline', 'Discover your next adventure') }}</p>
            </div>
            <div>
                <h3 class="text-white font-semibold text-lg mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('tours.index') }}" class="hover:text-white transition">Tours</a></li>
                    <li><a href="{{ route('cities.index') }}" class="hover:text-white transition">Destinations</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white transition">About Us</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-white transition">FAQ</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition">Contact</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-white font-semibold text-lg mb-4">Contact</h3>
                @if(\App\Models\Setting::get('contact_email', ''))
                <p class="text-sm mb-2"><i class="fa-solid fa-envelope mr-2 text-gray-500"></i>{{ \App\Models\Setting::get('contact_email', '') }}</p>
                @endif
                @if(\App\Models\Setting::get('contact_phone', ''))
                <p class="text-sm mb-2"><i class="fa-solid fa-phone mr-2 text-gray-500"></i>{{ \App\Models\Setting::get('contact_phone', '') }}</p>
                @endif
                @if(\App\Models\Setting::get('contact_address', ''))
                <p class="text-sm"><i class="fa-solid fa-location-dot mr-2 text-gray-500"></i>{{ \App\Models\Setting::get('contact_address', '') }}</p>
                @endif
            </div>
            <div>
                <h3 class="text-white font-semibold text-lg mb-4">Newsletter</h3>
                <p class="text-sm mb-3">Get travel tips and exclusive offers straight to your inbox.</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex gap-3">
                    @csrf
                    <input type="email" name="email" placeholder="Your email" required class="flex-1 min-w-0 rounded-lg border border-gray-600 bg-gray-800 text-white px-4 py-3 text-sm placeholder-gray-500 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    <button type="submit" class="flex-shrink-0 px-6 py-3 bg-teal-600 text-white text-sm font-medium rounded-lg hover:bg-teal-500 transition">Subscribe</button>
                </form>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
            &copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', config('app.name')) }}. All rights reserved.
        </div>
    </div>
</footer>
