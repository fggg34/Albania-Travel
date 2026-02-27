<?php

namespace Database\Seeders;

use App\Models\HomepageAbout;
use Illuminate\Database\Seeder;

class HomepageAboutSeeder extends Seeder
{
    public function run(): void
    {
        HomepageAbout::firstOrCreate(
            ['id' => 1],
            [
                'title' => 'About Us',
                'description' => "Founded with a passion for travel and a commitment to excellence, we have rapidly become one of Albania's most trusted tour companies.\n\nWith our strategically located bases across Albania, we offer more than just tours – we provide the keys to an unforgettable journey through Albania's stunning landscapes and vibrant culture.",
                'highlight_text' => '+10 years',
                'highlight_subtext' => 'Experience',
                'is_active' => true,
            ]
        );
    }
}
