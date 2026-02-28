<?php

namespace App\Filament\Resources\GalleryImages;

use App\Filament\Resources\GalleryImages\Pages\ManageGalleryImages;
use App\Models\GalleryImage;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GalleryImageResource extends Resource
{
    protected static ?string $model = GalleryImage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'Gallery';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->required()
                    ->disk('public')
                    ->directory('gallery')
                    ->imagePreviewHeight('250')
                    ->panelAspectRatio('16/9')
                    ->panelLayout('integrated')
                    ->columnSpanFull(),

                TextInput::make('title')
                    ->label('Title')
                    ->maxLength(255)
                    ->placeholder('e.g. Berat Castle at Sunset')
                    ->helperText('Short title shown on hover overlay. Optional.')
                    ->columnSpan(2),

                TextInput::make('caption')
                    ->label('Caption')
                    ->maxLength(255)
                    ->placeholder('e.g. The ancient "city of a thousand windows"')
                    ->helperText('Short caption shown in the lightbox. Optional.')
                    ->columnSpan(2),

                TextInput::make('category')
                    ->label('Category / Album')
                    ->maxLength(255)
                    ->placeholder('e.g. Coastal, Mountains, Culture')
                    ->helperText('Used for filter tabs on the gallery page. Leave empty for uncategorised.'),

                TextInput::make('sort_order')
                    ->label('Order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Lower numbers appear first.'),

                Toggle::make('is_active')
                    ->label('Visible on website')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->square()
                    ->size(60),

                TextColumn::make('title')
                    ->searchable()
                    ->limit(40)
                    ->placeholder('—'),

                TextColumn::make('category')
                    ->searchable()
                    ->badge()
                    ->color('info')
                    ->placeholder('Uncategorised'),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->numeric()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageGalleryImages::route('/'),
        ];
    }
}
