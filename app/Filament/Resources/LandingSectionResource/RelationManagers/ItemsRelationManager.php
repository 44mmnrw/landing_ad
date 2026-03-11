<?php

namespace App\Filament\Resources\LandingSectionResource\RelationManagers;

use App\Support\LandingContentCatalog;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Заголовок')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Описание')
                    ->rows(3),
                TextInput::make('badge')
                    ->label('Бейдж/значение')
                    ->maxLength(255),
                Select::make('badge_icon')
                    ->label('Иконка бейджа (sprite)')
                    ->searchable()
                    ->native(false)
                    ->options(LandingContentCatalog::spriteIconOptions())
                    ->afterStateHydrated(function ($component, $record): void {
                        $component->state((string) data_get($record?->meta, 'badge_icon', ''));
                    })
                    ->dehydrated(false)
                    ->helperText('Иконка берётся из public/icons/sprite.svg. Можно оставить пустым.'),
                TextInput::make('image_url')
                    ->label('Изображение (URL)')
                    ->maxLength(2048),
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
                    ->default(1)
                    ->required(),
                Toggle::make('is_active')
                    ->label('Активен')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Описание')
                    ->limit(42),
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
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->slideOver(),
            ])
            ->recordActions([
                EditAction::make()
                    ->slideOver(),
                DeleteAction::make(),
            ]);
    }
}
