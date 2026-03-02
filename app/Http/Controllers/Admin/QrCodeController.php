<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\City;
use App\Models\Tour;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Generator as QrCodeGenerator;
use ZipArchive;

class QrCodeController extends Controller
{
    /**
     * Download a single QR code as PNG.
     */
    public function download(Request $request)
    {
        $url   = $request->query('url');
        $label = $request->query('label', 'qrcode');

        if (! $url || ! filter_var($url, FILTER_VALIDATE_URL)) {
            abort(400, 'Invalid URL');
        }

        $png = app(QrCodeGenerator::class)->format('png')->size(400)->margin(2)->generate($url);

        $filename = str($label)->slug()->append('.png')->toString();

        return response($png, 200, [
            'Content-Type'        => 'image/png',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Download all QR codes bundled in a ZIP.
     */
    public function downloadAll()
    {
        $pages = $this->buildPageList();

        $zip  = new ZipArchive();
        $path = tempnam(sys_get_temp_dir(), 'qrcodes_') . '.zip';
        $zip->open($path, ZipArchive::CREATE);

        foreach ($pages as $group => $items) {
            foreach ($items as $item) {
                $png      = app(QrCodeGenerator::class)->format('png')->size(400)->margin(2)->generate($item['url']);
                $filename = str($group)->slug()->toString()
                    . '/' . str($item['label'])->slug()->toString() . '.png';
                $zip->addFromString($filename, $png);
            }
        }

        $zip->close();

        return response()->download($path, 'qr-codes.zip', [
            'Content-Type' => 'application/zip',
        ])->deleteFileAfterSend();
    }

    /**
     * Build the full list of pages grouped by type.
     * Called from both the controller and the Filament page.
     */
    public static function buildPageList(): array
    {
        $pages = [
            'Static pages' => [
                ['label' => 'Home',    'url' => route('home')],
                ['label' => 'Tours',   'url' => route('tours.index')],
                ['label' => 'About',   'url' => route('about')],
                ['label' => 'Contact', 'url' => route('contact')],
                ['label' => 'FAQ',     'url' => route('faq')],
                ['label' => 'Gallery', 'url' => route('gallery')],
                ['label' => 'Blog',    'url' => route('blog.index')],
            ],
        ];

        $tours = Tour::where('is_active', true)->orderBy('title')->get();
        if ($tours->isNotEmpty()) {
            $pages['Tours'] = $tours->map(fn ($t) => [
                'label' => $t->title,
                'url'   => route('tours.show', $t->slug),
            ])->all();
        }

        $cities = City::active()->orderBy('name')->get();
        if ($cities->isNotEmpty()) {
            $pages['Cities'] = $cities->map(fn ($c) => [
                'label' => $c->name,
                'url'   => route('cities.show', $c->slug),
            ])->all();
        }

        $posts = BlogPost::where('is_published', true)->orderBy('title')->get();
        if ($posts->isNotEmpty()) {
            $pages['Blog posts'] = $posts->map(fn ($p) => [
                'label' => $p->title,
                'url'   => route('blog.show', $p->slug),
            ])->all();
        }

        return $pages;
    }
}
