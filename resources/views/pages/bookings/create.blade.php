@extends('layouts.site')

@section('title', 'Complete your booking - ' . config('app.name'))

@section('content')
@php
    $displayDate = $booking_date ?? ($tourDate?->date?->format('l, F j, Y'));
    $dateForSummary = $booking_date ? \Carbon\Carbon::parse($booking_date) : $tourDate?->date;
    $displayDateTime = $dateForSummary ? $dateForSummary->format('d/m/Y') : '';
    $firstImage = $tour->images->first();
    $tourImageUrl = $firstImage && $firstImage->path ? $firstImage->url : 'https://placehold.co/1200x600?text=Tour';
    $durationDays = (int) ($tour->duration_days ?? 0);
    $durationLabel = $durationDays ? $durationDays . ' Day' . ($durationDays > 1 ? 's' : '') . ' Tour' : ($tour->duration_hours ? $tour->duration_hours . ' hours' : 'Tour');
    $total = $pricing['total'] ?? (($tourDate->price ?? $tour->base_price ?? $tour->price) * $guests);
@endphp

{{-- Top bar --}}
<div class="bg-white border-b border-gray-100">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center gap-4">
        <a href="{{ route('tours.show', $tour->slug) }}" class="flex items-center gap-2 text-sm text-gray-500 hover:text-[#0D9488] transition">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            Back to tour
        </a>
        <span class="text-gray-200">|</span>
        <nav class="flex items-center gap-2 text-xs text-gray-400">
            <span class="text-[#0D9488] font-semibold">1. Your details</span>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span>2. Confirmation</span>
        </nav>
    </div>
</div>

