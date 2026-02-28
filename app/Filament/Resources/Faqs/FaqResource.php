<?php

namespace App\Filament\Resources\Faqs;

use App\Filament\Resources\Faqs\Pages\ManageFaqs;
use App\Models\Faq;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    protected static ?string $navigationLabel = 'FAQ';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('category')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. Booking & Reservations')
                    ->helperText('Group name shown as a section heading on the FAQ page.')
                    ->columnSpan(2),

                TextInput::make('category_icon')
                    ->label('Category Icon (FontAwesome class)')
                    ->maxLength(255)
                    ->placeholder('e.g. fa-solid fa-calendar-check')
                    ->helperText('FontAwesome class for the icon shown next to the category heading.')
                    ->columnSpan(2),

                TextInput::make('category_sort')
                    ->label('Category Order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Lower numbers appear first. All items in the same category share this order.'),

                TextInput::make('sort_order')
                    ->label('Question Order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Order within the category. Lower = first.'),

                TextInput::make('question')
                    ->required()
                    ->maxLength(500)
                    ->columnSpanFull(),

                Textarea::make('answer')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Visible on website')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('question')
                    ->searchable()
                    ->limit(60)
                    ->wrap(),

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
            ->defaultSort('category_sort')
            ->filters([
                SelectFilter::make('category')
                    ->options(fn () => Faq::query()->distinct()->pluck('category', 'category')->toArray()),
                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ]),
            ])
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
            'index' => ManageFaqs::route('/'),
        ];
    }
}
