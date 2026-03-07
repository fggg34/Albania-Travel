@extends('emails.layout')

@section('title', 'Welcome - ' . \App\Models\Setting::get('site_name', config('app.name')))

@section('header')
<div style="background: #CC1021; color: #ffffff; padding: 28px 24px; text-align: center;">
    <h1 style="margin: 0; font-size: 24px; font-weight: 700;">Welcome aboard!</h1>
    <p style="margin: 8px 0 0; opacity: 0.95; font-size: 15px;">{{ \App\Models\Setting::get('site_name', config('app.name')) }}</p>
    <p style="margin: 16px 0 0; font-size: 13px; opacity: 0.9;">{{ \App\Models\Setting::get('site_tagline', 'Discover your next adventure') }}</p>
</div>
@endsection

@section('content')
<p style="margin: 0 0 20px; font-size: 15px;">Hello <strong>{{ $user->name }}</strong>,</p>
<p style="margin: 0 0 24px; color: #6b7280;">Thank you for creating an account with us. We're excited to have you join our community of travelers.</p>

<p style="margin: 0 0 16px; font-size: 14px; color: #374151;">With your account you can:</p>
<ul style="margin: 0 0 24px; padding-left: 20px; font-size: 14px; color: #6b7280; line-height: 1.8;">
    <li>Browse and book tours</li>
    <li>Save tours to your wishlist</li>
    <li>Manage your bookings</li>
    <li>Leave reviews after your trips</li>
</ul>

<div style="margin-top: 24px; text-align: center;">
    <a href="{{ route('tours.index') }}" class="btn">Explore our tours</a>
</div>
<div style="margin-top: 12px; text-align: center;">
    <a href="{{ route('dashboard') }}" style="color: #CC1021; font-weight: 600; font-size: 14px;">Go to your dashboard</a>
</div>
@endsection
