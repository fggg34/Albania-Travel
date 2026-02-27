<?php

namespace Database\Seeders;

use App\Models\TourInfoPoint;
use Illuminate\Database\Seeder;

class TourInfoPointSeeder extends Seeder
{
    public function run(): void
    {
        $points = [
            ['title' => 'Authentic Albania Experience', 'description' => 'Plan your Albania tour with peace of mind', 'sort_order' => 0],
            ['title' => 'Local Expert Guides', 'description' => 'Professional service from local experts', 'sort_order' => 1],
            ['title' => '5 Stars On TripAdvisor', 'description' => 'We are proud of our service quality and great reviews', 'sort_order' => 2],
            ['title' => 'Awarded Tour Company', 'description' => 'Our packages can be tailored to suit your needs', 'sort_order' => 3],
        ];

        TourInfoPoint::query()->delete();
        foreach ($points as $point) {
            TourInfoPoint::create(array_merge($point, ['icon' => null]));
        }
    }
}
