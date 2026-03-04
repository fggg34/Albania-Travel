@extends('emails.layout')

@section('title', 'New review pending approval - ' . \App\Models\Setting::get('site_name', config('app.name')))

@section('header')
<div style="background: #CC1021; color: #ffffff; padding: 24px; text-align: center;">
    <h1 style="margin: 0; font-size: 20px; font-weight: 700;">New review pending approval</h1>
    <p style="margin: 8px 0 0; font-size: 14px; opacity: 0.9;">{{ $review->tour->title }}</p>
    <p style="margin: 4px 0 0; font-size: 12px; opacity: 0.8;">by {{ $review->user?->name ?? 'Guest' }}</p>
</div>
@endsection

@section('content')
<p style="margin: 0 0 20px; font-size: 14px;">A new review has been submitted and is pending your approval.</p>

<table class="email-table">
    <tr><td colspan="2" style="padding: 8px 16px; background: #fff1f2; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #CC1021;">Review details</td></tr>
    <tr class="detail-row">
        <td class="detail-label">Tour</td>
        <td class="detail-value"><strong>{{ $review->tour->title }}</strong></td>
    </tr>
    <tr class="detail-row">
        <td class="detail-label">Reviewer</td>
        <td class="detail-value">{{ $review->user?->name ?? 'Guest' }} ({{ $review->user?->email ?? '—' }})</td>
    </tr>
    <tr class="detail-row">
        <td class="detail-label">Rating</td>
        <td class="detail-value">{{ $review->rating }}/5</td>
    </tr>
    <tr class="detail-row">
        <td class="detail-label">Title</td>
        <td class="detail-value">{{ $review->title }}</td>
    </tr>
    <tr class="detail-row">
        <td class="detail-label">Review</td>
        <td class="detail-value">{{ $review->comment }}</td>
    </tr>
</table>

@php
    $adminBaseUrl = request()->getSchemeAndHttpHost() ?: config('app.url');
    $adminReviewsUrl = rtrim($adminBaseUrl, '/') . '/' . trim(config('app.filament_admin_path', 'admin'), '/') . '/reviews';
@endphp
<div style="margin-top: 24px; text-align: center;">
    <a href="{{ $adminReviewsUrl }}" class="btn">View in admin panel</a>
</div>
@endsection
