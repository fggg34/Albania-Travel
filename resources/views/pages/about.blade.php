@extends('layouts.site')

@section('title', 'About Us — ' . $siteName)
@section('description', 'Learn about ' . $siteName . ' – your trusted Albania travel partner.')

@section('hero')
@php $heroBg = $aboutPage->hero_image_url ?: asset('storage/heroes/breadcrumb.jpg'); @endphp
<section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $heroBg }}');"></div>
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight">{{ $aboutPage->hero_title ?? 'About Us' }}</h1>
        <p class="mt-3 text-white/75 text-base max-w-xl leading-relaxed">{{ $aboutPage->hero_subtitle ?? 'Get to know ' . $siteName . ' — your trusted Albania travel partner, crafting authentic local journeys.' }}</p>
    </div>
</section>
@endsection

@section('content')

{{-- STORY --}}
<section class="py-24 bg-[#F0F6F3] overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div class="relative w-full aspect-[4/5] max-h-[55vh]">
                <div class="absolute inset-0 bg-brand-100/50 rounded-[2rem]"></div>
                <div class="absolute inset-0 rounded-[2rem] overflow-hidden shadow-2xl bg-gray-200">
                    @if($aboutPage->story_image_url)
                        <img src="{{ $aboutPage->story_image_url }}" alt="" class="absolute inset-0 w-full h-full object-cover" />
                    @else
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 p-10 bg-gray-100">
                            <i class="fa-solid fa-camera-retro text-5xl mb-4 opacity-20"></i>
                            <p class="text-xs uppercase tracking-widest font-bold">Local Experience Photo</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="lg:pl-10">
                @if($aboutPage->story_eyebrow)
                    <span class="text-sm font-bold tracking-[0.2em] uppercase text-[#CC1021] mb-4 block">{{ $aboutPage->story_eyebrow }}</span>
                @endif
                @if($aboutPage->story_heading)
                    <h2 class="text-4xl font-bold text-slate-800 mb-8 leading-tight">{{ $aboutPage->story_heading }}</h2>
                @endif
                <div class="space-y-6 text-slate-600 text-lg leading-relaxed prose prose-lg max-w-none">
                    @if($aboutPage->story_content)
                        {!! $aboutPage->story_content !!}
                    @else
                        <p>{{ $siteName }} was founded on a simple conviction: Albania's landscapes, culture, and people deserve to be shared with the world — authentically, and by those who call this land home.</p>
                        <p>From the turquoise hidden coves of the <strong>Ionian Sea</strong> to the ancient stone corridors of <strong>Gjirokastër</strong>, we don't just show you the sights; we introduce you to the soul of our country.</p>
                    @endif
                    @if($aboutPage->story_quote)
                        <p class="italic text-brand-700 font-medium">"{{ $aboutPage->story_quote }}"</p>
                    @else
                        <p class="italic text-brand-700 font-medium">"We don't sell tours; we build bridges between cultures."</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- STATS --}}
@php
    $stats = [
        [$aboutPage->stat_1_number, $aboutPage->stat_1_label],
        [$aboutPage->stat_2_number, $aboutPage->stat_2_label],
        [$aboutPage->stat_3_number, $aboutPage->stat_3_label],
        [$aboutPage->stat_4_number, $aboutPage->stat_4_label],
    ];
    $stats = array_filter($stats, fn($s) => !empty($s[0]) || !empty($s[1]));
@endphp
@if(count($stats) > 0)
<section class="py-16 bg-slate-900">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach($stats as $index => $s)
            <div class="text-center {{ $index < count($stats) - 1 ? 'border-r border-white/10' : '' }}">
                <span class="block text-4xl font-black text-white mb-1">{{ $s[0] ?? '' }}</span>
                <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-brand-400">{{ $s[1] ?? '' }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>
@else
<section class="py-16 bg-slate-900">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach([['10+', 'Years Experience'], ['50+', 'Local Secrets'], ['1k+', 'Happy Guests'], ['100%', 'Local Guides']] as $index => $s)
            <div class="text-center {{ $index < 3 ? 'border-r border-white/10' : '' }}">
                <span class="block text-4xl font-black text-white mb-1">{{ $s[0] }}</span>
                <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-brand-400">{{ $s[1] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- VALUES --}}
@php
    $values = [
        [$aboutPage->value_1_icon, $aboutPage->value_1_title, $aboutPage->value_1_text],
        [$aboutPage->value_2_icon, $aboutPage->value_2_title, $aboutPage->value_2_text],
        [$aboutPage->value_3_icon, $aboutPage->value_3_title, $aboutPage->value_3_text],
    ];
    $values = array_filter($values, fn($v) => !empty($v[1]) || !empty($v[2]));
