<?php

namespace Database\Seeders;

use App\Models\LandingSection;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class LandingContentSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $sections = [
            [
                'code' => 'hero',
                'title' => '',
                'subtitle' => '',
                'background_image' => null,
                'meta' => [
                    'primary_button_text' => '',
                    'primary_button_url' => '#',
                    'secondary_button_text' => '',
                    'secondary_button_url' => '#',
                ],
                'sort_order' => 10,
                'items' => [],
            ],
            [
                'code' => 'about',
                'title' => '',
                'subtitle' => '',
                'sort_order' => 20,
                'items' => [],
            ],
            [
                'code' => 'services',
                'title' => '',
                'subtitle' => '',
                'sort_order' => 30,
                'items' => [],
            ],
            [
                'code' => 'advantages',
                'title' => '',
                'sort_order' => 40,
                'items' => [],
            ],
            [
                'code' => 'steps',
                'title' => '',
                'sort_order' => 50,
                'items' => [],
            ],
            [
                'code' => 'stats',
                'title' => '',
                'subtitle' => '',
                'sort_order' => 60,
                'items' => [],
            ],
            [
                'code' => 'mission',
                'title' => '',
                'subtitle' => '',
                'background_image' => null,
                'meta' => [
                    'accent_text' => '',
                ],
                'sort_order' => 70,
                'items' => [],
            ],
            [
                'code' => 'clients',
                'title' => '',
                'subtitle' => '',
                'meta' => [
                    'trust_text' => '',
                ],
                'sort_order' => 80,
                'items' => [],
            ],
            [
                'code' => 'geography_countries',
                'title' => '',
                'subtitle' => '',
                'background_image' => null,
                'sort_order' => 90,
                'items' => [],
            ],
            [
                'code' => 'geography_routes',
                'title' => '',
                'sort_order' => 91,
                'items' => [],
            ],
            [
                'code' => 'cta',
                'title' => '',
                'subtitle' => '',
                'meta' => [
                    'button_text' => '',
                    'button_url' => '#',
                ],
                'sort_order' => 100,
                'items' => [],
            ],
            [
                'code' => 'footer_navigation',
                'title' => '',
                'sort_order' => 110,
                'items' => [],
            ],
            [
                'code' => 'footer_contacts',
                'title' => '',
                'sort_order' => 120,
                'items' => [],
            ],
            [
                'code' => 'footer_services',
                'title' => '',
                'sort_order' => 130,
                'items' => [],
            ],
        ];

        foreach ($sections as $sectionData) {
            $items = $sectionData['items'] ?? [];
            unset($sectionData['items']);

            $section = LandingSection::query()->updateOrCreate(
                ['code' => $sectionData['code']],
                [
                    'title' => $sectionData['title'] ?? null,
                    'subtitle' => $sectionData['subtitle'] ?? null,
                    'background_image' => $sectionData['background_image'] ?? null,
                    'meta' => $sectionData['meta'] ?? null,
                    'sort_order' => $sectionData['sort_order'] ?? 0,
                    'is_active' => true,
                ]
            );

            $section->items()->delete();

            foreach ($items as $index => $item) {
                $section->items()->create([
                    'title' => $item['title'],
                    'description' => $item['description'] ?? null,
                    'image_url' => $item['image_url'] ?? null,
                    'badge' => $item['badge'] ?? null,
                    'meta' => $item['meta'] ?? null,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }

        $settings = [
            'site_logo' => '',
            'site_logo_image_path' => '',
            'site_tagline' => '',
            'favicon_path' => '',
            'footer_copyright' => '',
            'footer_geo_text' => '',
            'contact_phone' => '',
            'contact_email' => '',
            'contact_telegram_url' => '',
            'yandex_metrika_counter_id' => '',
            'google_analytics_measurement_id' => '',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'is_public' => true]
            );
        }
    }
}
