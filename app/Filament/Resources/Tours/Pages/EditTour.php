<?php

namespace App\Filament\Resources\Tours\Pages;

use App\Filament\Resources\Tours\TourResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTour extends EditRecord
{
    protected static string $resource = TourResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('preview')
                ->label('Preview')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (): string => route('tours.show', $this->record->slug))
                ->openUrlInNewTab()
                ->visible(fn (): bool => (bool) $this->record->slug),
            DeleteAction::make(),
        ];
    }
}
