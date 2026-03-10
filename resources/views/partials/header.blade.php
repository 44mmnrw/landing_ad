@php
    $plainSetting = static fn ($value, string $default = ''): string => trim(html_entity_decode(strip_tags((string) ($value ?? $default)), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
@endphp

<header class="site-header">
    <div class="container header-inner">
        <a class="logo" href="{{ url('/') }}">{{ $plainSetting($siteSettings['site_logo'] ?? null, '🚚 Авто Доставка') }}</a>
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
