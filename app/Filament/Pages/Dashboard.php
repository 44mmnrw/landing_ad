<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('period')
                            ->label('Период')
                            ->options([
                                'today' => 'Сегодня',
                                'week' => 'Неделя',
                                'month' => 'Месяц',
                                'year' => 'Год',
                            ])
                            ->default('today')
                            ->native(false)
                            ->selectablePlaceholder(false)
                            ->required(),
                    ])
                    ->columns(1),
            ]);
    }
}
