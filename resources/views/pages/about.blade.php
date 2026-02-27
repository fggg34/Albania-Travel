@extends('layouts.site')

@section('title', 'About - ' . config('app.name'))
@section('description', 'Learn more about us and our mission.')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">About {{ \App\Models\Setting::get('site_name', config('app.name')) }}</h1>
    <div class="prose prose-lg max-w-none text-gray-600">
        <p>We are a tour agency dedicated to creating memorable travel experiences. Our expert guides and carefully crafted itineraries ensure you discover the best of each destination.</p>
        <h2 class="text-xl font-bold text-gray-900 mt-8">Our mission</h2>
        <p>To make travel accessible, enjoyable and sustainable by offering high-quality tours with a personal touch.</p>
        <h2 class="text-xl font-bold text-gray-900 mt-8">Why choose us</h2>
        <ul>
            <li>Local expert guides</li>
            <li>Small group sizes for a better experience</li>
            <li>Transparent pricing with no hidden fees</li>
            <li>Flexible booking and cancellation options</li>
        </ul>
    </div>
</div>
@endsection
