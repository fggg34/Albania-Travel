<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

/**
 * @property-read Schema $form
 */
class Settings extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Settings';

    protected static ?string $title = 'Site Settings';

    protected static ?int $navigationSort = 100;

    /** @var array<string, mixed> Form state (bound to schema statePath 'form') */
    public array $form = [];

    protected string $view = 'filament.pages.settings';

    public function mount(): void
    {
        $this->getSchema('form')->fill([
            'logo' => Setting::get('logo', ''),
            'site_name' => Setting::get('site_name', ''),
            'site_tagline' => Setting::get('site_tagline', ''),
            'contact_email' => Setting::get('contact_email', ''),
            'contact_phone' => Setting::get('contact_phone', ''),
            'contact_address' => Setting::get('contact_address', ''),
            'currency' => Setting::get('currency', 'EUR'),
            'hero_title' => Setting::get('hero_title', ''),
            'hero_subtitle' => Setting::get('hero_subtitle', ''),
            'facebook_url' => Setting::get('facebook_url', ''),
            'instagram_url' => Setting::get('instagram_url', ''),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('form')
            ->components([
                \Filament\Schemas\Components\Section::make('General')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->directory('settings')
                            ->visibility('public')
                            ->imagePreviewHeight(80)
                            ->helperText('Site logo shown in the header. Recommended: transparent PNG or SVG.')
                            ->columnSpanFull(),
                        \Filament\Forms\Components\TextInput::make('site_name')->label('Site Name'),
                        \Filament\Forms\Components\TextInput::make('site_tagline')->label('Tagline'),
                        \Filament\Forms\Components\TextInput::make('currency')->label('Currency')->maxLength(10),
                    ])
                    ->columns(2),
                \Filament\Schemas\Components\Section::make('Contact')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('contact_email')->label('Email')->email(),
                        \Filament\Forms\Components\TextInput::make('contact_phone')->label('Phone')->tel(),
                        \Filament\Forms\Components\Textarea::make('contact_address')->label('Address')->rows(2),
                    ])
                    ->columns(1),
                \Filament\Schemas\Components\Section::make('Hero')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('hero_title')->label('Hero Title'),
                        \Filament\Forms\Components\TextInput::make('hero_subtitle')->label('Hero Subtitle'),
                    ]),
                \Filament\Schemas\Components\Section::make('Social')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('facebook_url')->label('Facebook URL')->url(),
                        \Filament\Forms\Components\TextInput::make('instagram_url')->label('Instagram URL')->url(),
                    ])
                    ->columns(2),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Save settings')
                                ->submit('save'),
                        ])->alignment(\Filament\Support\Enums\Alignment::Start),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->getSchema('form')->getState();
        foreach ($data as $key => $value) {
            Setting::set($key, $value ?? '');
        }
        Notification::make()->title('Settings saved.')->success()->send();
    }
}
