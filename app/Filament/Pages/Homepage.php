<?php

namespace App\Filament\Pages;

use App\Models\HomepageAbout;
use App\Models\HomepageHero;
use App\Models\TourInfoPoint;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section as SchemaSection;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class Homepage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $navigationLabel = 'Homepage';

    protected static ?string $title = 'Homepage';

    protected static string|\UnitEnum|null $navigationGroup = 'Homepage';

    /** @var array<string, mixed> Form state for all homepage sections */
    public array $homepageForm = [];

    protected static ?int $navigationSort = 50;

    protected string $view = 'filament.pages.homepage';

    public function mount(): void
    {
        $hero = HomepageHero::getActive() ?? HomepageHero::first() ?? new HomepageHero([
            'title' => 'Adventure Simplified',
            'subtitle' => 'Guides, local transport, accommodation, and like-minded travelers are always included. Book securely & flexibly.',
            'banner_type' => 'image',
            'is_active' => true,
        ]);

        if (! $hero->exists) {
            $hero->save();
        }

        $tourInfoPoints = TourInfoPoint::ordered()->get()->map(fn ($p) => [
            'title' => $p->title,
            'description' => $p->description,
            'icon' => $p->icon,
        ])->toArray();

        $about = HomepageAbout::first() ?? new HomepageAbout([
            'title' => 'About Us',
            'description' => '',
            'is_active' => true,
        ]);
        if (! $about->exists) {
            $about->save();
        }

        $this->getSchema('homepageForm')->fill(array_merge($hero->only([
            'title', 'subtitle', 'banner_type', 'banner_image', 'banner_video', 'cta_text', 'is_active',
        ]), [
            'tour_info_points' => $tourInfoPoints,
            'about_title' => $about->title,
            'about_description' => $about->description,
            'about_image_1' => $about->image_1,
            'about_image_2' => $about->image_2,
            'about_highlight_text' => $about->highlight_text,
            'about_highlight_subtext' => $about->highlight_subtext,
            'about_is_active' => $about->is_active,
        ]));
    }

    public function homepageForm(Schema $schema): Schema
    {
        return $schema
            ->statePath('homepageForm')
            ->components([
                SchemaSection::make('Homepage')
                    ->description('Manage your homepage sections. Each section can be controlled independently.')
                    ->schema([
                        SchemaSection::make('Homepage Hero')
                            ->description('Customize the main hero banner displayed at the top of the homepage.')
                            ->collapsible()
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Textarea::make('subtitle')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Select::make('banner_type')
                                    ->options([
                                        'image' => 'Image',
                                        'video' => 'Video',
                                    ])
                                    ->default('image')
                                    ->required()
                                    ->live(),
                                FileUpload::make('banner_image')
                                    ->label('Banner image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('heroes')
                                    ->visibility('public')
                                    ->imagePreviewHeight(200)
                                    ->panelAspectRatio('16/9')
                                    ->panelLayout('integrated')
                                    ->visible(fn ($get) => $get('banner_type') === 'image')
                                    ->columnSpanFull(),
                                FileUpload::make('banner_video')
                                    ->label('Banner video (MP4)')
                                    ->acceptedFileTypes(['video/mp4'])
                                    ->disk('public')
                                    ->directory('heroes')
                                    ->visibility('public')
                                    ->visible(fn ($get) => $get('banner_type') === 'video')
                                    ->columnSpanFull(),
                                TextInput::make('cta_text')
                                    ->label('CTA button text (optional)')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Toggle::make('is_active')
                                    ->label('Show this hero on the homepage')
                                    ->default(true)
                                    ->helperText('When active, this hero is displayed on the homepage.'),
                            ]),
                        SchemaSection::make('Tour Info Points')
                            ->description('Info blocks shown under the hero (icon, title, description). Order determines display order.')
                            ->collapsible()
                            ->schema([
                                Repeater::make('tour_info_points')
                                    ->schema([
                                        FileUpload::make('icon')
                                            ->label('Icon image')
                                            ->image()
                                            ->disk('public')
                                            ->directory('tour-info-points')
                                            ->visibility('public')
                                            ->imagePreviewHeight(80)
                                            ->columnSpanFull(),
                                        TextInput::make('title')
                                            ->required()
                                            ->maxLength(255),
                                        Textarea::make('description')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                    ])
                                    ->defaultItems(0)
                                    ->reorderable()
                                    ->reorderableWithButtons()
                                    ->addActionLabel('Add point')
                                    ->columnSpanFull(),
                            ]),
                        SchemaSection::make('About Us')
                            ->description('Two-column section under categories: left = title + description, right = main image + highlight box + second image.')
                            ->collapsible()
                            ->schema([
                                TextInput::make('about_title')
                                    ->label('Title')
                                    ->default('About Us')
                                    ->maxLength(255),
                                Textarea::make('about_description')
                                    ->label('Description')
                                    ->rows(4)
                                    ->columnSpanFull(),
                                FileUpload::make('about_image_1')
                                    ->label('Main image (left of right column)')
                                    ->image()
                                    ->disk('public')
                                    ->directory('homepage-about')
                                    ->visibility('public')
                                    ->imagePreviewHeight(150),
                                FileUpload::make('about_image_2')
                                    ->label('Secondary image (bottom right)')
                                    ->image()
                                    ->disk('public')
                                    ->directory('homepage-about')
                                    ->visibility('public')
                                    ->imagePreviewHeight(150),
                                TextInput::make('about_highlight_text')
                                    ->label('Highlight box – top line')
                                    ->placeholder('e.g. +10 years')
                                    ->maxLength(100),
                                TextInput::make('about_highlight_subtext')
                                    ->label('Highlight box – bottom line')
                                    ->placeholder('e.g. Experience')
                                    ->maxLength(100),
                                Toggle::make('about_is_active')
                                    ->label('Show this section')
                                    ->default(true),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('homepageForm')])
                    ->id('homepageForm')
                    ->livewireSubmitHandler('saveHomepage')
                    ->footer([
                        Actions::make([
                            Action::make('saveHomepage')
                                ->label('Save homepage')
                                ->submit('saveHomepage'),
                        ])->alignment(\Filament\Support\Enums\Alignment::Start),
                    ]),
            ]);
    }

    public function saveHomepage(): void
    {
        $data = $this->getSchema('homepageForm')->getState();

        $hero = HomepageHero::getActive() ?? HomepageHero::first();

        if (! $hero) {
            $hero = new HomepageHero();
        }

        $hero->fill(array_diff_key($data, array_flip(['tour_info_points', 'about_title', 'about_description', 'about_image_1', 'about_image_2', 'about_highlight_text', 'about_highlight_subtext', 'about_is_active'])));
        $hero->save();

        // Save About Us section
        $about = HomepageAbout::first() ?? new HomepageAbout();
        $img1 = $data['about_image_1'] ?? null;
        $img2 = $data['about_image_2'] ?? null;
        $about->fill([
            'title' => $data['about_title'] ?? 'About Us',
            'description' => $data['about_description'] ?? null,
            'image_1' => is_array($img1) ? ($img1[0] ?? null) : $img1,
            'image_2' => is_array($img2) ? ($img2[0] ?? null) : $img2,
            'highlight_text' => $data['about_highlight_text'] ?? null,
            'highlight_subtext' => $data['about_highlight_subtext'] ?? null,
            'is_active' => $data['about_is_active'] ?? true,
        ]);
        $about->save();

        // Sync tour info points
        TourInfoPoint::query()->delete();
        $points = $data['tour_info_points'] ?? [];
        foreach ($points as $index => $item) {
            $icon = $item['icon'] ?? null;
            $icon = is_array($icon) ? ($icon[0] ?? null) : $icon;
            TourInfoPoint::create([
                'title' => $item['title'] ?? '',
                'description' => $item['description'] ?? null,
                'icon' => $icon,
                'sort_order' => $index,
            ]);
        }

        Notification::make()->title('Homepage saved.')->success()->send();
    }
}
