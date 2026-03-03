<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    protected $table = 'about_page';

    protected $fillable = [
        'hero_image', 'hero_title', 'hero_subtitle',
        'story_image', 'story_eyebrow', 'story_heading', 'story_content', 'story_quote',
        'stat_1_number', 'stat_1_label', 'stat_2_number', 'stat_2_label',
        'stat_3_number', 'stat_3_label', 'stat_4_number', 'stat_4_label',
        'values_eyebrow', 'values_heading', 'values_intro',
        'value_1_icon', 'value_1_title', 'value_1_text',
        'value_2_icon', 'value_2_title', 'value_2_text',
        'value_3_icon', 'value_3_title', 'value_3_text',
        'team_eyebrow', 'team_heading',
        'team_1_image', 'team_1_name', 'team_1_role', 'team_1_region',
        'team_2_image', 'team_2_name', 'team_2_role', 'team_2_region',
        'cta_heading', 'cta_text', 'cta_btn_1_text', 'cta_btn_1_url', 'cta_btn_2_text', 'cta_btn_2_url',
        'meta_title', 'meta_description',
    ];

    public function getHeroImageUrlAttribute(): ?string
    {
        return $this->hero_image ? '/storage/' . ltrim($this->hero_image, '/') : null;
    }

    public function getStoryImageUrlAttribute(): ?string
    {
        return $this->story_image ? '/storage/' . ltrim($this->story_image, '/') : null;
    }

    public function getTeam1ImageUrlAttribute(): ?string
    {
        return $this->team_1_image ? '/storage/' . ltrim($this->team_1_image, '/') : null;
    }

    public function getTeam2ImageUrlAttribute(): ?string
    {
        return $this->team_2_image ? '/storage/' . ltrim($this->team_2_image, '/') : null;
    }

    public static function getInstance(): self
    {
        $page = static::first();
        if (!$page) {
            $page = new static([
                'hero_title' => 'About Us',
                'hero_subtitle' => 'Get to know us — your trusted Albania travel partner.',
                'story_eyebrow' => 'The Beginning',
                'story_heading' => 'Born from a deep-rooted love for the Land of Eagles.',
                'values_eyebrow' => 'Our Philosophy',
                'values_heading' => 'How we travel differently',
                'team_eyebrow' => 'The Experts',
                'team_heading' => 'Meet Your Local Guides',
                'cta_heading' => 'Ready to write your story?',
                'cta_text' => "Pick a tour, choose a date, or simply reach out — we'll take care of everything else.",
                'cta_btn_1_text' => 'Browse All Tours',
                'cta_btn_1_url' => '/tours',
                'cta_btn_2_text' => 'Get in Touch',
                'cta_btn_2_url' => '/contact',
            ]);
            $page->save();
        }
        return $page;
    }
}
