@extends('layouts.site')

@section('title', 'Booking confirmed - ' . $siteName)

@section('content')
@php
    $bookingDate = $booking->booking_date ?? $booking->tourDate?->date;
    $firstImage = $booking->tour->images->first();
    $tourImageUrl = $firstImage && $firstImage->path ? $firstImage->url : 'https://placehold.co/1200x600?text=Tour';
    $durationDays = (int) ($booking->tour->duration_days ?? 0);
    $durationLabel = $durationDays ? $durationDays . ' Day' . ($durationDays > 1 ? 's' : '') . ' Tour' : ($booking->tour->duration_hours ? (int) $booking->tour->duration_hours . ' hours' : 'Tour');
@endphp

{{-- Hero confirmation banner --}}
<div class="bg-green-600 py-8 px-4 text-center">
    <h1 class="text-2xl sm:text-3xl font-bold text-white">Booking Confirmed!</h1>
    <p class="mt-2 text-green-100 text-sm max-w-md mx-auto">
        A confirmation email has been sent to <strong class="text-white">{{ $booking->guest_email }}</strong>.
    </p>
    <div class="mt-4 inline-flex items-center gap-2 bg-white/15 text-white text-sm font-mono px-5 py-2 rounded-full">
        <i class="fa-solid fa-hashtag text-green-200 text-xs"></i>
        {{ $booking->reference }}
    </div>
</div>

<div class="bg-gray-50 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Main card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-5">

                {{-- Left: Booking details --}}
                <div class="lg:col-span-3 p-6 sm:p-8">
                    <h2 class="text-sm font-bold text-gray-900 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <span class="inline-block w-1 h-4 bg-[#CC1021] rounded-full"></span>
                        Booking Details
                    </h2>

                    <dl class="space-y-4">
                        <div class="flex justify-between items-start gap-4 py-3 border-b border-gray-50">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide w-32 flex-shrink-0 pt-0.5">Reference</dt>
                            <dd class="font-mono font-bold text-gray-900 text-sm">{{ $booking->reference }}</dd>
                        </div>
                        <div class="flex justify-between items-start gap-4 py-3 border-b border-gray-50">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide w-32 flex-shrink-0 pt-0.5">Traveler</dt>
                            <dd class="text-gray-900 text-sm font-medium">{{ $booking->guest_name }}</dd>
                        </div>
                        <div class="flex justify-between items-start gap-4 py-3 border-b border-gray-50">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide w-32 flex-shrink-0 pt-0.5">Email</dt>
                            <dd class="text-gray-700 text-sm">{{ $booking->guest_email }}</dd>
                        </div>
                        @if($booking->guest_phone)
                        <div class="flex justify-between items-start gap-4 py-3 border-b border-gray-50">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide w-32 flex-shrink-0 pt-0.5">Phone</dt>
                            <dd class="text-gray-700 text-sm">{{ $booking->guest_phone }}</dd>
                        </div>
                        @endif
                        <div class="flex justify-between items-start gap-4 py-3 border-b border-gray-50">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide w-32 flex-shrink-0 pt-0.5">Tour</dt>
                            <dd class="text-gray-900 text-sm font-medium">{{ $booking->tour->title }}</dd>
                        </div>
                        <div class="flex justify-between items-start gap-4 py-3 border-b border-gray-50">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide w-32 flex-shrink-0 pt-0.5">Date</dt>
                            <dd class="text-gray-700 text-sm">{{ $bookingDate?->format('l, F j, Y') }}</dd>
                        </div>
                        <div class="flex justify-between items-start gap-4 py-3 border-b border-gray-50">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide w-32 flex-shrink-0 pt-0.5">Travelers</dt>
                            <dd class="text-gray-700 text-sm">{{ $booking->guest_count }} {{ Str::plural('person', $booking->guest_count) }}</dd>
                        </div>
                        @if($booking->pickup_location)
                        <div class="flex justify-between items-start gap-4 py-3 border-b border-gray-50">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide w-32 flex-shrink-0 pt-0.5">Pickup</dt>
                            <dd class="text-gray-700 text-sm">{{ $booking->pickup_location }}</dd>
                        </div>
                        @endif
                        @if($booking->billing_address || $booking->billing_city || $booking->billing_country)
                        <div class="flex justify-between items-start gap-4 py-3 border-b border-gray-50">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide w-32 flex-shrink-0 pt-0.5">Billing</dt>
                            <dd class="text-gray-700 text-sm leading-relaxed">
                                @if($booking->billing_address){{ $booking->billing_address }}<br>@endif
                                @if($booking->billing_city || $booking->billing_region){{ trim(($booking->billing_city ?? '') . ', ' . ($booking->billing_region ?? '')) }}<br>@endif
                                @if($booking->billing_country){{ $booking->billing_country }}@endif
                            </dd>
                        </div>
                        @endif
                        @if($booking->special_requests)
                        <div class="flex justify-between items-start gap-4 py-3">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wide w-32 flex-shrink-0 pt-0.5">Requests</dt>
                            <dd class="text-gray-700 text-sm">{{ $booking->special_requests }}</dd>
                        </div>
                        @endif
                    </dl>

                    {{-- Actions --}}
                    <div class="flex flex-wrap gap-3 mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('tours.show', $booking->tour->slug) }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                            <i class="fa-solid fa-eye text-xs"></i>
                            View tour
                        </a>
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium text-white bg-[#CC1021] hover:bg-[#a50d18] transition">
                                <i class="fa-solid fa-calendar-check text-xs"></i>
                                My bookings
                            </a>
                            @if($booking->user_id === auth()->id() && $booking->status !== 'cancelled')
                                <form action="{{ route('user.bookings.cancel', ['token' => $booking->confirmation_token]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 transition">
                                        <i class="fa-solid fa-xmark text-xs"></i>
                                        Cancel booking
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('tours.index') }}"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium text-white bg-[#CC1021] hover:bg-[#a50d18] transition">
                                <i class="fa-solid fa-compass text-xs"></i>
                                Browse more tours
                            </a>
                        @endauth
                    </div>
                </div>

                {{-- Right: Tour summary --}}
                <div class="lg:col-span-2 bg-gray-50 p-6 sm:p-8 border-t lg:border-t-0 lg:border-l border-gray-200">
                    <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-gray-200 mb-5">
                        <img src="{{ $tourImageUrl }}" alt="{{ $booking->tour->title }}" class="w-full h-full object-cover">
                    </div>

                    <h3 class="font-bold text-gray-900 text-base leading-snug">{{ $booking->tour->title }}</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $durationLabel }}</p>

                    <div class="mt-5 pt-4 border-t border-gray-200">
                        <span class="text-sm font-semibold text-gray-600">Total amount</span>
                        <span class="block mt-1 text-xl font-bold text-[#CC1021]">
                            {{ (strtoupper($booking->currency ?? '') === 'EUR' ? '€' : ($booking->currency ?? '')) }}{{ number_format($booking->total_amount, 2) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Next steps info band --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-sm font-bold text-gray-900 mb-4">What happens next?</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#CC1021]/10 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-envelope text-[#CC1021] text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Confirmation email</p>
                        <p class="text-xs text-gray-500 mt-0.5">Check your inbox for booking details and voucher.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#CC1021]/10 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-phone text-[#CC1021] text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">We'll reach out</p>
                        <p class="text-xs text-gray-500 mt-0.5">Our team will contact you 24h before the tour.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#CC1021]/10 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-map-location-dot text-[#CC1021] text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Enjoy your tour</p>
                        <p class="text-xs text-gray-500 mt-0.5">Meet your guide at the pickup location and go!</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
