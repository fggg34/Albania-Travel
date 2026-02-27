<?php

namespace App\Http\Controllers;

class FaqController extends Controller
{
    public function __invoke()
    {
        return view('pages.faq');
    }
}
