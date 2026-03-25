<?php

namespace App\Filament\Widgets;

use App\Models\QuoteRequest;
use App\Models\TrackingRequest;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class OperationsStatsOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = -30;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $statsTimezone = config('app.stats_timezone', env('APP_STATS_TIMEZONE', 'Europe/Moscow'));

        $nowLocal = Carbon::now($statsTimezone);
        $period = (string) ($this->pageFilters['period'] ?? 'today');

        [$periodStartLocal, $periodEndLocal, $periodLabel] = match ($period) {
            'week' => [(clone $nowLocal)->startOfWeek(), (clone $nowLocal)->endOfWeek(), 'за неделю'],
            'month' => [(clone $nowLocal)->startOfMonth(), (clone $nowLocal)->endOfMonth(), 'за месяц'],
            'year' => [(clone $nowLocal)->startOfYear(), (clone $nowLocal)->endOfYear(), 'за год'],
            default => [(clone $nowLocal)->startOfDay(), (clone $nowLocal)->endOfDay(), 'сегодня'],
        };

        $periodStartUtc = (clone $periodStartLocal)->utc();
        $periodEndUtc = (clone $periodEndLocal)->utc();

        $quotesToday = QuoteRequest::query()
            ->whereBetween('created_at', [$periodStartUtc, $periodEndUtc])
            ->count();

        $quotesInProgressToday = QuoteRequest::query()
            ->whereBetween('created_at', [$periodStartUtc, $periodEndUtc])
            ->where('status', 'in_progress')
            ->count();

        $quotesDoneToday = QuoteRequest::query()
            ->whereBetween('created_at', [$periodStartUtc, $periodEndUtc])
            ->where('status', 'done')
            ->count();

        $trackingTodayQuery = TrackingRequest::query()
            ->whereBetween('created_at', [$periodStartUtc, $periodEndUtc]);

        $trackingToday = (clone $trackingTodayQuery)->count();

        return [
            Stat::make('Заявок на расчет ' . $periodLabel, (string) $quotesToday)
                ->description('Создано')
                ->color('primary')
                ->icon('heroicon-o-document-text'),
            Stat::make('В работе ' . $periodLabel, (string) $quotesInProgressToday)
                ->description('Статус: В работе')
                ->color('warning')
                ->icon('heroicon-o-clock'),
            Stat::make('Завершено ' . $periodLabel, (string) $quotesDoneToday)
                ->description('Статус: Завершена')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
            Stat::make('Трекинг-запросов ' . $periodLabel, (string) $trackingToday)
                ->description('Все проверки трек-кода')
                ->color('info')
                ->icon('heroicon-o-magnifying-glass'),
        ];
    }
}
