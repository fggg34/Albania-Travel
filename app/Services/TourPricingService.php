<?php

namespace App\Services;

use App\Models\Tour;

class TourPricingService
{
    /**
     * Get price per person and total for a given number of travelers.
     * Returns: ['price_per_person' => float, 'total' => float, 'tier_applied' => TourPricingTier|null, 'currency' => string]
     */
    public function calculateForGuests(Tour $tour, int $guestCount): array
    {
        $guestCount = max(1, $guestCount);
        $basePrice = (float) ($tour->base_price ?? $tour->price ?? 0);
        $currency = $tour->currency ?? 'EUR';

        $tier = $tour->pricingTiers
            ->sortByDesc('min_people')
            ->first(fn ($t) => $t->matches($guestCount));

        $pricePerPerson = $tier
            ? (float) $tier->price_per_person
            : $basePrice;

        $total = round($pricePerPerson * $guestCount, 2);

        return [
            'price_per_person' => $pricePerPerson,
            'total' => $total,
            'tier_applied' => $tier,
            'currency' => $currency,
            'guest_count' => $guestCount,
        ];
    }
}