<div class="bg-gray-50 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Complete your booking</h1>
            <p class="mt-1 text-gray-500 text-sm">Fill in your details below to confirm your reservation.</p>
        </div>

        <form action="{{ route('bookings.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf
            @if($booking_date)
                <input type="hidden" name="booking_date" value="{{ $booking_date }}">
                <input type="hidden" name="tour_id" value="{{ $tour->id }}">
            @else
                <input type="hidden" name="tour_date_id" value="{{ $tourDate->id }}">
            @endif
            <input type="hidden" name="guest_count" value="{{ $guests }}">
            <input type="hidden" name="expected_total" value="{{ $total }}">

            {{-- Left column --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Lead Traveler --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-[#0D9488]/10 flex items-center justify-center">
                            <i class="fa-solid fa-user text-[#0D9488] text-sm"></i>
                        </div>
                        <div>
                            <h2 class="font-semibold text-gray-900 text-sm">Lead Traveler</h2>
                            <p class="text-xs text-gray-400">Your contact information for this booking</p>
                        </div>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="first_name" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">First name <span class="text-red-500">*</span></label>
                            <input type="text" name="first_name" id="first_name"
                                value="{{ old('first_name', auth()->user()?->name ? explode(' ', auth()->user()->name, 2)[0] : '') }}"
                                required
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#0D9488] focus:ring-1 focus:ring-[#0D9488] text-gray-900 text-sm py-2.5 px-3">
                            @error('first_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="last_name" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Last name <span class="text-red-500">*</span></label>
                            <input type="text" name="last_name" id="last_name"
                                value="{{ old('last_name', auth()->user()?->name ? (explode(' ', auth()->user()->name, 2)[1] ?? '') : '') }}"
                                required
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#0D9488] focus:ring-1 focus:ring-[#0D9488] text-gray-900 text-sm py-2.5 px-3">
                            @error('last_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="guest_email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Email address <span class="text-red-500">*</span></label>
                            <input type="email" name="guest_email" id="guest_email"
                                value="{{ old('guest_email', auth()->user()?->email) }}"
                                required placeholder="your@email.com"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#0D9488] focus:ring-1 focus:ring-[#0D9488] text-gray-900 text-sm py-2.5 px-3">
                            @error('guest_email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="email_confirmation" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Confirm email <span class="text-red-500">*</span></label>
                            <input type="email" name="email_confirmation" id="email_confirmation"
                                value="{{ old('email_confirmation', auth()->user()?->email) }}"
                                required placeholder="your@email.com"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#0D9488] focus:ring-1 focus:ring-[#0D9488] text-gray-900 text-sm py-2.5 px-3">
                            @error('email_confirmation')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="guest_phone" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Phone number</label>
                            <input
                                type="tel"
                                name="guest_phone"
                                id="guest_phone"
                                value="{{ old('guest_phone') }}"
                                placeholder="67 212 3456"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#0D9488] focus:ring-1 focus:ring-[#0D9488] text-gray-900 text-sm py-2.5 px-3"
                                autocomplete="tel"
                                data-initial-phone="{{ e(old('guest_phone', '')) }}"
                            >
                            @error('guest_phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="pickup_location" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Pickup location</label>
                            <input type="text" name="pickup_location" id="pickup_location"
                                value="{{ old('pickup_location') }}" placeholder="Hotel name or address"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#0D9488] focus:ring-1 focus:ring-[#0D9488] text-gray-900 text-sm py-2.5 px-3">
                            @error('pickup_location')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Billing Address --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-[#0D9488]/10 flex items-center justify-center">
                            <i class="fa-solid fa-location-dot text-[#0D9488] text-sm"></i>
                        </div>
                        <div>
                            <h2 class="font-semibold text-gray-900 text-sm">Billing Address</h2>
                            <p class="text-xs text-gray-400">For your booking records</p>
                        </div>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="billing_country" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Country</label>
                            <select name="billing_country" id="billing_country"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#0D9488] focus:ring-1 focus:ring-[#0D9488] text-gray-900 text-sm py-2.5 px-3">
                                <option value="">Select country…</option>
                                @foreach($countries ?? [] as $country)
                                    <option value="{{ $country['name'] }}" {{ old('billing_country') === $country['name'] ? 'selected' : '' }}>{{ $country['name'] }}</option>
                                @endforeach
                            </select>
                            @error('billing_country')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="billing_region" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">State / Region</label>
                            <input type="text" name="billing_region" id="billing_region"
                                value="{{ old('billing_region') }}" placeholder="State or region"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#0D9488] focus:ring-1 focus:ring-[#0D9488] text-gray-900 text-sm py-2.5 px-3">
                            @error('billing_region')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="billing_city" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">City</label>
                            <input type="text" name="billing_city" id="billing_city"
                                value="{{ old('billing_city') }}" placeholder="City"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#0D9488] focus:ring-1 focus:ring-[#0D9488] text-gray-900 text-sm py-2.5 px-3">
                            @error('billing_city')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="billing_address" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Street address</label>
                            <input type="text" name="billing_address" id="billing_address"
                                value="{{ old('billing_address') }}" placeholder="Street address"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#0D9488] focus:ring-1 focus:ring-[#0D9488] text-gray-900 text-sm py-2.5 px-3">
                            @error('billing_address')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Special requests --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-[#0D9488]/10 flex items-center justify-center">
                            <i class="fa-solid fa-comment-dots text-[#0D9488] text-sm"></i>
                        </div>
                        <div>
                            <h2 class="font-semibold text-gray-900 text-sm">Special Requests</h2>
                            <p class="text-xs text-gray-400">Optional — we'll do our best to accommodate</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <textarea name="special_requests" id="special_requests" rows="3"
                            placeholder="Dietary requirements, accessibility needs, special occasions…"
                            class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#0D9488] focus:ring-1 focus:ring-[#0D9488] text-gray-900 text-sm py-2.5 px-3 resize-none">{{ old('special_requests') }}</textarea>
                        @error('special_requests')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Trust signals + Submit --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 py-2">
                    <div class="flex flex-wrap gap-4 text-xs text-gray-500">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-shield-halved text-[#0D9488]"></i> Secure booking
                        </span>
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-bolt text-[#0D9488]"></i> Instant confirmation
                        </span>
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-headset text-[#0D9488]"></i> 24/7 support
                        </span>
                    </div>
                    <button type="submit"
                        class="flex-shrink-0 inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-[#0D9488] text-white font-semibold rounded-xl hover:bg-[#0b8277] transition shadow-sm text-sm">
                        <i class="fa-solid fa-lock text-xs opacity-80"></i>
                        Confirm Booking
                    </button>
                </div>
            </div>

            {{-- Right column: Tour Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden sticky top-24">
                    <div class="aspect-video bg-gray-100">
                        <img src="{{ $tourImageUrl }}" alt="{{ $tour->title }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-5 space-y-4">
                        <div>
                            <h3 class="font-bold text-gray-900 text-base leading-snug">{{ $tour->title }}</h3>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $durationLabel }}</p>
                        </div>

                        @if($tour->approvedReviews->count() > 0)
                            <p class="flex items-center gap-1.5 text-sm">
                                <span class="flex text-amber-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span>{{ $i <= round($tour->average_rating ?? 0) ? '★' : '☆' }}</span>
                                    @endfor
                                </span>
                                <span class="text-gray-500 text-xs">({{ $tour->approvedReviews->count() }} reviews)</span>
                            </p>
                        @endif

                        <div class="space-y-2.5 text-sm text-gray-600 pt-1">
                            <div class="flex items-center gap-2">
                                <i class="fa-regular fa-calendar w-4 text-[#0D9488] flex-shrink-0"></i>
                                <span>{{ $displayDateTime }}@if($tour->start_time) at {{ \Carbon\Carbon::parse($tour->start_time)->format('g:i A') }}@endif</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-regular fa-clock w-4 text-[#0D9488] flex-shrink-0"></i>
                                <span>{{ $durationDays ? $durationDays . ' days' : ($tour->duration_hours ? $tour->duration_hours . ' hours' : '—') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-users w-4 text-[#0D9488] flex-shrink-0"></i>
                                <span>{{ $guests }} {{ Str::plural('traveler', $guests) }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="font-semibold text-gray-700">Total</span>
                            <span class="text-xl font-bold text-[#0D9488]">€{{ number_format($total, 0) }}</span>
                        </div>

                        <div class="flex items-center gap-2 text-xs text-green-600 bg-green-50 rounded-lg px-3 py-2">
                            <i class="fa-solid fa-circle-check flex-shrink-0"></i>
                            <span class="font-medium">Instant confirmation after booking</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@26/build/css/intlTelInput.min.css">
<style>
.iti.iti--allow-dropdown.iti--show-flags.iti--inline-dropdown {
    width: 100%;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@26/build/js/intlTelInput.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var input = document.getElementById('guest_phone');
  if (!input || !window.intlTelInput) return;

  var initialNumber = input.getAttribute('data-initial-phone') || '';

  var iti = window.intlTelInput(input, {
    initialCountry: 'al',
    utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@26/build/js/utils.js'
  });

  if (initialNumber) {
    iti.setNumber(initialNumber);
  }

  var form = input.closest('form');
  if (form) {
    form.addEventListener('submit', function() {
      try {
        var data = iti.getSelectedCountryData();
        var dialCode = data && data.dialCode ? '+' + data.dialCode : '';
        var digits = (input.value || '').replace(/\D/g, '');
        if (dialCode && digits) {
          input.value = dialCode + digits;
        }
      } catch (e) {}
    });
  }
});
</script>
@endpush
@endsection
