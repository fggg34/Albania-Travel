<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\City;
use App\Models\HomepageHero;
use App\Models\Tour;
use App\Models\TourCategory;

class HomeController extends Controller
{
    public function __invoke()
    {
        $hero = HomepageHero::getActive();
        $cities = City::active()->orderBy('name')->get();

        $featuredTours = Tour::where('is_active', true)->where('is_featured', true)
            ->with(['category', 'images', 'approvedReviews'])
            ->orderBy('sort_order')
            ->limit(12)
            ->get();

        $wishlistedIds = auth()->user()?->wishlistTours()->pluck('tours.id')->toArray() ?? [];

        $destinationCities = City::active()
            ->whereHas('tours', fn ($q) => $q->where('is_active', true))
            ->withCount(['tours' => fn ($q) => $q->where('is_active', true)])
            ->orderByDesc('tours_count')
            ->limit(12)
            ->get();

        if ($destinationCities->isEmpty()) {
            $destinationCities = City::active()->orderBy('name')->limit(12)->get();
        }

        $categories = TourCategory::orderBy('sort_order')->get();

        $latestPosts = BlogPost::where('is_published', true)
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('pages.home', compact('hero', 'cities', 'featuredTours', 'wishlistedIds', 'destinationCities', 'categories', 'latestPosts'));
    }
}
