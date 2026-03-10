<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use UnitEnum;

class LandingContentEditor extends Page
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Контент-редактор';

    protected static string | UnitEnum | null $navigationGroup = 'Контент лендинга';

    protected static ?int $navigationSort = -100;

    protected string $view = 'filament.pages.landing-content-editor';
}
