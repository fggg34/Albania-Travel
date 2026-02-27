<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageAbout extends Model
{
    protected $table = 'homepage_about';

    protected $fillable = [
        'title',
        'description',
        'image_1',
        'image_2',
        'highlight_text',
        'highlight_subtext',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getImage1UrlAttribute(): ?string
    {
        if (empty($this->image_1)) {
            return null;
        }
        return '/storage/' . ltrim($this->image_1, '/');
    }

    public function getImage2UrlAttribute(): ?string
    {
        if (empty($this->image_2)) {
            return null;
        }
        return '/storage/' . ltrim($this->image_2, '/');
    }

    public static function getActive(): ?self
    {
        return static::where('is_active', true)->first();
    }
}
