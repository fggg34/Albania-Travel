<x-app-layout>
    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            {{-- Welcome section --}}
            <div class="mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Hello, {{ Auth::user()->name }}</h1>
                    <p class="mt-1 text-gray-600">{{ __('Manage your bookings and saved tours.') }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-[#CC1021] hover:bg-[#a00d1a] transition shadow-sm">
                    <i class="fa-solid fa-user-gear"></i>
                    Profile Settings
                </a>
            </div>

            @if(session('success'))
                <div class="mb-8 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
            @endif

            {{-- My bookings --}}
            <section class="mb-10">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 bg-[#CC1021]/5">
                        <h2 class="text-lg font-semibold text-gray-900">My bookings</h2>
                        <p class="mt-0.5 text-sm text-gray-500">Your upcoming and past reservations</p>
                    </div>
                    <div class="p-6">
                        @if($bookings->isEmpty())
                            <p class="text-gray-500">You have no bookings yet. <a href="{{ route('tours.index') }}" class="text-[#CC1021] hover:text-[#a00d1a] font-medium">Browse tours</a> to plan your next adventure.</p>
                        @else
                            <ul class="divide-y divide-gray-200">
                                @foreach($bookings as $booking)
                                    <li class="py-5 first:pt-0 last:pb-0 flex flex-wrap items-center justify-between gap-3">
                                        <div class="flex-1 min-w-0">
                                            <a href="{{ route('bookings.confirmation', ['token' => $booking->confirmation_token]) }}" class="font-medium text-gray-900 hover:text-[#CC1021] transition">{{ $booking->tour->title }}</a>
                                            <p class="mt-1 text-sm text-gray-500">{{ ($booking->tourDate?->date ?? $booking->booking_date)?->format('M j, Y') }} · {{ $booking->guest_count }} guests · {{ $booking->currency }} {{ number_format($booking->total_amount, 2) }}</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="px-2.5 py-1 text-xs font-medium rounded-full
                                                @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                                @elseif($booking->status === 'cancelled') bg-gray-100 text-gray-600
                                                @else bg-[#CC1021]/10 text-[#CC1021] @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                            @if($booking->status !== 'cancelled')
                                                <form action="{{ route('user.bookings.cancel', ['token' => $booking->confirmation_token]) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this booking?');">
                                                    @csrf
                                                    <button type="submit" class="text-sm text-red-600 hover:text-red-700">Cancel</button>
                                                </form>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="mt-6 pt-4 border-t border-gray-200">{{ $bookings->links() }}</div>
                        @endif
                    </div>
                </div>
            </section>

            {{-- Saved tours --}}
            <section>
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 bg-[#CC1021]/5">
                        <h2 class="text-lg font-semibold text-gray-900">Saved tours</h2>
                        <p class="mt-0.5 text-sm text-gray-500">Tours you've added to your wishlist</p>
                    </div>
                    <div class="p-6">
                        @if($wishlistTours->isEmpty())
                            <p class="text-gray-500">No saved tours yet. <a href="{{ route('tours.index') }}" class="text-amber-600 hover:text-amber-700 font-medium">Explore tours</a> and save your favorites.</p>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($wishlistTours as $tour)
                                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-[#CC1021]/30 transition">
                                        <a href="{{ route('tours.show', $tour->slug) }}" class="font-medium text-gray-900 hover:text-[#CC1021] transition">{{ $tour->title }}</a>
                                        <form action="{{ route('wishlist.destroy', $tour) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-gray-500 hover:text-red-600">Remove</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
