<?php

namespace App\Filament\Widgets;

use App\Models\TrackingRequest;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestTrackingRequestsTable extends TableWidget
{
    protected static ?int $sort = -10;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Последние трекинг-запросы')
            ->query(TrackingRequest::query()->latest())
            ->columns([
                TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                TextColumn::make('search_code')
                    ->label('Искали')
                    ->placeholder('—')
                    ->searchable(),
                TextColumn::make('shipment.code')
                    ->label('Найденный код')
                    ->placeholder('Не найден'),
                IconColumn::make('is_found')
                    ->label('Найдено')
                    ->boolean(),
                TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable(),
            ]);
    }
}
