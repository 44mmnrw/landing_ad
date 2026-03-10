<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title }} — Авто Доставка</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
@include('partials.header')

<main class="content-page">
    <section class="section section-soft content-page-section">
        <div class="container content-page-container">
            @php
                $pageIconId = preg_replace('/[^a-z0-9\-_]/i', '', (string) ($page->icon ?? ''));
            @endphp
            <div class="content-page-title">
                @if($pageIconId !== '')
                    <span class="content-page-title-icon" aria-hidden="true">
                        <svg viewBox="0 0 32 32" role="img" focusable="false">
                            <use href="{{ asset('icons/sprite.svg#' . $pageIconId) }}"></use>
                        </svg>
                    </span>
                @endif
                <h1>{{ $page->title }}</h1>
            </div>
            <div class="content-page-body">
                {!! (string) $page->content !!}
            </div>
        </div>
    </section>
</main>

@include('partials.footer')
@include('partials.calc-modal')
</body>
</html>
