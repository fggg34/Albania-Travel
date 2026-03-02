<?php

namespace App\Filament\Pages;

use App\Http\Controllers\Admin\QrCodeController;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class QrCodes extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedQrCode;

    protected static ?string $navigationLabel = 'QR Codes';

    protected static ?string $title = 'QR Codes';

    protected static ?int $navigationSort = 90;

    protected string $view = 'filament.pages.qr-codes';

    public function getViewData(): array
    {
        return [
            'pages'       => QrCodeController::buildPageList(),
            'downloadAll' => route('admin.qr.download-all'),
        ];
    }
}
