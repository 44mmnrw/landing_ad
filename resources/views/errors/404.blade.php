<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Груз не найден</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="not-found-page">
@php
    $siteSettings = $siteSettings ?? [];
    $landingSections = $landingSections ?? collect();
@endphp

@include('partials.header')

<main class="not-found-main">
    <section class="not-found-card" aria-labelledby="not-found-title">
        <span class="not-found-decor not-found-decor--top" aria-hidden="true">
            <svg viewBox="0 0 28 28" role="img" focusable="false">
                <use href="{{ asset('icons/sprite.svg#icon-service-box') }}"></use>
            </svg>
        </span>
        <span class="not-found-decor not-found-decor--bottom" aria-hidden="true">
            <svg viewBox="0 0 28 28" role="img" focusable="false">
                <use href="{{ asset('icons/sprite.svg#icon-step-truck') }}"></use>
            </svg>
        </span>

        <div class="not-found-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 28 28" role="img" focusable="false">
                <use href="{{ asset('icons/sprite.svg#icon-step-search') }}"></use>
            </svg>
        </div>

        <h1 class="not-found-code">404</h1>
        <h2 id="not-found-title" class="not-found-title">Груз не найден</h2>
        <p class="not-found-text">К сожалению, запрашиваемая страница не существует или была перемещена. Возможно, она отправилась в другой маршрут!</p>

        <div class="not-found-actions">
            <a class="btn not-found-btn not-found-btn--primary" href="{{ url('/') }}">
                <span aria-hidden="true">⌂</span>
                <span>Вернуться на главную</span>
            </a>
            <a class="btn not-found-btn not-found-btn--secondary" href="{{ route('tracking') }}">
                <svg viewBox="0 0 28 28" role="img" focusable="false" aria-hidden="true">
                    <use href="{{ asset('icons/sprite.svg#icon-step-truck') }}"></use>
                </svg>
                <span>Отследить груз</span>
            </a>
        </div>

        <div class="not-found-links-wrap">
            <p>Популярные разделы:</p>
            <nav aria-label="Популярные разделы">
                <a href="{{ url('/#services') }}">Услуги</a>
                <span>•</span>
                <a href="{{ url('/#about') }}">О компании</a>
                <span>•</span>
                <a href="{{ url('/#contacts') }}">Контакты</a>
                <span>•</span>
                <a href="{{ url('/pages/politika-konfidencialnosti') }}">Политика конфиденциальности</a>
            </nav>
        </div>
    </section>
</main>

@include('partials.footer')
@include('partials.calc-modal')
</body>
</html>
