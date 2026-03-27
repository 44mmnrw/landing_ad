<?php

use App\Http\Controllers\Api\InternalTrackingEventController;
use App\Http\Controllers\Api\PublicTrackingController;
use Illuminate\Support\Facades\Route;

Route::post('/internal/tracking/events', [InternalTrackingEventController::class, 'store'])
    ->middleware([
        'enforce.internal.tracking.https',
        'tracking.source.ip',
        'tracking.hmac',
        'throttle:internal-tracking',
    ]);

Route::post('/internal/tracking/events/revoke', [InternalTrackingEventController::class, 'revoke'])
    ->middleware([
        'enforce.internal.tracking.https',
        'tracking.source.ip',
        'tracking.hmac',
        'throttle:internal-tracking',
    ]);

Route::get('/public/tracking/{tracking_number}', [PublicTrackingController::class, 'show'])
    ->where('tracking_number', '^TRK-[A-Z2-9]{4}-[A-Z2-9]{4}$');
