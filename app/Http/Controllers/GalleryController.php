<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;

class GalleryController extends Controller
{
    public function __invoke()
    {
        $images = GalleryImage::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $categories = GalleryImage::activeCategories();

        $imagesJson = $images->map(function ($img) {
            return [
                'url'      => $img->image_url,
                'title'    => $img->title ?? '',
                'caption'  => $img->caption ?? '',
                'category' => $img->category ?? '',
            ];
        })->values()->toJson();

        return view('pages.gallery', compact('images', 'categories', 'imagesJson'));
    }
}
