<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Tour;
use App\Models\TourCategory;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::where('is_active', true)->with(['category', 'cities', 'city', 'images', 'approvedReviews']);

        if ($request->filled('city')) {
            $query->whereHas('cities', fn ($q) => $q->where('slug', $request->city));
        }
        if ($request->filled('adults')) {
            $adults = (int) $request->adults;
            if ($adults >= 1) {
                $query->where(function ($q) use ($adults) {
                    $q->whereNull('max_group_size')->orWhere('max_group_size', '>=', $adults);
                });
            }
        }
        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->max_price);
        }
        if ($request->filled('duration')) {
            if ($request->duration === 'day') {
                $query->whereNotNull('duration_hours');
            } elseif ($request->duration === 'multi') {
                $query->whereNotNull('duration_days');
            }
        }
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(fn ($qry) => $qry->where('title', 'like', "%{$search}%")->orWhere('short_description', 'like', "%{$search}%"));
        }

        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'price_low' => $query->orderBy('price'),
            'price_high' => $query->orderByDesc('price'),
            'popular' => $query->withCount('bookings')->orderByDesc('bookings_count'),
            default => $query->orderByDesc('created_at'),
        };

        // Tours are always available for all dates — no date filtering
        $tours = $query->paginate(12)->withQueryString();
        $categories = TourCategory::orderBy('sort_order')->get();
        $cities = City::active()->orderBy('name')->get();
        $wishlistedIds = auth()->user()?->wishlistTours()->pluck('tours.id')->toArray() ?? [];

        return view('pages.tours.index', compact('tours', 'categories', 'cities', 'wishlistedIds'));
    }

    public function show(string $slug)
    {
        $tour = Tour::where('slug', $slug)->where('is_active', true)
            ->with(['category', 'images', 'itineraries.hotel', 'pricingTiers', 'dates' => fn ($q) => $q->where('is_active', true)->where('date', '>=', now())->orderBy('date')])
            ->withCount(['approvedReviews'])
            ->firstOrFail();

        $tour->load('approvedReviews.user');

        return view('pages.tours.show', compact('tour'));
    }
}
