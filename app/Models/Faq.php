<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'category',
        'category_icon',
        'category_sort',
        'question',
        'answer',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active'      => 'boolean',
            'sort_order'     => 'integer',
            'category_sort'  => 'integer',
        ];
    }

    public static function grouped(): \Illuminate\Support\Collection
    {
        return static::where('is_active', true)
            ->orderBy('category_sort')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');
    }
}
