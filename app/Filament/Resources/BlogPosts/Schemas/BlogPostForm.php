<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Models\BlogCategory;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('blog_category_id')
                    ->label('Category')
                    ->options(BlogCategory::pluck('name', 'id'))
                    ->searchable()
                    ->nullable(),
                Select::make('tags')
                    ->label('Tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->dehydrated(true)
                    ->nullable(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                RichEditor::make('excerpt')
                    ->label('Excerpt')
                    ->columnSpanFull(),
                RichEditor::make('content')
                    ->label('Content')
                    ->columnSpanFull(),
                FileUpload::make('featured_image')
                    ->label('Featured image')
                    ->image()
                    ->disk('public')
                    ->directory('blog-posts')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                    ->imagePreviewHeight('260')
                    ->panelAspectRatio('16/10')
                    ->panelLayout('integrated'),
                TextInput::make('meta_title')
                    ->label('Meta title')
                    ->maxLength(70)
                    ->helperText('Best practice: 50–60 characters. Leave blank to use post title.'),
                \Filament\Forms\Components\Textarea::make('meta_description')
                    ->label('Meta description')
                    ->rows(2)
                    ->maxLength(170)
                    ->helperText('Best practice: 150–160 characters. Leave blank to use excerpt.'),
                Toggle::make('is_published')
                    ->required(),
                DateTimePicker::make('published_at'),
            ]);
    }
}