@endphp
@if(count($values) > 0)
<section class="py-32 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="max-w-xl">
                @if($aboutPage->values_eyebrow)
                    <span class="text-sm font-bold tracking-[0.2em] uppercase text-[#CC1021] mb-4 block">{{ $aboutPage->values_eyebrow }}</span>
                @endif
                @if($aboutPage->values_heading)
                    <h2 class="text-4xl font-bold text-slate-800 leading-tight">{{ $aboutPage->values_heading }}</h2>
                @endif
            </div>
            @if($aboutPage->values_intro)
                <p class="text-slate-500 max-w-xs text-sm leading-relaxed">{{ $aboutPage->values_intro }}</p>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($values as $v)
            <div class="group p-10 rounded-3xl bg-[#F9F9F4] border border-transparent hover:border-brand-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                <div class="w-14 h-14 mb-8 rounded-2xl bg-[#CC1021] flex items-center justify-center group-hover:rotate-12 transition-transform">
                    <i class="fa-solid {{ $v[0] ?? 'fa-star' }} text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-4">{{ $v[1] ?? '' }}</h3>
                <p class="text-slate-600 leading-relaxed text-sm">{{ $v[2] ?? '' }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@else
<section class="py-32 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="max-w-xl">
                <span class="text-sm font-bold tracking-[0.2em] uppercase text-[#CC1021] mb-4 block">Our Philosophy</span>
                <h2 class="text-4xl font-bold text-slate-800 leading-tight">How we travel differently</h2>
            </div>
            <p class="text-slate-500 max-w-xs text-sm leading-relaxed">Sustainability and cultural respect aren't just buzzwords for us—they are the foundation of every mile we cover.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([['fa-compass', 'Authenticity', 'We skip the tourist traps for family tables and honest conversations.'], ['fa-person-hiking', 'Adventure', 'From sea-kayaking the Riviera to trekking the Accursed Mountains.'], ['fa-shield-halved', 'Safety First', 'Certified guides and vetted routes so you can focus on the view.']] as $v)
            <div class="group p-10 rounded-3xl bg-[#F9F9F4] border border-transparent hover:border-brand-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                <div class="w-14 h-14 mb-8 rounded-2xl bg-[#CC1021] flex items-center justify-center group-hover:rotate-12 transition-transform">
                    <i class="fa-solid {{ $v[0] }} text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-4">{{ $v[1] }}</h3>
                <p class="text-slate-600 leading-relaxed text-sm">{{ $v[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- TEAM --}}
@php
    $team = [
        ['img' => $aboutPage->team_1_image_url, 'name' => $aboutPage->team_1_name, 'role' => $aboutPage->team_1_role, 'region' => $aboutPage->team_1_region],
        ['img' => $aboutPage->team_2_image_url, 'name' => $aboutPage->team_2_name, 'role' => $aboutPage->team_2_role, 'region' => $aboutPage->team_2_region],
    ];
    $team = array_filter($team, fn($t) => !empty($t['name']) || !empty($t['role']));
@endphp
@if(count($team) > 0)
<section class="py-24 bg-[#F0F6F3]/50">
    <div class="max-w-7xl mx-auto px-6">
        @if(count($team) === 1)
        {{-- Single member: split layout — text left, image right --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="relative lg:pr-6">
                @if($aboutPage->team_eyebrow)
                    <span class="text-sm font-bold tracking-[0.2em] uppercase text-[#CC1021] mb-4 block">{{ $aboutPage->team_eyebrow }}</span>
                @endif
                @if($aboutPage->team_heading)
                    <h2 class="text-4xl font-bold text-slate-800 mb-6 leading-tight">{{ $aboutPage->team_heading }}</h2>
                @endif
                <h3 class="text-2xl font-bold text-slate-800 mb-3">{{ $team[0]['name'] ?? '' }}</h3>
                @if(!empty($team[0]['role']))
                    <p class="text-base text-[#CC1021] font-semibold mb-4">{{ $team[0]['role'] }}</p>
                @endif
                @if(!empty($team[0]['region']))
                    <p class="text-slate-500 flex items-center gap-2 mb-6">
                        <i class="fa-solid fa-location-dot text-slate-400"></i>
                        Expert of {{ $team[0]['region'] }}
                    </p>
                @endif
                <div class="h-px bg-slate-200/80 w-16 mb-6"></div>
                <p class="text-slate-600 leading-relaxed max-w-lg">
                    {{ $siteName }} is built by people who live and breathe Albania. Every tour is designed and guided by locals who know the hidden gems, the best stories, and the warmest welcomes.
                </p>
            </div>
            <div class="relative">
                <div class="relative w-full aspect-[4/5] max-h-[55vh] overflow-hidden rounded-[2rem] bg-slate-200 shadow-xl">
                    @if(!empty($team[0]['img']))
                        <img src="{{ $team[0]['img'] }}" alt="{{ $team[0]['name'] ?? '' }}" class="absolute inset-0 w-full h-full object-cover" />
                    @else
                        <div class="absolute inset-0 flex items-center justify-center bg-slate-300">
                            <i class="fa-solid fa-user text-white text-6xl opacity-30"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @else
        {{-- Multiple members: grid --}}
        <div class="text-center mb-16">
            @if($aboutPage->team_eyebrow)
                <span class="text-sm font-bold tracking-[0.2em] uppercase text-[#CC1021] mb-4 block">{{ $aboutPage->team_eyebrow }}</span>
            @endif
            @if($aboutPage->team_heading)
                <h2 class="text-4xl font-bold text-slate-800">{{ $aboutPage->team_heading }}</h2>
            @endif
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            @foreach($team as $m)
            <div class="group">
                <div class="relative overflow-hidden rounded-2xl mb-6 aspect-[4/3] bg-slate-200">
                    @if(!empty($m['img']))
                        <img src="{{ $m['img'] }}" alt="{{ $m['name'] ?? '' }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                    @else
                        <div class="absolute inset-0 bg-slate-300 flex items-center justify-center">
                            <i class="fa-solid fa-user text-white text-5xl opacity-30"></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                <h3 class="text-xl font-bold text-slate-800">{{ $m['name'] ?? '' }}</h3>
                @if(!empty($m['role']))
                    <p class="text-sm text-brand-600 font-semibold mb-2">{{ $m['role'] }}</p>
                @endif
                @if(!empty($m['region']))
                    <p class="text-xs text-slate-400 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot"></i> Expert of {{ $m['region'] }}
                    </p>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
@else
<section class="py-24 bg-[#F0F6F3]/50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="relative lg:pr-6">
                <span class="text-sm font-bold tracking-[0.2em] uppercase text-[#CC1021] mb-4 block">The Expert</span>
                <h2 class="text-4xl font-bold text-slate-800 mb-6 leading-tight">Meet Your Local Guide</h2>
                <h3 class="text-2xl font-bold text-slate-800 mb-3">Sonila Kosta</h3>
                <p class="text-base text-[#CC1021] font-semibold mb-4">Founder & Lead Guide</p>
                <p class="text-slate-500 flex items-center gap-2 mb-6">
                    <i class="fa-solid fa-location-dot text-slate-400"></i>
                    Expert of Albanian Riviera
                </p>
                <div class="h-px bg-slate-200/80 w-16 mb-6"></div>
                <p class="text-slate-600 leading-relaxed max-w-lg">
                    {{ $siteName }} is built by people who live and breathe Albania. Every tour is designed and guided by locals who know the hidden gems, the best stories, and the warmest welcomes.
                </p>
            </div>
            <div class="relative">
                <div class="relative w-full aspect-[4/5] max-h-[55vh] overflow-hidden rounded-[2rem] bg-slate-200 shadow-xl">
                    <div class="absolute inset-0 flex items-center justify-center bg-slate-300">
                        <i class="fa-solid fa-user text-white text-6xl opacity-30"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="bg-[#cc1021e6] rounded-[3rem] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/5 rounded-full -ml-32 -mb-32"></div>

            <div class="relative z-10">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">{{ $aboutPage->cta_heading ?? 'Ready to write your story?' }}</h2>
                <p class="text-lg text-brand-50/90 mb-12 max-w-xl mx-auto">
                    {{ $aboutPage->cta_text ?? "Pick a tour, choose a date, or simply reach out — we'll take care of everything else." }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ $aboutPage->cta_btn_1_url ? (str_starts_with($aboutPage->cta_btn_1_url, '/') ? url($aboutPage->cta_btn_1_url) : $aboutPage->cta_btn_1_url) : route('tours.index') }}"
                       class="px-12 py-4 text-sm font-bold rounded-full bg-white text-[#CC1021] hover:bg-brand-50 transition shadow-lg">
                        {{ $aboutPage->cta_btn_1_text ?? 'Browse All Tours' }}
                    </a>
                    <a href="{{ $aboutPage->cta_btn_2_url ? (str_starts_with($aboutPage->cta_btn_2_url, '/') ? url($aboutPage->cta_btn_2_url) : $aboutPage->cta_btn_2_url) : route('contact') }}"
                       class="px-12 py-4 text-sm font-bold rounded-full border-2 border-white text-white hover:bg-white hover:text-[#CC1021] transition">
                        {{ $aboutPage->cta_btn_2_text ?? 'Get in Touch' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
