<?php

namespace App\Filament\Widgets;

use App\Models\QuoteRequest;
use App\Models\TrackingRequest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class OperationsStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = -30;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $todayStart = Carbon::now()->startOfDay();

        $quotesToday = QuoteRequest::query()
            ->where('created_at', '>=', $todayStart)
            ->count();

        $quotesInProgressToday = QuoteRequest::query()
            ->where('created_at', '>=', $todayStart)
            ->where('status', 'in_progress')
            ->count();

        $quotesDoneToday = QuoteRequest::query()
            ->where('created_at', '>=', $todayStart)
            ->where('status', 'done')
            ->count();

        $trackingTodayQuery = TrackingRequest::query()
            ->where('created_at', '>=', $todayStart);

        $trackingToday = (clone $trackingTodayQuery)->count();

        return [
            Stat::make('Заявок на расчет сегодня', (string) $quotesToday)
                ->description('Создано с 00:00')
                ->color('primary')
                ->icon('heroicon-o-document-text'),
            Stat::make('Трекинг-запросов сегодня', (string) $trackingToday)
                ->description('Все проверки кода')
                ->color('info')
                ->icon('heroicon-o-magnifying-glass'),
            Stat::make('В работе сегодня', (string) $quotesInProgressToday)
                ->description('Статус: В работе')
                ->color('warning')
                ->icon('heroicon-o-clock'),
            Stat::make('Завершено сегодня', (string) $quotesDoneToday)
                ->description('Статус: Завершена')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
