@php
    $plainSetting = static fn ($value, string $default = ''): string => trim(html_entity_decode(strip_tags((string) ($value ?? $default)), ENT_QUOTES | ENT_HTML5, 'UTF-8'));

    $logoTitle = $plainSetting($siteSettings['site_logo'] ?? null);
    $logoImagePath = trim((string) ($siteSettings['site_logo_image_path'] ?? ''));
    $logoImageUrl = '';

    if ($logoImagePath !== '') {
        if (str_starts_with($logoImagePath, 'http://') || str_starts_with($logoImagePath, 'https://') || str_starts_with($logoImagePath, '//')) {
            $logoImageUrl = $logoImagePath;
        } elseif (str_starts_with($logoImagePath, '/')) {
            $logoImageUrl = asset(ltrim($logoImagePath, '/'));
        } else {
            $logoImageUrl = asset('storage/' . ltrim($logoImagePath, '/'));
        }
    }
@endphp

<header class="site-header">
    <div class="container header-inner">
        <a class="logo" href="{{ url('/') }}">
            {{-- Требования к логотипу: форматы .png/.svg/.webp, рекомендованная ширина 160-320px, высота до 64px, размер до 1 МБ. --}}
            @if($logoImageUrl !== '')
                <img class="logo-image" src="{{ $logoImageUrl }}" alt="{{ $logoTitle !== '' ? $logoTitle : 'Логотип сайта' }}">
            @else
                {{ $logoTitle }}
            @endif
        </a>
        <nav class="header-nav">
            <a href="{{ url('/#hero') }}">Главная</a>
            <a href="{{ url('/#services') }}">Услуги</a>
            <a href="{{ url('/#about') }}">О нас</a>
            <a href="{{ url('/#contacts') }}">Контакты</a>
        </nav>
        <div class="header-actions">
            <a class="btn btn-outline btn-sm" href="{{ route('tracking') }}">Отследить груз</a>
            <a class="btn btn-primary btn-sm js-open-calc-modal" href="#">Получить расчет</a>
        </div>
    </div>
</header>
