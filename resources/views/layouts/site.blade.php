<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $siteIcon = \App\Models\Setting::get('site_icon', '');
        $siteIconUrl = $siteIcon ? \Illuminate\Support\Facades\Storage::disk('public')->url($siteIcon) : null;
    @endphp
    @if($siteIconUrl)
    <link rel="icon" href="{{ $siteIconUrl }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ $siteIconUrl }}">
    @endif
    @stack('meta')
    @php
        $ogImagePath = \App\Models\Setting::get('seo_og_image');
    @endphp
    @if($ogImagePath)
    <meta property="og:image" content="{{ url(\Illuminate\Support\Facades\Storage::disk('public')->url($ogImagePath)) }}">
    @endif
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('description', \App\Models\Setting::get('site_tagline', 'Discover your next adventure'))">
    <link rel="canonical" href="{{ request()->url() }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    @include('layouts.partials.site-nav')

    @yield('hero')

    <main>
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    @stack('scripts')
</body>
</html>
