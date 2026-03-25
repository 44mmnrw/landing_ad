@php
    $plainSetting = static fn ($value, string $default = ''): string => trim(html_entity_decode(strip_tags((string) ($value ?? $default)), ENT_QUOTES | ENT_HTML5, 'UTF-8'));

    $resolveBackground = static function (?string $path): string {
        if (blank($path)) {
            return '';
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '//')) {
            return $path;
        }

        if (str_starts_with($path, '/')) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/' . ltrim($path, '/'));
    };

    $isCarouselEnabled = static function ($section): bool {
        $raw = data_get($section?->meta ?? [], 'carousel_enabled', false);

        return filter_var($raw, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false;
    };

    $carouselSpeed = static function ($section): int {
        $speed = (int) data_get($section?->meta ?? [], 'carousel_speed_ms', 3500);

        return max(500, $speed > 0 ? $speed : 3500);
    };

    $hero = $landingSections->get('hero');
    $heroMeta = $hero?->meta ?? [];

    $about = $landingSections->get('about');
    $aboutIcons = [
        'icon-about-calendar',
        'icon-about-globe',
        'icon-about-shield',
        'icon-about-clock',
    ];
    $services = $landingSections->get('services');
    $serviceIcons = [
        'icon-service-box',
        'icon-service-alert',
        'icon-service-gear',
        'icon-service-doc',
    ];
    $advantages = $landingSections->get('advantages');
    $advantageIcons = [
        'icon-adv-manager',
        'icon-adv-shield',
    ];
    $stepIcons = [
        'icon-step-search',
        'icon-step-truck',
        'icon-step-dollar',
    ];
    $stats = $landingSections->get('stats');
    $statsIcons = [
        'icon-stat-market',
        'icon-stat-delivery',
        'icon-stat-team',
        'icon-stat-driver',
        'icon-stat-contract',
    ];
    $mission = $landingSections->get('mission');
    $clients = $landingSections->get('clients');
    $clientsMeta = $clients?->meta ?? [];
    $countries = $landingSections->get('geography_countries');
    $cta = $landingSections->get('cta');
    $ctaMeta = $cta?->meta ?? [];
@endphp

<main>
    @foreach($landingSections as $section)
        @switch($section->code)
            @case('hero')
                @php $heroMeta = $section->meta ?? []; @endphp
                <section id="hero" class="hero" style="background-image:url('{{ $resolveBackground($section->background_image) }}')">
                    <div class="hero-overlay"></div>
                    <div class="container hero-content">
                        <h1>{{ $section->title }}</h1>
                        <p>{{ $section->subtitle }}</p>
                        <div class="hero-actions">
                            <a class="btn btn-hero btn-hero-primary js-open-calc-modal" href="{{ $heroMeta['primary_button_url'] ?? '' }}">
                                {{ $heroMeta['primary_button_text'] ?? '' }}
                            </a>
                            <a class="btn btn-hero btn-hero-secondary" href="{{ $heroMeta['secondary_button_url'] ?? '' }}">{{ $heroMeta['secondary_button_text'] ?? '' }}</a>
                        </div>
                    </div>
                    <div class="hero-scroll-indicator" aria-hidden="true"><span></span></div>
                </section>
                @break

            @case('about')
                <section id="about" class="section section-soft about-section">
                    <div class="container">
                        <h2>{{ $section->title }}</h2>
                        <p class="section-sub">{{ $section->subtitle }}</p>
                        <div class="grid grid-4 about-grid js-section-carousel" data-carousel-enabled="{{ $isCarouselEnabled($section) ? '1' : '0' }}" data-carousel-speed="{{ $carouselSpeed($section) }}">
                            @foreach(($section->items ?? collect()) as $item)
                                @php
                                    $iconId = preg_replace('/[^a-z0-9\-_]/i', '', (string) ($item->meta['badge_icon'] ?? ''));
                                    $iconId = $iconId !== '' ? $iconId : ($aboutIcons[$loop->index] ?? 'icon-about-clock');
                                @endphp
                                <article class="card about-card">
                                    <span class="about-card-icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" role="img" focusable="false">
                                            <use href="{{ asset('icons/sprite.svg#' . $iconId) }}"></use>
                                        </svg>
                                    </span>
                                    <h3>{{ $item->title }}</h3>
                                    <p>{{ $item->description }}</p>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </section>
                @break

            @case('services')
                <section id="services" class="section services-section">
                    <div class="container">
                        <h2>{{ $section->title }}</h2>
                        <p class="section-sub">{{ $section->subtitle }}</p>
                        <div class="grid grid-4 services-grid js-section-carousel" data-carousel-enabled="{{ $isCarouselEnabled($section) ? '1' : '0' }}" data-carousel-speed="{{ $carouselSpeed($section) }}">
                            @foreach(($section->items ?? collect()) as $item)
                                @php
                                    $serviceIconId = preg_replace('/[^a-z0-9\-_]/i', '', (string) ($item->meta['badge_icon'] ?? ''));
                                    $serviceIconId = $serviceIconId !== '' ? $serviceIconId : ($serviceIcons[$loop->index] ?? 'icon-service-doc');
                                @endphp
                                <article class="card card-muted service-card">
                                    <span class="service-card-icon" aria-hidden="true">
                                        <svg viewBox="0 0 28 28" role="img" focusable="false">
                                            <use href="{{ asset('icons/sprite.svg#' . $serviceIconId) }}"></use>
                                        </svg>
                                    </span>
                                    <h3>{{ $item->title }}</h3>
                                    <p>{{ $item->description }}</p>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </section>
                @break

            @case('advantages')
                <section class="section section-soft advantages-section">
                    <div class="container">
                        <h2>{{ $section->title }}</h2>
                        <div class="grid grid-2 advantages-grid js-section-carousel" data-carousel-enabled="{{ $isCarouselEnabled($section) ? '1' : '0' }}" data-carousel-speed="{{ $carouselSpeed($section) }}">
                            @foreach(($section->items ?? collect()) as $item)
                                @php
                                    $advantageIconId = preg_replace('/[^a-z0-9\-_]/i', '', (string) ($item->meta['badge_icon'] ?? ''));
                                    $advantageIconId = $advantageIconId !== '' ? $advantageIconId : ($advantageIcons[$loop->index] ?? 'icon-adv-shield');
                                @endphp
                                <article class="card center advantage-card">
                                    <span class="advantage-card-icon" aria-hidden="true">
                                        <svg viewBox="0 0 32 32" role="img" focusable="false">
                                            <use href="{{ asset('icons/sprite.svg#' . $advantageIconId) }}"></use>
                                        </svg>
                                    </span>
                                    <h3>{{ $item->title }}</h3>
                                    <p>{{ $item->description }}</p>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </section>
                @break

            @case('steps')
                <section class="section section-soft advantages-section">
                    <div class="container">
                        <h2>{{ $section->title }}</h2>
                        <div class="grid grid-3 steps-grid js-section-carousel" data-carousel-enabled="{{ $isCarouselEnabled($section) ? '1' : '0' }}" data-carousel-speed="{{ $carouselSpeed($section) }}">
                            @foreach(($section->items ?? collect()) as $item)
                                @php
                                    $stepIconId = preg_replace('/[^a-z0-9\-_]/i', '', (string) ($item->meta['badge_icon'] ?? ''));
                                    $stepIconId = $stepIconId !== '' ? $stepIconId : ($stepIcons[$loop->index] ?? 'icon-step-dollar');
                                @endphp
                                <article class="card step-card">
                                    <span class="step-index" aria-hidden="true">{{ $loop->iteration }}</span>
                                    <span class="step-card-icon" aria-hidden="true">
                                        <svg viewBox="0 0 28 28" role="img" focusable="false">
                                            <use href="{{ asset('icons/sprite.svg#' . $stepIconId) }}"></use>
                                        </svg>
                                    </span>
                                    <h3>{{ $item->title }}</h3>
                                    <p>{{ $item->description }}</p>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </section>
                @break

            @case('stats')
                <section class="section stats-section">
                    <div class="container">
                        <h2>{{ $section->title }}</h2>
                        <p class="section-sub">{{ $section->subtitle }}</p>
                        <div class="grid grid-5 stats-grid js-section-carousel" data-carousel-enabled="{{ $isCarouselEnabled($section) ? '1' : '0' }}" data-carousel-speed="{{ $carouselSpeed($section) }}">
                            @foreach(($section->items ?? collect()) as $item)
                                @php
                                    $statIconId = preg_replace('/[^a-z0-9\-_]/i', '', (string) ($item->meta['badge_icon'] ?? ''));
                                    $statIconId = $statIconId !== '' ? $statIconId : ($statsIcons[$loop->index] ?? 'icon-stat-contract');
                                @endphp
                                <article class="card center stat-card">
                                    <span class="stat-card-icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" role="img" focusable="false">
                                            <use href="{{ asset('icons/sprite.svg#' . $statIconId) }}"></use>
                                        </svg>
                                    </span>
                                    <strong>{{ $item->title }}</strong>
                                    <p>{{ $item->description }}</p>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </section>
                @break

            @case('mission')
                <section class="section mission" style="background-image:url('{{ $resolveBackground($section->background_image) }}')">
                    <div class="container">
                        <div class="mission-card">
                            <div class="mission-head">
                                <span class="mission-icon" aria-hidden="true">
                                    <svg viewBox="0 0 32 32" role="img" focusable="false">
                                        <use href="{{ asset('icons/sprite.svg#icon-mission-target') }}"></use>
                                    </svg>
                                </span>
                                <h2>{{ $section->title ?: 'Наша миссия' }}</h2>
                            </div>
                            <div class="mission-body">
                                <p>{{ $section->subtitle }}</p>
                                <p class="accent">{{ $section->meta['accent_text'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </section>
                @break

            @case('clients')
                @php $clientsMeta = $section->meta ?? []; @endphp
                <section class="section section-soft clients-section">
                    <div class="container">
                        <h2>{{ $section->title }}</h2>
                        <p class="section-sub">{{ $section->subtitle }}</p>
                        <div class="grid grid-3 clients-grid js-section-carousel" data-carousel-enabled="{{ $isCarouselEnabled($section) ? '1' : '0' }}" data-carousel-speed="{{ $carouselSpeed($section) }}">
                            @foreach(($section->items ?? collect()) as $item)
                                <article class="card client-card">
                                    <div class="client-card-head">
                                        <span class="client-card-icon" aria-hidden="true">
                                            <svg viewBox="0 0 24 24" role="img" focusable="false">
                                                <use href="{{ asset('icons/sprite.svg#icon-client-building') }}"></use>
                                            </svg>
                                        </span>
                                        <span class="client-card-check" aria-hidden="true">
                                            <svg viewBox="0 0 20 20" role="img" focusable="false">
                                                <use href="{{ asset('icons/sprite.svg#icon-client-check') }}"></use>
                                            </svg>
                                        </span>
                                    </div>
                                    <h3>{{ $item->title }}</h3>
                                    <p>{{ $item->description }}</p>
                                </article>
                            @endforeach
                        </div>
                        <div class="trust-pill">
                            <svg viewBox="0 0 20 20" role="img" focusable="false" aria-hidden="true">
                                <use href="{{ asset('icons/sprite.svg#icon-client-pill-check') }}"></use>
                            </svg>
                            <span>{{ $plainSetting($clientsMeta['trust_text'] ?? null) }}</span>
                        </div>
                    </div>
                </section>
                @break

            @case('geography_countries')
                <section id="geography" class="section geo geo-countries-section" style="background-image:url('{{ $resolveBackground($section->background_image) }}')">
                    <div class="container narrow">
                        <h2>{{ $section->title }}</h2>
                        <p class="section-sub">{{ $section->subtitle }}</p>
                        <div class="grid grid-4 geo-countries-grid js-section-carousel" data-carousel-enabled="{{ $isCarouselEnabled($section) ? '1' : '0' }}" data-carousel-speed="{{ $carouselSpeed($section) }}">
                            @foreach(($section->items ?? collect()) as $item)
                                <article class="card center geo-country-card">
                                    <span class="geo-country-icon" aria-hidden="true">
                                        <svg viewBox="0 0 32 32" role="img" focusable="false">
                                            <use href="{{ asset('icons/sprite.svg#icon-geo-map-pin') }}"></use>
                                        </svg>
                                    </span>
                                    <h3>{{ $item->title }}</h3>
                                    <p>{{ $item->description }}</p>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </section>
                @break

            @case('geography_routes')
                <section class="section geo geo-routes-section" style="background-image:url('{{ $resolveBackground($section->background_image) }}')">
                    <div class="container narrow">
                        <h3 class="routes-title">{{ $section->title }}</h3>
                        <div class="grid grid-3 routes routes-grid js-section-carousel" data-carousel-enabled="{{ $isCarouselEnabled($section) ? '1' : '0' }}" data-carousel-speed="{{ $carouselSpeed($section) }}">
                            @foreach(($section->items ?? collect()) as $item)
                                @php
                                    $routeParts = preg_split('/\s*(?:→|->|—>)\s*/u', (string) $item->title, 2);
                                    $fromCity = $routeParts[0] ?? '';
                                    $toCity = $routeParts[1] ?? null;
                                    $badgeIconId = preg_replace('/[^a-z0-9\-_]/i', '', (string) ($item->meta['badge_icon'] ?? ''));
                                @endphp
                                <article class="card route-card">
                                    <div class="route-line">
                                        @if($toCity)
                                            <span>{{ $fromCity }}</span>
                                            <svg viewBox="0 0 20 20" role="img" focusable="false" aria-hidden="true">
                                                <use href="{{ asset('icons/sprite.svg#icon-route-arrow-right') }}"></use>
                                            </svg>
                                            <span>{{ $toCity }}</span>
                                        @else
                                            <span>{{ $item->title }}</span>
                                        @endif
                                    </div>
                                    <p class="tag">
                                        @if(!empty($badgeIconId))
                                            <svg class="tag-icon" viewBox="0 0 20 20" role="img" focusable="false" aria-hidden="true">
                                                <use href="{{ asset('icons/sprite.svg#' . $badgeIconId) }}"></use>
                                            </svg>
                                        @endif
                                        <span>{{ $item->badge }}</span>
                                    </p>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </section>
                @break

            @case('cta')
                @php $ctaMeta = $section->meta ?? []; @endphp
                <section id="cta" class="section cta-wrap">
                    <div class="container narrow">
                        <div class="cta-card">
                            <h2>{{ $section->title }}</h2>
                            <p>{{ $section->subtitle }}</p>
                            <a class="btn btn-primary btn-calc js-open-calc-modal" href="{{ $ctaMeta['button_url'] ?? '' }}">
                                <svg viewBox="0 0 20 20" role="img" focusable="false" aria-hidden="true">
                                    <use href="{{ asset('icons/sprite.svg#icon-button-calculator') }}"></use>
                                </svg>
                                <span>{{ $ctaMeta['button_text'] ?? '' }}</span>
                            </a>
                        </div>
                    </div>
                </section>
                @break
        @endswitch
    @endforeach
</main>
