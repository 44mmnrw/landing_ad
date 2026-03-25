<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use App\Support\LandingContentCatalog;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class SiteSettingResource extends Resource
{
    protected const array HIDDEN_KEYS = [
        'site_logo_image_path',
        'yandex_metrika_counter_id',
        'google_analytics_measurement_id',
    ];

    protected static ?string $model = SiteSetting::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Настройки сайта';

    protected static ?string $modelLabel = 'Настройка сайта';

    protected static ?string $pluralModelLabel = 'Настройки сайта';

    protected static string | UnitEnum | null $navigationGroup = 'Настройки';

    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('key')
                    ->label('Ключ')
                    ->searchable()
                    ->native(false)
                    ->options(collect(LandingContentCatalog::siteSettingOptions())
                        ->except(self::HIDDEN_KEYS)
                        ->all())
                    ->required()
                    ->helperText('Выберите понятный ключ из списка. Для нестандартных параметров оставьте отдельный технический ресурс.'),
                TextInput::make('logo_text')
                    ->label('Название/текст логотипа')
                    ->maxLength(255)
                    ->helperText('Этот текст используется, если изображение логотипа не загружено.')
                    ->afterStateHydrated(function ($component, $record): void {
                        if (($record?->key ?? null) !== 'site_logo') {
                            return;
                        }

                        $component->state((string) ($record?->value ?? ''));
                    })
                    ->visible(fn (Get $get): bool => $get('key') === 'site_logo')
                    ->dehydrated(false),
                FileUpload::make('logo_image_path')
                    ->label('Логотип (изображение)')
                    ->image()
                    ->imageEditor()
                    ->directory('site-settings')
                    ->disk('public')
                    ->visibility('public')
                    ->columnSpanFull()
                    ->helperText('Требования к логотипу: прозрачный фон желателен, формат .png/.svg/.webp, рекомендуемая ширина 160–320 px, высота до 64 px, вес до 1 МБ.')
                    ->afterStateHydrated(function ($component, $record): void {
                        if (($record?->key ?? null) !== 'site_logo') {
                            return;
                        }

                        $component->state((string) (SiteSetting::query()->where('key', 'site_logo_image_path')->value('value') ?? ''));
                    })
                    ->visible(fn (Get $get): bool => $get('key') === 'site_logo')
                    ->dehydrated(false),
                FileUpload::make('favicon_file')
                    ->label('Favicon')
                    ->image()
                    ->imageEditor()
                    ->directory('site-settings')
                    ->disk('public')
                    ->visibility('public')
                    ->columnSpanFull()
                    ->helperText('Требования: квадратная иконка (рекомендуется 32x32 или 48x48), форматы .ico/.png/.svg, вес до 512 КБ.')
                    ->afterStateHydrated(function ($component, $record): void {
                        if (($record?->key ?? null) !== 'favicon_path') {
                            return;
                        }

                        $component->state((string) ($record?->value ?? ''));
                    })
                    ->dehydrated(false)
                    ->visible(fn (Get $get): bool => $get('key') === 'favicon_path'),
                Textarea::make('value')
                    ->label('Значение')
                    ->rows(8)
                    ->helperText('Поддерживается обычный текст и HTML при необходимости.')
                    ->dehydrateStateUsing(function ($state, Get $get): string {
                        if ($get('key') === 'site_logo') {
                            return trim((string) ($get('logo_text') ?? ''));
                        }

                        return (string) ($state ?? '');
                    })
                    ->hidden(fn (Get $get): bool => in_array($get('key'), ['favicon_path', 'site_logo'], true))
                    ->columnSpanFull(),
                Toggle::make('is_public')
                    ->label('Опубликовано')
                    ->default(true),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereNotIn('key', self::HIDDEN_KEYS);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('key')
            ->columns([
                TextColumn::make('key')
                    ->label('Ключ')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => LandingContentCatalog::siteSettingOptions()[$state] ?? $state)
                    ->sortable(),
                TextColumn::make('value')
                    ->label('Значение')
                    ->html()
                    ->wrap(),
                IconColumn::make('is_public')
                    ->label('Опубликовано')
                    ->boolean(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
