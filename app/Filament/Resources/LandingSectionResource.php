<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LandingSectionResource\Pages;
use App\Filament\Resources\LandingSectionResource\RelationManagers\ItemsRelationManager;
use App\Models\LandingSection;
use App\Support\LandingContentCatalog;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class LandingSectionResource extends Resource
{
    protected static ?string $model = LandingSection::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Секции лендинга';

    protected static ?string $modelLabel = 'Секция лендинга';

    protected static ?string $pluralModelLabel = 'Секции лендинга';

    protected static string | UnitEnum | null $navigationGroup = 'Контент лендинга';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('code')
                    ->label('Код секции')
                    ->searchable()
                    ->native(false)
                    ->options(LandingContentCatalog::sectionOptions())
                    ->required()
                    ->helperText('Пример: hero, services, footer_navigation'),
                Placeholder::make('usage_hint')
                    ->label('Подсказка по секции')
                    ->content(function (callable $get): string {
                        $code = (string) ($get('code') ?? '');

                        return LandingContentCatalog::sectionHints()[$code]
                            ?? 'Выберите секцию — появится подсказка по нужным полям.';
                    }),
                TextInput::make('title')
                    ->label('Заголовок')
                    ->maxLength(255),
                Textarea::make('subtitle')
                    ->label('Подзаголовок')
                    ->rows(3),
                FileUpload::make('background_image')
                    ->label('Фон секции')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                    ->disk('public')
                    ->directory('landing-sections/backgrounds')
                    ->visibility('public')
                    ->fetchFileInformation(false)
                    ->previewable(true)
                    ->openable(false)
                    ->downloadable(false)
                    ->helperText('Загрузите изображение фона. Файл хранится локально в проекте.'),
                Group::make([
                    Toggle::make('carousel_enabled')
                        ->label('Включить карусель')
                        ->helperText('Если включено, карточки секции будут автоматически переключаться на сайте.')
                        ->afterStateHydrated(function ($component, $record): void {
                            $component->state((bool) data_get($record?->meta, 'carousel_enabled', false));
                        })
                        ->dehydrated(false),
                    TextInput::make('carousel_speed_ms')
                        ->label('Скорость карусели (мс)')
                        ->numeric()
                        ->minValue(500)
                        ->maxValue(20000)
                        ->default(3500)
                        ->helperText('Интервал автопереключения в миллисекундах, например 3500.')
                        ->afterStateHydrated(function ($component, $record): void {
                            $speed = (int) data_get($record?->meta, 'carousel_speed_ms', 3500);
                            $component->state($speed > 0 ? $speed : 3500);
                        })
                        ->visible(fn (callable $get): bool => (bool) $get('carousel_enabled'))
                        ->dehydrated(false),
                ]),
                KeyValue::make('meta')
                    ->label('Meta (ключ-значение)')
                    ->keyLabel('Ключ')
                    ->valueLabel('Значение')
                    ->afterStateHydrated(function ($component, $state): void {
                        $meta = is_array($state) ? $state : [];
                        unset($meta['carousel_enabled'], $meta['carousel_speed_ms']);
                        $component->state($meta);
                    })
                    ->dehydrateStateUsing(function ($state, callable $get): array {
                        $meta = is_array($state) ? $state : [];
                        $carouselEnabled = (bool) $get('carousel_enabled');
                        $speed = max(500, (int) ($get('carousel_speed_ms') ?: 3500));

                        if ($carouselEnabled) {
                            $meta['carousel_enabled'] = true;
                            $meta['carousel_speed_ms'] = $speed;
                        } else {
                            unset($meta['carousel_enabled'], $meta['carousel_speed_ms']);
                        }

                        return $meta;
                    })
                    ->helperText('Для hero/mission/cta здесь задаются дополнительные параметры кнопок и акцентного текста.'),
                TextInput::make('sort_order')
                    ->label('Порядок')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Toggle::make('is_active')
                    ->label('Активна')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('code')
                    ->label('Код')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => LandingContentCatalog::sectionOptions()[$state] ?? $state)
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Заголовок')
                    ->limit(40)
                    ->searchable(),
                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Активна')
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
            'index' => Pages\ListLandingSections::route('/'),
            'create' => Pages\CreateLandingSection::route('/create'),
            'edit' => Pages\EditLandingSection::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }
}
