<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LandingSectionItemResource\Pages;
use App\Models\LandingSection;
use App\Models\LandingSectionItem;
use App\Support\LandingContentCatalog;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

class LandingSectionItemResource extends Resource
{
    protected static ?string $model = LandingSectionItem::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $navigationLabel = 'Элементы секций';

    protected static ?string $modelLabel = 'Элемент секции';

    protected static ?string $pluralModelLabel = 'Элементы секций';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('section_id')
                    ->label('Секция')
                    ->required()
                    ->searchable()
                    ->options(LandingSection::query()->orderBy('sort_order')->pluck('code', 'id')),
                TextInput::make('title')
                    ->label('Заголовок')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Описание')
                    ->rows(3),
                TextInput::make('image_url')
                    ->label('Изображение (URL)')
                    ->maxLength(2048),
                TextInput::make('badge')
                    ->label('Бейдж/значение')
                    ->maxLength(255),
                Select::make('badge_icon')
                    ->label('Иконка бейджа (sprite)')
                    ->searchable()
                    ->native(false)
                    ->options(LandingContentCatalog::spriteIconOptions())
                    ->afterStateHydrated(function ($component, ?LandingSectionItem $record): void {
                        $component->state((string) data_get($record?->meta, 'badge_icon', ''));
                    })
                    ->dehydrated(false)
                    ->helperText('Выберите id иконки из public/icons/sprite.svg. Оставьте пусто, если иконка не нужна.'),
                KeyValue::make('meta')
                    ->label('Meta (ключ-значение)')
                    ->keyLabel('Ключ')
                    ->valueLabel('Значение')
                    ->afterStateHydrated(function ($component, $state): void {
                        $meta = is_array($state) ? $state : [];
                        unset($meta['badge_icon']);
                        $component->state($meta);
                    })
                    ->dehydrateStateUsing(function ($state, callable $get): array {
                        $meta = is_array($state) ? $state : [];
                        $badgeIcon = trim((string) $get('badge_icon'));

                        if ($badgeIcon !== '') {
                            $meta['badge_icon'] = $badgeIcon;
                        } else {
                            unset($meta['badge_icon']);
                        }

                        return $meta;
                    }),
                TextInput::make('sort_order')
                    ->label('Порядок')
                    ->numeric()
                    ->required()
                    ->default(1),
                Toggle::make('is_active')
                    ->label('Активен')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('section.code')
                    ->label('Секция')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->limit(40),
                ViewColumn::make('badge')
                    ->label('Бейдж')
                    ->view('filament.tables.columns.badge-with-icon'),
                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Активен')
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
            'index' => Pages\ListLandingSectionItems::route('/'),
            'create' => Pages\CreateLandingSectionItem::route('/create'),
            'edit' => Pages\EditLandingSectionItem::route('/{record}/edit'),
        ];
    }
}
