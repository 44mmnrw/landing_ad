<?php

namespace App\Filament\Widgets;

use App\Models\QuoteRequest;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestQuoteRequestsTable extends TableWidget
{
    protected static ?int $sort = -20;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Последние заявки на расчет')
            ->query(QuoteRequest::query()->latest())
            ->defaultPaginationPageOption(5)
            ->columns([
                TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Имя')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable(),
                TextColumn::make('route')
                    ->label('Маршрут')
                    ->limit(28),
                TextColumn::make('status')
                    ->label('Статус')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'new' => 'Новая',
                        'in_progress' => 'В работе',
                        'done' => 'Завершена',
                        'rejected' => 'Отклонена',
                        default => (string) ($state ?? '—'),
                    })
                    ->badge(),
            ]);
    }
}
