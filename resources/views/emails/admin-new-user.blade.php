@extends('emails.layout')

@section('title', 'New account created - ' . \App\Models\Setting::get('site_name', config('app.name')))

@section('header')
<div style="background: #CC1021; color: #ffffff; padding: 24px; text-align: center;">
    <h1 style="margin: 0; font-size: 20px; font-weight: 700;">New account created</h1>
    <p style="margin: 8px 0 0; font-size: 14px; opacity: 0.9;">{{ \App\Models\Setting::get('site_name', config('app.name')) }}</p>
</div>
@endsection

@section('content')
<p style="margin: 0 0 20px; font-size: 14px;">A new user has registered on your site.</p>

<table class="email-table">
    <tr><td colspan="2" style="padding: 8px 16px; background: #fff1f2; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #CC1021;">Account details</td></tr>
    <tr class="detail-row">
        <td class="detail-label">Name</td>
        <td class="detail-value"><strong>{{ $user->name }}</strong></td>
    </tr>
    <tr class="detail-row">
        <td class="detail-label">Email</td>
        <td class="detail-value">{{ $user->email }}</td>
    </tr>
    <tr class="detail-row">
        <td class="detail-label">Registered at</td>
        <td class="detail-value">{{ $user->created_at->format('l, F j, Y \a\t g:i A') }}</td>
    </tr>
</table>

<div style="margin-top: 24px; text-align: center;">
    <a href="{{ url(config('app.filament_admin_path', 'admin') . '/users') }}" class="btn">View in admin panel</a>
</div>
@endsection
