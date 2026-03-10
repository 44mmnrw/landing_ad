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
                'title' => 'Надежные грузоперевозки по России и СНГ',
                'subtitle' => 'Срочные доставки. Сложные маршруты. Международная логистика.',
                'background_image' => null,
                'meta' => [
                    'primary_button_text' => 'Получить расчет',
                    'primary_button_url' => '#',
                    'secondary_button_text' => 'Отследить груз',
                    'secondary_button_url' => '/tracking',
                ],
                'sort_order' => 10,
                'items' => [],
            ],
            [
                'code' => 'about',
                'title' => 'Кто мы',
                'subtitle' => 'Компания «Авто Доставка» — это надежный партнер в сфере грузоперевозок',
                'sort_order' => 20,
                'items' => [
                    ['title' => 'На рынке с 2018 года', 'description' => '6+ лет успешной работы в сфере логистики'],
                    ['title' => 'Россия, Китай, Турция, Казахстан', 'description' => 'Международная логистика и внутренние перевозки'],
                    ['title' => 'Контроль 24/7', 'description' => 'Страхование каждого груза и полная ответственность'],
                    ['title' => 'Подбор транспорта за 1–3 дня', 'description' => 'Быстрый старт и оперативная доставка'],
                ],
            ],
            [
                'code' => 'services',
                'title' => 'Что перевозим',
                'subtitle' => 'Широкий спектр логистических решений для вашего бизнеса',
                'sort_order' => 30,
                'items' => [
                    ['title' => 'Сборные грузы', 'description' => 'Экономичная доставка для небольших партий товаров'],
                    ['title' => 'Опасные и негабаритные', 'description' => 'Специализированная перевозка сложных грузов'],
                    ['title' => 'Промышленное оборудование', 'description' => 'Профессиональная доставка тяжелой техники'],
                    ['title' => 'Таможенное оформление и СВХ', 'description' => 'Полный комплекс услуг по таможенному сопровождению'],
                ],
            ],
            [
                'code' => 'advantages',
                'title' => 'Преимущества работы с нами',
                'sort_order' => 40,
                'items' => [
                    ['title' => 'Персональный менеджер', 'description' => 'Индивидуальный подход к каждому клиенту'],
                    ['title' => 'Страхование ответственности', 'description' => 'Гарантия сохранности вашего груза'],
                ],
            ],
            [
                'code' => 'steps',
                'title' => 'Как работаем',
                'sort_order' => 50,
                'items' => [
                    ['title' => '1. Подбор транспорта', 'description' => 'Подбираем оптимальный вариант за 1–3 дня'],
                    ['title' => '2. Доставка из Китая', 'description' => 'Проверенные маршруты и надежные партнеры'],
                    ['title' => '3. Прозрачная стоимость', 'description' => 'Без скрытых платежей и дополнительных сборов'],
                ],
            ],
            [
                'code' => 'stats',
                'title' => 'Почему выбирают нас',
                'subtitle' => 'Цифры и факты, которые говорят сами за себя',
                'sort_order' => 60,
                'items' => [
                    ['title' => '6+', 'description' => 'лет на рынке'],
                    ['title' => '1000+', 'description' => 'доставок'],
                    ['title' => '25', 'description' => 'сотрудников'],
                    ['title' => '15', 'description' => 'опытных водителей'],
                    ['title' => '100%', 'description' => 'работа по договору'],
                ],
            ],
            [
                'code' => 'mission',
                'title' => 'Наша миссия',
                'subtitle' => 'Оставаться надежным и ответственным поставщиком автотранспортных услуг.',
                'background_image' => null,
                'meta' => [
                    'accent_text' => 'Нести пользу, доставляя решения!',
                ],
                'sort_order' => 70,
                'items' => [],
            ],
            [
                'code' => 'clients',
                'title' => 'Нам доверяют',
                'subtitle' => 'Наши клиенты — это наша гордость',
                'sort_order' => 80,
                'items' => [
                    ['title' => 'ZUBK.NET', 'description' => 'Доставка металлоконструкций'],
                    ['title' => 'PermMetall', 'description' => 'Регулярная логистика по России'],
                    ['title' => 'ПСК БТ', 'description' => 'Логистика стройматериалов'],
                ],
            ],
            [
                'code' => 'geography_countries',
                'title' => 'География перевозок',
                'subtitle' => 'Мы работаем по всей России и международным направлениям',
                'background_image' => null,
                'sort_order' => 90,
                'items' => [
                    ['title' => 'Россия', 'description' => 'Вся территория РФ'],
                    ['title' => 'Китай', 'description' => 'Основные направления'],
                    ['title' => 'Турция', 'description' => 'Регулярные рейсы'],
                    ['title' => 'Казахстан', 'description' => 'Приграничная логистика'],
                ],
            ],
            [
                'code' => 'geography_routes',
                'title' => 'Примеры маршрутов',
                'sort_order' => 91,
                'items' => [
                    ['title' => 'Китай → Новосибирск', 'badge' => '17 дней'],
                    ['title' => 'Турция → Москва', 'badge' => '10–12 дней'],
                    ['title' => 'Казахстан → Екатеринбург', 'badge' => '5–7 дней'],
                ],
            ],
            [
                'code' => 'cta',
                'title' => 'Рассчитаем доставку под ваш маршрут',
                'subtitle' => 'Получите индивидуальное предложение с учетом всех особенностей вашего груза',
                'meta' => [
                    'button_text' => 'Получить расчет',
                    'button_url' => '#',
                ],
                'sort_order' => 100,
                'items' => [],
            ],
            [
                'code' => 'footer_navigation',
                'title' => 'Навигация',
                'sort_order' => 110,
                'items' => [
                    ['title' => 'Главная', 'meta' => ['url' => '/#hero']],
                    ['title' => 'Услуги', 'meta' => ['url' => '/#services']],
                    ['title' => 'О нас', 'meta' => ['url' => '/#about']],
                ],
            ],
            [
                'code' => 'footer_contacts',
                'title' => 'Контакты',
                'sort_order' => 120,
                'items' => [
                    ['title' => '+7 912 280 51 38', 'meta' => ['url' => 'tel:+79122805138']],
                    ['title' => 'st_air@mail.ru', 'meta' => ['url' => 'mailto:st_air@mail.ru']],
                ],
            ],
            [
                'code' => 'footer_services',
                'title' => 'Услуги',
                'sort_order' => 130,
                'items' => [
                    ['title' => 'Сборные грузы'],
                    ['title' => 'Негабаритные перевозки'],
                    ['title' => 'Таможенное оформление'],
                ],
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
            'site_logo' => '🚚 Авто Доставка',
            'site_name' => 'Авто Доставка',
            'site_tagline' => 'Надежные грузоперевозки по России и СНГ с 2018 года',
            'clients_trust_text' => 'Более 100 довольных клиентов по всей России',
            'footer_copyright' => '© 2026 Авто Доставка. Все права защищены.',
            'footer_geo_text' => 'Россия, Китай, Турция, Казахстан',
            'contact_phone' => '+7 912 280 51 38',
            'contact_email' => 'st_air@mail.ru',
            'contact_telegram_url' => 'https://t.me/sss_air',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'is_public' => true]
            );
        }
    }
}
