<footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-white font-semibold text-lg mb-4">{{ \App\Models\Setting::get('site_name', config('app.name')) }}</h3>
                <p class="text-sm">{{ \App\Models\Setting::get('site_tagline', 'Discover your next adventure') }}</p>
            </div>
            <div>
                <h3 class="text-white font-semibold text-lg mb-4">Contact</h3>
                <p class="text-sm">{{ \App\Models\Setting::get('contact_email', '') }}</p>
                <p class="text-sm">{{ \App\Models\Setting::get('contact_phone', '') }}</p>
                <p class="text-sm">{{ \App\Models\Setting::get('contact_address', '') }}</p>
            </div>
            <div>
                <h3 class="text-white font-semibold text-lg mb-4">Newsletter</h3>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="email" name="email" placeholder="Your email" required class="flex-1 rounded-md border-gray-600 bg-gray-800 text-white px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500">
                    <button type="submit" class="px-4 py-2 bg-amber-600 text-white text-sm font-medium rounded-md hover:bg-amber-700">Subscribe</button>
                </form>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
            &copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', config('app.name')) }}. All rights reserved.
        </div>
    </div>
</footer>
