<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourInfoPoint extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function getIconUrlAttribute(): ?string
    {
        if (empty($this->icon)) {
            return null;
        }
        return '/storage/' . ltrim($this->icon, '/');
    }

    public static function ordered(): \Illuminate\Database\Eloquent\Builder
    {
        return static::orderBy('sort_order');
    }
}
