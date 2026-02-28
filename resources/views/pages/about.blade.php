@extends('layouts.site')

@php
    $siteName = \App\Models\Setting::get('site_name', config('app.name'));
@endphp

@section('title', 'About Us — ' . $siteName)
@section('description', 'Learn about ' . $siteName . ' – your trusted Albania travel partner.')

@section('content')

{{-- HERO --}}
<section class="relative min-h-[85vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center scale-105"
         style="background-image: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80');"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-[#0D9488]/50 to-[#0D9488]/70"></div>
    
    <div class="relative z-10 w-full max-w-5xl mx-auto px-6 pt-20 text-center">
        <span class="inline-block text-xs font-bold tracking-[0.3em] uppercase text-white/90 mb-4 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full">
            Our Heritage
        </span>
        <h1 class="text-5xl md:text-7xl font-extrabold text-white leading-[1.1] tracking-tight mb-8">
            Turning Travelers <br class="hidden md:block"> into <span class="text-teal-200">Storytellers</span>
        </h1>
        <p class="text-xl text-white/90 max-w-2xl mx-auto leading-relaxed mb-10">
            {{ $siteName }} — crafting deeply personal, authentically local Albanian journeys since day one.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('tours.index') }}"
               class="w-full sm:w-auto px-10 py-4 text-sm font-bold rounded-full text-[#0D9488] bg-white hover:bg-teal-50 transition-all shadow-2xl hover:scale-105 active:scale-95">
                Explore Our Tours
            </a>
        </div>
    </div>
</section>

{{-- STORY --}}
<section class="py-24 bg-[#FDFDF5]">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div class="relative group">
                <div class="absolute -inset-4 bg-teal-100/50 rounded-[2rem] rotate-2 transition group-hover:rotate-1"></div>
                <div class="relative rounded-2xl overflow-hidden shadow-2xl aspect-[4/5] bg-gray-200">
                    {{-- Replace with real image --}}
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 p-10 bg-gray-100">
                        <i class="fa-solid fa-camera-retro text-5xl mb-4 opacity-20"></i>
                        <p class="text-xs uppercase tracking-widest font-bold">Local Experience Photo</p>
                    </div>
                </div>
            </div>
            
            <div class="lg:pl-10">
                <span class="text-sm font-bold tracking-[0.2em] uppercase text-[#0D9488] mb-4 block">The Beginning</span>
                <h2 class="text-4xl font-bold text-slate-800 mb-8 leading-tight">Born from a deep-rooted love for the Land of Eagles.</h2>
                <div class="space-y-6 text-slate-600 text-lg leading-relaxed">
                    <p>
                        {{ $siteName }} was founded on a simple conviction: Albania's landscapes, culture, and people deserve to be shared with the world — authentically, and by those who call this land home.
                    </p>
                    <p>
                        From the turquoise hidden coves of the <strong>Ionian Sea</strong> to the ancient stone corridors of <strong>Gjirokastër</strong>, we don't just show you the sights; we introduce you to the soul of our country.
                    </p>
                    <p class="italic text-teal-700 font-medium">
                        "We don't sell tours; we build bridges between cultures."
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- STATS --}}
<section class="py-16 bg-slate-900">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach([
                ['10+', 'Years Experience'],
                ['50+', 'Local Secrets'],
                ['1k+', 'Happy Guests'],
                ['100%', 'Local Guides'],
            ] as $s)
            <div class="text-center border-r last:border-0 border-white/10">
                <span class="block text-4xl font-black text-white mb-1">{{ $s[0] }}</span>
                <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-teal-400">{{ $s[1] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- VALUES --}}
<section class="py-32 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="max-w-xl">
                <span class="text-sm font-bold tracking-[0.2em] uppercase text-[#0D9488] mb-4 block">Our Philosophy</span>
                <h2 class="text-4xl font-bold text-slate-800 leading-tight">How we travel differently</h2>
            </div>
            <p class="text-slate-500 max-w-xs text-sm leading-relaxed">
                Sustainability and cultural respect aren't just buzzwords for us—they are the foundation of every mile we cover.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['fa-compass', 'Authenticity', 'We skip the tourist traps for family tables and honest conversations.'],
                ['fa-person-hiking', 'Adventure', 'From sea-kayaking the Riviera to trekking the Accursed Mountains.'],
                ['fa-shield-halved', 'Safety First', 'Certified guides and vetted routes so you can focus on the view.'],
            ] as $v)
            <div class="group p-10 rounded-3xl bg-[#F9F9F4] border border-transparent hover:border-teal-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                <div class="w-14 h-14 mb-8 rounded-2xl bg-[#0D9488] flex items-center justify-center group-hover:rotate-12 transition-transform">
                    <i class="fa-solid {{ $v[0] }} text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-4">{{ $v[1] }}</h3>
                <p class="text-slate-600 leading-relaxed text-sm">{{ $v[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- TEAM --}}
<section class="py-24 bg-[#F5F5DC]/50">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <span class="text-sm font-bold tracking-[0.2em] uppercase text-[#0D9488] mb-4 block">The Experts</span>
        <h2 class="text-4xl font-bold text-slate-800 mb-16">Meet Your Local Guides</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            @foreach([
                ['Sonila Kosta', 'Founder & Lead Guide', 'Albanian Riviera'],
                ['Artan Berisha', 'Senior Mountain Expert', 'Valbona Valley'],
                ['Elira Duka', 'Tour Coordinator', 'The Old Bazaar'],
            ] as $m)
            <div class="text-left group">
                <div class="relative overflow-hidden rounded-2xl mb-6 aspect-[3/4] bg-slate-200">
                     <div class="absolute inset-0 bg-slate-300 flex items-center justify-center">
                         <i class="fa-solid fa-user text-white text-5xl opacity-30"></i>
                     </div>
                     <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                <h3 class="text-xl font-bold text-slate-800">{{ $m[0] }}</h3>
                <p class="text-sm text-teal-600 font-semibold mb-2">{{ $m[1] }}</p>
                <p class="text-xs text-slate-400 flex items-center gap-2">
                    <i class="fa-solid fa-location-dot"></i> Expert of {{ $m[2] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="bg-[#0D9488] rounded-[3rem] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl">
            {{-- Decorative circles --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/5 rounded-full -ml-32 -mb-32"></div>
            
            <div class="relative z-10">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Ready to write your story?</h2>
                <p class="text-lg text-teal-50/90 mb-12 max-w-xl mx-auto">
                    Pick a tour, choose a date, or simply reach out — we'll take care of everything else.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('tours.index') }}"
                       class="px-12 py-4 text-sm font-bold rounded-full bg-white text-[#0D9488] hover:bg-teal-50 transition shadow-lg">
                        Browse All Tours
                    </a>
                    <a href="{{ route('contact') }}"
                       class="px-12 py-4 text-sm font-bold rounded-full border-2 border-white text-white hover:bg-white hover:text-[#0D9488] transition">
                        Get in Touch
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection