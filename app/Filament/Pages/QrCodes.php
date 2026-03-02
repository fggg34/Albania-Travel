<?php

namespace App\Filament\Pages;

use App\Http\Controllers\Admin\QrCodeController;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use SimpleSoftwareIO\QrCode\Generator as QrCodeGenerator;

class QrCodes extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedQrCode;

    protected static ?string $navigationLabel = 'QR Codes';

    protected static ?string $title = 'QR Codes';

    protected static ?int $navigationSort = 90;

    protected string $view = 'filament.pages.qr-codes';

    public function getViewData(): array
    {
        $rawPages = QrCodeController::buildPageList();

        // Pre-generate SVG previews and attach download URLs so the Blade
        // view never needs to call any PHP class directly.
        $qr     = app(QrCodeGenerator::class);
        $groups = [];
        foreach ($rawPages as $group => $items) {
            $built = [];
            foreach ($items as $item) {
                $built[] = [
                    'label'       => $item['label'],
                    'url'         => $item['url'],
                    'svg'         => (string) $qr->size(100)->margin(1)->generate($item['url']),
                    'downloadUrl' => route('admin.qr.download', [
                        'url'   => $item['url'],
                        'label' => $item['label'],
                    ]),
                ];
            }
            $groups[$group] = $built;
        }

        return [
            'groups'      => $groups,
            'downloadAll' => route('admin.qr.download-all'),
        ];
    }
}
