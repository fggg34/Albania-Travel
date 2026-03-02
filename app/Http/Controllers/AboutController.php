<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;

class AboutController extends Controller
{
    public function __invoke()
    {
        $aboutPage = AboutPage::getInstance();
        return view('pages.about', compact('aboutPage'));
    }
}
