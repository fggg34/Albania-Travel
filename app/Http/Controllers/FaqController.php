<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class FaqController extends Controller
{
    public function __invoke()
    {
        $faqGroups = Faq::grouped();

        return view('pages.faq', compact('faqGroups'));
    }
}
