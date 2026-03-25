<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $plainSetting = static fn ($value, string $default = ''): string => trim(html_entity_decode(strip_tags((string) ($value ?? $default)), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        $siteTitle = $plainSetting($siteSettings['site_logo'] ?? null);
        $contactPhone = $plainSetting($siteSettings['contact_phone'] ?? null);
        $contactPhoneHref = preg_replace('/\D+/', '', $contactPhone);
        $contactEmail = $plainSetting($siteSettings['contact_email'] ?? null);
    @endphp
    <title>Отследить груз{{ $siteTitle !== '' ? ' — ' . $siteTitle : '' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @includeIf('partials.favicon')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="tracking-page">
@include('partials.header')

<main class="tracking-main-wrap">
    <section class="tracking-hero">
        <div class="tracking-icon-wrap">
            <svg viewBox="0 0 28 28" role="img" focusable="false" aria-hidden="true">
                <use href="{{ asset('icons/sprite.svg') }}#icon-step-truck"></use>
            </svg>
        </div>
        <h1>Отследить груз</h1>
        <p>Введите номер отслеживания для получения актуальной информации о местонахождении вашего груза</p>
    </section>

    <section class="tracking-search-card">
        <form class="tracking-form" autocomplete="off" method="get" action="{{ route('tracking') }}">
            <input id="trackingInput" name="code" type="text" value="{{ $searchCode }}" placeholder="Введите трек-код" aria-label="Номер отслеживания" autocomplete="one-time-code" autocorrect="off" autocapitalize="off" spellcheck="false" data-lpignore="true" data-1p-ignore="true" data-form-type="other">
            <button type="submit" class="tracking-search-btn">
                <svg viewBox="0 0 28 28" role="img" focusable="false" aria-hidden="true">
                    <use href="{{ asset('icons/sprite.svg') }}#icon-step-search"></use>
                </svg>
                Найти
            </button>
        </form>
        <p class="tracking-hint">Проверьте статус по вашему трек-коду.</p>
    </section>

    <section class="tracking-result-card" id="trackingCard">
        <div class="tracking-card-head">
            <div>
                <span>Номер отслеживания</span>
                <h2 id="trackCode">{{ $latestEvent?->tracking_number ?? ($searchCode ?: '—') }}</h2>
                <p class="tracking-route">
                    <svg viewBox="0 0 28 28" role="img" focusable="false" aria-hidden="true">
                        <use href="{{ asset('icons/sprite.svg') }}#icon-geo-map-pin"></use>
                    </svg>
                    <span id="trackRoute">
                        @if($latestEvent?->latitude !== null && $latestEvent?->longitude !== null)
                            {{ $latestEvent->latitude }}, {{ $latestEvent->longitude }}
                        @else
                            —
                        @endif
                    </span>
                </p>
            </div>
            <div class="tracking-cargo-meta">
                <span>Текущий статус</span>
                <strong id="trackType">{{ $statusLabels[$latestEvent?->status ?? ''] ?? ($latestEvent?->status ?? '—') }}</strong>
                <small id="trackWeight">{{ $latestEvent?->occurred_at ? $latestEvent->occurred_at->format('d.m.Y H:i') : '—' }}</small>
            </div>
        </div>

        <div class="tracking-body">
            <h3>История статусов</h3>
            <div class="tracking-timeline" id="timeline">
                @if($latestEvent && $events->isNotEmpty())
                    @foreach($events as $event)
                        <div class="tracking-step {{ $loop->first ? 'is-done' : 'is-pending' }}">
                            <div class="tracking-step-line {{ $loop->last ? 'is-last' : '' }}">
                                @if($loop->first)
                                    <svg viewBox="0 0 20 20" role="img" focusable="false" aria-hidden="true">
                                        <use href="{{ asset('icons/sprite.svg') }}#icon-client-check"></use>
                                    </svg>
                                @else
                                    <span class="dot"></span>
                                @endif
                            </div>
                            <div class="tracking-step-card">
                                <div class="tracking-step-head">
                                    <h4>{{ $eventLabels[$event->event_type] ?? $event->event_type }}</h4>
                                    <span>{{ $event->occurred_at ? $event->occurred_at->format('d.m.Y H:i') : '—' }}</span>
                                </div>
                                <p>
                                    <svg viewBox="0 0 32 32" role="img" focusable="false" aria-hidden="true">
                                        <use href="{{ asset('icons/sprite.svg') }}#icon-geo-map-pin"></use>
                                    </svg>
                                    @if($event->latitude !== null && $event->longitude !== null)
                                        {{ $event->latitude }}, {{ $event->longitude }}
                                    @elseif($event->notes)
                                        {{ $event->notes }}
                                    @else
                                        {{ $statusLabels[$event->status] ?? $event->status }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                @elseif($searchedWithCode)
                    <div class="tracking-empty">Номер не найден.</div>
                @else
                    <div class="tracking-empty">Введите номер отслеживания и нажмите «Найти».</div>
                @endif
            </div>
        </div>

        <div class="tracking-footer-note">
            @if($contactPhone !== '' || $contactEmail !== '')
                Возникли вопросы?
                @if($contactPhone !== '' && $contactPhoneHref !== '')
                    Свяжитесь с нами по телефону <a href="tel:{{ $contactPhoneHref }}">{{ $contactPhone }}</a>
                @endif
                @if($contactEmail !== '')
                    @if($contactPhone !== '' && $contactPhoneHref !== '')
                        или
                    @endif
                    напишите на <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>
                @endif
            @endif
        </div>
    </section>

    <a class="tracking-back-link" href="{{ url('/') }}">← Вернуться на главную</a>
</main>

@include('partials.footer')

@include('partials.calc-modal')
</body>
</html>
