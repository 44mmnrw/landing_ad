@php
    $footerNav = $landingSections->get('footer_navigation');
    $footerContacts = $landingSections->get('footer_contacts');
    $footerServices = $landingSections->get('footer_services');
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

<footer id="contacts" class="site-footer">
    <div class="container footer-grid">
        <div>
            <h3>
                @if($logoImageUrl !== '')
                    <img class="footer-logo-image" src="{{ $logoImageUrl }}" alt="{{ $logoTitle !== '' ? $logoTitle : 'Логотип сайта' }}">
                @else
                    {{ $logoTitle }}
                @endif
            </h3>
            <p>{{ $plainSetting($siteSettings['site_tagline'] ?? null) }}</p>
        </div>
        <div>
            <h4>{{ $footerNav?->title }}</h4>
            <ul>
                @foreach(($footerNav?->items ?? collect()) as $item)
                    <li><a href="{{ $item->meta['url'] ?? '#' }}">{{ $item->title }}</a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4>{{ $footerServices?->title }}</h4>
            <ul>
                @foreach(($footerServices?->items ?? collect()) as $item)
                    <li>{{ $item->title }}</li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4>{{ $footerContacts?->title }}</h4>
            <ul>
                <li>
                    <a class="footer-contact-link" href="tel:{{ preg_replace('/\D+/', '', $siteSettings['contact_phone'] ?? '') }}">
                        <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                            <use href="{{ asset('icons/sprite.svg#icon-phone') }}"></use>
                        </svg>
                        {{ $plainSetting($siteSettings['contact_phone'] ?? null) }}
                    </a>
                </li>
                <li>
                    <a class="footer-contact-link" href="mailto:{{ $siteSettings['contact_email'] ?? '' }}">
                        <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                            <use href="{{ asset('icons/sprite.svg#icon-mail') }}"></use>
                        </svg>
                        {{ $plainSetting($siteSettings['contact_email'] ?? null) }}
                    </a>
                </li>
                @if(!empty($siteSettings['contact_telegram_url']))
                    <li>
                        <a class="footer-contact-link footer-telegram-link" href="{{ $siteSettings['contact_telegram_url'] }}" target="_blank" rel="noopener noreferrer">
                            <svg viewBox="0 0 240.1 240.1" aria-hidden="true" focusable="false">
                                <use href="{{ asset('icons/sprite.svg#icon-telegram') }}"></use>
                            </svg>
                            Telegram
                        </a>
                    </li>
                @endif
                @foreach(($footerContacts?->items ?? collect()) as $item)
                    @php
                        $url = (string) ($item->meta['url'] ?? '');
                        $isPhoneOrEmail = str_starts_with($url, 'tel:') || str_starts_with($url, 'mailto:');
                    @endphp
                    @if($isPhoneOrEmail)
                        @continue
                    @endif
                    <li>
                        @if(!empty($item->meta['url']))
                            <a class="footer-contact-link" href="{{ $item->meta['url'] }}">
                                <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                                    <use href="{{ asset('icons/sprite.svg#icon-message-square') }}"></use>
                                </svg>
                                {{ $item->title }}
                            </a>
                        @else
                            {{ $item->title }}
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="container footer-bottom">
        <span>{{ $plainSetting($siteSettings['footer_copyright'] ?? null) }}</span>
        <span>{!! $siteSettings['footer_geo_text'] ?? '' !!}</span>
    </div>
</footer>

@include('partials.metrics-counters')
