<?php

namespace App\Filament\Resources\LandingSectionItemResource\Pages;

use App\Filament\Resources\LandingSectionItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLandingSectionItems extends ListRecords
{
    protected static string $resource = LandingSectionItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
