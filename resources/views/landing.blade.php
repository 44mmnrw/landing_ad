<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $plainSetting = static fn ($value, string $default = ''): string => trim(html_entity_decode(strip_tags((string) ($value ?? $default)), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        $siteTitle = $plainSetting($siteSettings['site_logo'] ?? null);
    @endphp
    <title>{{ $siteTitle !== '' ? $siteTitle : 'Landing' }}</title>
    @includeIf('partials.favicon')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
@include('partials.header')

@include('partials.main')

@include('partials.footer')

@include('partials.calc-modal')

</body>
</html>
