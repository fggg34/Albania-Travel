<?php

namespace Database\Seeders;

use App\Models\AboutPage;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        if (AboutPage::exists()) {
            return;
        }

        AboutPage::create([
            'hero_title'    => 'About Us',
            'hero_subtitle' => 'Get to know us — your trusted Albania travel partner, crafting authentic local journeys.',
            'story_eyebrow' => 'The Beginning',
            'story_heading' => 'Born from a deep-rooted love for the Land of Eagles.',
            'story_content' => '<p>Albania Travel by Sonila Kosta was founded on a simple conviction: Albania\'s landscapes, culture, and people deserve to be shared with the world — authentically, and by those who call this land home.</p>
<p>From the turquoise hidden coves of the <strong>Ionian Sea</strong> to the ancient stone corridors of <strong>Gjirokastër</strong>, we don\'t just show you the sights; we introduce you to the soul of our country.</p>',
            'story_quote'   => "We don't sell tours; we build bridges between cultures.",
            'stat_1_number' => '10+',
            'stat_1_label'  => 'Years Experience',
            'stat_2_number' => '50+',
            'stat_2_label'  => 'Local Secrets',
            'stat_3_number' => '1k+',
            'stat_3_label'  => 'Happy Guests',
            'stat_4_number' => '100%',
            'stat_4_label'  => 'Local Guides',
            'values_eyebrow' => 'Our Philosophy',
            'values_heading' => 'How we travel differently',
            'values_intro'  => "Sustainability and cultural respect aren't just buzzwords for us—they are the foundation of every mile we cover.",
            'value_1_icon'  => 'fa-compass',
            'value_1_title' => 'Authenticity',
            'value_1_text'  => 'We skip the tourist traps for family tables and honest conversations.',
            'value_2_icon'  => 'fa-person-hiking',
            'value_2_title' => 'Adventure',
            'value_2_text'  => 'From sea-kayaking the Riviera to trekking the Accursed Mountains.',
            'value_3_icon'  => 'fa-shield-halved',
            'value_3_title' => 'Safety First',
            'value_3_text'  => 'Certified guides and vetted routes so you can focus on the view.',
            'team_eyebrow'  => 'The Experts',
            'team_heading'  => 'Meet Your Local Guides',
            'team_1_name'   => 'Sonila Kosta',
            'team_1_role'   => 'Founder & Lead Guide',
            'team_1_region'  => 'Albanian Riviera',
            'team_2_name'   => 'Artan Berisha',
            'team_2_role'   => 'Senior Mountain Expert',
            'team_2_region' => 'Valbona Valley',
            'cta_heading'   => 'Ready to write your story?',
            'cta_text'      => "Pick a tour, choose a date, or simply reach out — we'll take care of everything else.",
            'cta_btn_1_text' => 'Browse All Tours',
            'cta_btn_1_url'  => '/tours',
            'cta_btn_2_text' => 'Get in Touch',
            'cta_btn_2_url'  => '/contact',
        ]);
    }
}
