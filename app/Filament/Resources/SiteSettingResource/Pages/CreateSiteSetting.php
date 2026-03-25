<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Resources\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Resources\Pages\CreateRecord;

class CreateSiteSetting extends CreateRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (($data['key'] ?? null) === 'favicon_path') {
            $rawState = $this->form->getRawState();

            $data['value'] = trim((string) ($rawState['favicon_file'] ?? ($data['value'] ?? '')));

            return $data;
        }

        if (($data['key'] ?? null) !== 'site_logo') {
            return $data;
        }

        $rawState = $this->form->getRawState();

        $logoText = trim((string) ($rawState['logo_text'] ?? ($data['value'] ?? '')));
        $logoImagePath = trim((string) ($rawState['logo_image_path'] ?? ''));

        SiteSetting::query()->updateOrCreate(
            ['key' => 'site_logo_image_path'],
            [
                'value' => $logoImagePath,
                'is_public' => (bool) ($data['is_public'] ?? true),
            ],
        );

        $data['value'] = $logoText;

        return $data;
    }
}
