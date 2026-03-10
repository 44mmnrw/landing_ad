<?php

namespace App\Support;

class LandingContentCatalog
{
    /**
     * @return array<string, string>
     */
    public static function sectionOptions(): array
    {
        return [
            'hero' => 'Hero (первый экран)',
            'about' => 'О компании',
            'services' => 'Услуги',
            'advantages' => 'Преимущества',
            'steps' => 'Как работаем',
            'stats' => 'Цифры',
            'mission' => 'Миссия',
            'clients' => 'Клиенты',
            'geography_countries' => 'География — страны',
            'geography_routes' => 'География — маршруты',
            'cta' => 'Финальный CTA',
            'footer_navigation' => 'Футер — навигация',
            'footer_contacts' => 'Футер — контакты',
            'footer_services' => 'Футер — услуги',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function sectionHints(): array
    {
        return [
            'hero' => 'Используются: title, subtitle, background_image и meta: primary_button_text/primary_button_url/secondary_button_text/secondary_button_url.',
            'mission' => 'Используются: title, subtitle, background_image и meta: accent_text.',
            'cta' => 'Используются: title, subtitle и meta: button_text/button_url.',
            'geography_routes' => 'Элементы этой секции выводят title + badge (срок доставки).',
            'footer_navigation' => 'Элементы: title, meta.url (например /#services).',
            'footer_contacts' => 'Элементы: title, meta.url (tel:/mailto:) или пусто для обычного текста.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function siteSettingOptions(): array
    {
        return [
            'site_logo' => 'Логотип/название в шапке',
            'site_name' => 'Название сайта',
            'site_tagline' => 'Подпись в футере',
            'clients_trust_text' => 'Текст доверия в блоке клиентов',
            'footer_copyright' => 'Нижняя строка футера (копирайт)',
            'footer_geo_text' => 'Нижняя строка футера (география)',
            'contact_phone' => 'Телефон',
            'contact_email' => 'Email',
            'contact_telegram_url' => 'Ссылка на Telegram',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function spriteIconOptions(): array
    {
        return [
            '' => '— Без иконки —',
            'icon-phone' => 'Телефон',
            'icon-message-square' => 'Сообщение',
            'icon-mail' => 'Почта',
            'icon-about-calendar' => 'Календарь',
            'icon-about-globe' => 'Глобус',
            'icon-about-shield' => 'Щит',
            'icon-about-clock' => 'Часы',
            'icon-service-box' => 'Коробка',
            'icon-service-alert' => 'Внимание',
            'icon-service-gear' => 'Шестерёнка',
            'icon-service-doc' => 'Документ',
            'icon-adv-manager' => 'Менеджер',
            'icon-adv-shield' => 'Защита',
            'icon-step-search' => 'Поиск',
            'icon-step-truck' => 'Грузовик',
            'icon-step-dollar' => 'Доллар',
            'icon-stat-market' => 'График',
            'icon-stat-delivery' => 'Доставка',
            'icon-stat-team' => 'Команда',
            'icon-stat-driver' => 'Водитель',
            'icon-stat-contract' => 'Контракт',
            'icon-mission-target' => 'Мишень',
            'icon-client-building' => 'Компания',
            'icon-client-check' => 'Галочка (клиент)',
            'icon-client-pill-check' => 'Галочка (бейдж)',
            'icon-geo-map-pin' => 'Гео-метка',
            'icon-route-arrow-right' => 'Стрелка вправо',
            'icon-button-calculator' => 'Калькулятор',
            'icon-telegram' => 'Telegram',
        ];
    }
}
