@extends('layouts.site')

@section('title', 'Contact - ' . config('app.name'))
@section('description', 'Get in touch with us.')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Contact us</h1>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-800 rounded-lg">{{ session('success') }}</div>
    @endif

    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
            @error('subject')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
            <textarea name="message" id="message" rows="5" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('message') }}</textarea>
            @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-amber-600 text-white font-medium rounded-lg hover:bg-amber-700">Send message</button>
    </form>

    <div class="mt-12 p-6 bg-gray-50 rounded-xl">
        <h2 class="font-semibold text-gray-900 mb-2">Contact details</h2>
        <p>{{ \App\Models\Setting::get('contact_email', '') }}</p>
        <p>{{ \App\Models\Setting::get('contact_phone', '') }}</p>
        <p>{{ \App\Models\Setting::get('contact_address', '') }}</p>
    </div>
</div>
@endsection
