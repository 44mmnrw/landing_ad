<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use UnitEnum;

class SeoSettings extends Page
{
    public ?array $data = [];

    protected string $view = 'filament.pages.seo-settings';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?string $navigationLabel = 'SEO и аналитика';

    protected static string | UnitEnum | null $navigationGroup = 'Настройки';

    protected static ?int $navigationSort = 10;

    protected static ?string $title = 'SEO и аналитика';

    protected static ?string $slug = 'seo-settings';

    public function mount(): void
    {
        $this->form->fill([
            'yandex_metrika_counter_id' => (string) SiteSetting::query()->where('key', 'yandex_metrika_counter_id')->value('value'),
            'google_analytics_measurement_id' => (string) SiteSetting::query()->where('key', 'google_analytics_measurement_id')->value('value'),
        ]);
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema
            ->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('yandex_metrika_counter_id')
                    ->label('Яндекс.Метрика — номер счётчика')
                    ->placeholder('12345678')
                    ->numeric()
                    ->minValue(1)
                    ->helperText('Укажите только номер счётчика. Код подключается автоматически.'),
                TextInput::make('google_analytics_measurement_id')
                    ->label('Google Analytics — ID счётчика')
                    ->placeholder('G-XXXXXXXXXX')
                    ->helperText('Укажите только ID (например G-XXXXXXXXXX). Код подключается автоматически.'),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        SiteSetting::query()->updateOrCreate(
            ['key' => 'yandex_metrika_counter_id'],
            ['value' => trim((string) ($data['yandex_metrika_counter_id'] ?? '')), 'is_public' => true],
        );

        SiteSetting::query()->updateOrCreate(
            ['key' => 'google_analytics_measurement_id'],
            ['value' => trim((string) ($data['google_analytics_measurement_id'] ?? '')), 'is_public' => true],
        );

        Notification::make()
            ->title('SEO-настройки сохранены')
            ->success()
            ->send();
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Счётчики аналитики')
                    ->description('Эти коды автоматически подключаются на всех страницах сайта через футер.')
                    ->schema([
                        Form::make([EmbeddedSchema::make('form')])
                            ->id('seo-settings-form')
                            ->livewireSubmitHandler('save')
                            ->footer([
                                Actions::make([
                                    Action::make('save')
                                        ->label('Сохранить')
                                        ->submit('save')
                                        ->keyBindings(['mod+s']),
                                ])->alignment(Alignment::Start),
                            ]),
                    ]),
            ]);
    }
}
