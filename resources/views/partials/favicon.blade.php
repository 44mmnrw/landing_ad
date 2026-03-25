@php
    $faviconPath = trim((string) ($siteSettings['favicon_path'] ?? ''));

    $faviconUrl = '';

    if ($faviconPath !== '') {
        if (str_starts_with($faviconPath, 'http://') || str_starts_with($faviconPath, 'https://') || str_starts_with($faviconPath, '//')) {
            $faviconUrl = $faviconPath;
        } elseif (str_starts_with($faviconPath, '/')) {
            $faviconUrl = asset(ltrim($faviconPath, '/'));
        } else {
            $faviconUrl = asset('storage/' . ltrim($faviconPath, '/'));
        }
    }
@endphp

@if($faviconUrl !== '')
    {{--
        Требования к favicon:
        1) Квадратная иконка.
        2) Рекомендуемые размеры: 32x32 или 48x48.
        3) Допустимые форматы: .ico, .png, .svg.
        4) Рекомендуемый размер файла: до 512 КБ.
    --}}
    <link rel="icon" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" href="{{ $faviconUrl }}">
@endif
