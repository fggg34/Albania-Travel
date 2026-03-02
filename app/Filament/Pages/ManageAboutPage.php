<?php

namespace App\Filament\Pages;

use App\Models\AboutPage;
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
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class ManageAboutPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $navigationLabel = 'About Page';

    protected static ?string $title = 'About Page';

    protected static ?int $navigationSort = 55;

    protected static string|\UnitEnum|null $navigationGroup = 'Homepage';

    /** @var array<string, mixed> */
    public array $aboutForm = [];

    protected string $view = 'filament.pages.about-page';

    public function mount(): void
    {
        $page = AboutPage::getInstance();
        $this->getSchema('aboutForm')->fill($page->toArray());
    }

    public function aboutForm(Schema $schema): Schema
    {
        return $schema
            ->statePath('aboutForm')
            ->components([
                SchemaSection::make('About Page')
                    ->description('Edit all content shown on the public About Us page.')
                    ->schema([
                        SchemaSection::make('Hero')
                            ->collapsible()
                            ->schema([
                                FileUpload::make('hero_image')
                                    ->label('Hero background image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('about-page')
                                    ->visibility('public')
                                    ->imagePreviewHeight(150),
                                TextInput::make('hero_title')->label('Title')->maxLength(255),
                                Textarea::make('hero_subtitle')->label('Subtitle')->rows(2),
                            ])
                            ->columns(1),
                        SchemaSection::make('Story')
                            ->collapsible()
                            ->schema([
                                FileUpload::make('story_image')
                                    ->label('Main image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('about-page')
                                    ->visibility('public')
                                    ->imagePreviewHeight(200),
                                TextInput::make('story_eyebrow')->label('Eyebrow text')->placeholder('e.g. The Beginning')->maxLength(100),
                                TextInput::make('story_heading')->label('Heading')->maxLength(255),
                                RichEditor::make('story_content')->label('Content')->columnSpanFull(),
                                Textarea::make('story_quote')->label('Quote')->rows(2)->placeholder('Optional italic quote'),
                            ])
                            ->columns(1),
                        SchemaSection::make('Stats')
                            ->description('4 stat blocks (number + label each)')
                            ->collapsible()
                            ->schema([
                                TextInput::make('stat_1_number')->label('Stat 1 – Number')->placeholder('10+'),
                                TextInput::make('stat_1_label')->label('Stat 1 – Label')->placeholder('Years Experience'),
                                TextInput::make('stat_2_number')->label('Stat 2 – Number'),
                                TextInput::make('stat_2_label')->label('Stat 2 – Label'),
                                TextInput::make('stat_3_number')->label('Stat 3 – Number'),
                                TextInput::make('stat_3_label')->label('Stat 3 – Label'),
                                TextInput::make('stat_4_number')->label('Stat 4 – Number'),
                                TextInput::make('stat_4_label')->label('Stat 4 – Label'),
                            ])
                            ->columns(2),
                        SchemaSection::make('Values')
                            ->description('3 value cards (icon = Font Awesome class, e.g. fa-compass)')
                            ->collapsible()
                            ->schema([
                                TextInput::make('values_eyebrow')->label('Eyebrow')->maxLength(100),
                                TextInput::make('values_heading')->label('Heading')->maxLength(255),
                                Textarea::make('values_intro')->label('Intro paragraph')->rows(2),
                                TextInput::make('value_1_icon')->label('Card 1 – Icon')->placeholder('fa-compass'),
                                TextInput::make('value_1_title')->label('Card 1 – Title')->maxLength(100),
                                Textarea::make('value_1_text')->label('Card 1 – Description')->rows(2),
                                TextInput::make('value_2_icon')->label('Card 2 – Icon')->placeholder('fa-person-hiking'),
                                TextInput::make('value_2_title')->label('Card 2 – Title')->maxLength(100),
                                Textarea::make('value_2_text')->label('Card 2 – Description')->rows(2),
                                TextInput::make('value_3_icon')->label('Card 3 – Icon')->placeholder('fa-shield-halved'),
                                TextInput::make('value_3_title')->label('Card 3 – Title')->maxLength(100),
                                Textarea::make('value_3_text')->label('Card 3 – Description')->rows(2),
                            ])
                            ->columns(2),
                        SchemaSection::make('Team')
                            ->description('2 team members')
                            ->collapsible()
                            ->schema([
                                TextInput::make('team_eyebrow')->label('Eyebrow')->maxLength(100),
                                TextInput::make('team_heading')->label('Heading')->maxLength(255),
                                FileUpload::make('team_1_image')->label('Member 1 – Photo')->image()->disk('public')->directory('about-page')->visibility('public')->imagePreviewHeight(120),
                                TextInput::make('team_1_name')->label('Member 1 – Name')->maxLength(100),
                                TextInput::make('team_1_role')->label('Member 1 – Role')->maxLength(100),
                                TextInput::make('team_1_region')->label('Member 1 – Region')->maxLength(100),
                                FileUpload::make('team_2_image')->label('Member 2 – Photo')->image()->disk('public')->directory('about-page')->visibility('public')->imagePreviewHeight(120),
                                TextInput::make('team_2_name')->label('Member 2 – Name')->maxLength(100),
                                TextInput::make('team_2_role')->label('Member 2 – Role')->maxLength(100),
                                TextInput::make('team_2_region')->label('Member 2 – Region')->maxLength(100),
                            ])
                            ->columns(2),
                        SchemaSection::make('CTA')
                            ->collapsible()
                            ->schema([
                                TextInput::make('cta_heading')->label('Heading')->maxLength(255),
                                Textarea::make('cta_text')->label('Text')->rows(2),
                                TextInput::make('cta_btn_1_text')->label('Button 1 – Text')->maxLength(100),
                                TextInput::make('cta_btn_1_url')->label('Button 1 – URL')->placeholder('/tours')->maxLength(255),
                                TextInput::make('cta_btn_2_text')->label('Button 2 – Text')->maxLength(100),
                                TextInput::make('cta_btn_2_url')->label('Button 2 – URL')->placeholder('/contact')->maxLength(255),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('aboutForm')])
                    ->id('aboutForm')
                    ->livewireSubmitHandler('saveAbout')
                    ->footer([
                        Actions::make([
                            Action::make('saveAbout')
                                ->label('Save About Page')
                                ->submit('saveAbout'),
                        ])->alignment(\Filament\Support\Enums\Alignment::Start),
                    ]),
            ]);
    }

    public function saveAbout(): void
    {
        $data = $this->getSchema('aboutForm')->getState();
        $page = AboutPage::getInstance();

        $fileFields = ['hero_image', 'story_image', 'team_1_image', 'team_2_image'];
        foreach ($fileFields as $field) {
            $val = $data[$field] ?? null;
            $data[$field] = is_array($val) ? ($val[0] ?? null) : $val;
        }

        $page->update($data);
        Notification::make()->title('About page saved.')->success()->send();
    }
}
