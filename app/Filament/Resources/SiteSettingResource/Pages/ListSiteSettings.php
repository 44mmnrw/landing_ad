<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Resources\SiteSettingResource;
use App\Models\SiteSetting;
use App\Support\LandingContentCatalog;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSiteSettings extends ListRecords
{
    protected static string $resource = SiteSettingResource::class;

    protected const array HIDDEN_KEYS = [
        'site_logo_image_path',
        'yandex_metrika_counter_id',
        'google_analytics_measurement_id',
    ];

    public function mount(): void
    {
        parent::mount();

        $this->syncMissingSettings();
    }

    protected function syncMissingSettings(): void
    {
        foreach (array_diff(array_keys(LandingContentCatalog::siteSettingOptions()), self::HIDDEN_KEYS) as $key) {
            SiteSetting::query()->firstOrCreate(
                ['key' => $key],
                ['value' => '', 'is_public' => true],
            );
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
