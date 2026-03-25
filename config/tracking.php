<?php

return [
    'internal' => [
        'hmac_secret' => env('TRACKING_INTERNAL_HMAC_SECRET'),
        'require_https' => (bool) env('TRACKING_INTERNAL_REQUIRE_HTTPS', true),
        'clock_skew_seconds' => (int) env('TRACKING_INTERNAL_CLOCK_SKEW_SECONDS', 300),
        'allowed_ips' => array_values(array_filter(array_map('trim', explode(',', (string) env('TRACKING_INTERNAL_ALLOWED_IPS', '127.0.0.1'))))),
        'rate_limit_per_minute' => (int) env('TRACKING_INTERNAL_RATE_LIMIT_PER_MINUTE', 120),
    ],
    'public' => [
        'events_limit' => (int) env('TRACKING_PUBLIC_EVENTS_LIMIT', 20),
    ],
];
