<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrackingRequestResource\Pages;
use App\Models\TrackingRequest;
use BackedEnum;
use UnitEnum;
use Filament\Actions\DeleteAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class TrackingRequestResource extends Resource
{
    protected static ?string $model = TrackingRequest::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $navigationLabel = 'История трекинга';

    protected static ?string $modelLabel = 'Запрос трекинга';

    protected static ?string $pluralModelLabel = 'История трекинга';

    protected static string | UnitEnum | null $navigationGroup = 'Операции';

    protected static ?int $navigationSort = 25;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                TextColumn::make('search_code')
                    ->label('Искали код')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('search_code')
                    ->label('Найденный трек-код')
                    ->formatStateUsing(fn (?string $state, TrackingRequest $record): string => $record->is_found ? ($state ?: '—') : 'Не найден')
                    ->searchable(),
                IconColumn::make('is_found')
                    ->label('Найдено')
                    ->boolean(),
                TextColumn::make('ip_address')
                    ->label('IP')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('source_page')
                    ->label('URL запроса')
                    ->limit(42)
                    ->tooltip(fn ($state): ?string => $state)
                    ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_found')
                    ->label('Только найденные'),
            ])
            ->recordActions([
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrackingRequests::route('/'),
        ];
    }
}
