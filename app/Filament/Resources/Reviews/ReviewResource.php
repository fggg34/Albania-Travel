<?php

namespace App\Filament\Resources\Reviews;

use App\Filament\Resources\Reviews\Pages\ManageReviews;
use App\Models\Review;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tour_id')
                    ->relationship('tour', 'title')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name'),
                TextInput::make('rating')
                    ->required()
                    ->numeric(),
                TextInput::make('title'),
                Textarea::make('comment')
                    ->columnSpanFull(),
                Toggle::make('is_approved')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tour.title')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                IconColumn::make('is_approved')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('approve')
                    ->action(fn (Review $record) => $record->update(['is_approved' => true]))
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (Review $record) => ! $record->is_approved),
                Action::make('reject')
                    ->action(fn (Review $record) => $record->update(['is_approved' => false]))
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn (Review $record) => $record->is_approved),
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
            'index' => ManageReviews::route('/'),
        ];
    }
}
