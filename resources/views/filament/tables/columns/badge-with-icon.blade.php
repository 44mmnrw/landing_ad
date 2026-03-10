@php
    $record = $getRecord();
    $badgeText = trim((string) data_get($record, 'badge', ''));
    $iconId = preg_replace('/[^a-z0-9\-_]/i', '', (string) data_get($record, 'meta.badge_icon', ''));

    if ($iconId === '') {
        $sectionCode = (string) data_get($record, 'section.code', '');
        $sortOrder = max(1, (int) data_get($record, 'sort_order', 1));

        $fallbackMap = [
            'about' => ['icon-about-calendar', 'icon-about-globe', 'icon-about-shield', 'icon-about-clock'],
            'services' => ['icon-service-box', 'icon-service-alert', 'icon-service-gear', 'icon-service-doc'],
            'advantages' => ['icon-adv-manager', 'icon-adv-shield'],
            'steps' => ['icon-step-search', 'icon-step-truck', 'icon-step-dollar'],
            'stats' => ['icon-stat-market', 'icon-stat-delivery', 'icon-stat-team', 'icon-stat-driver', 'icon-stat-contract'],
        ];

        $sectionIcons = $fallbackMap[$sectionCode] ?? [];
        $iconId = $sectionIcons[$sortOrder - 1] ?? '';
    }

    $hasDisplayValue = $badgeText !== '' || $iconId !== '';
@endphp

<span style="display:inline-flex; align-items:center; gap:8px;">
    @if($iconId !== '')
        <svg viewBox="0 0 20 20" style="width:16px; height:16px; flex:0 0 auto; fill:none;">
            <use href="{{ asset('icons/sprite.svg#' . $iconId) }}" style="fill:none;"></use>
        </svg>
    @endif

    @if($badgeText !== '')
        <span>{{ $badgeText }}</span>
    @elseif(!$hasDisplayValue)
        <span>—</span>
    @endif
</span>
