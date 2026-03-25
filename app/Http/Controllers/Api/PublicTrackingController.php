<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrackingEvent;
use Illuminate\Http\JsonResponse;

class PublicTrackingController extends Controller
{
    public function show(string $trackingNumber): JsonResponse
    {
        $latestEvent = TrackingEvent::query()
            ->where('tracking_number', $trackingNumber)
            ->orderByDesc('occurred_at')
            ->orderByDesc('id')
            ->first();

        if (! $latestEvent) {
            return response()->json([
                'message' => 'Tracking number not found.',
            ], 404);
        }

        $eventsLimit = (int) config('tracking.public.events_limit', 20);

        $events = TrackingEvent::query()
            ->where('tracking_number', $trackingNumber)
            ->orderByDesc('occurred_at')
            ->limit($eventsLimit)
            ->get([
                'tracking_number',
                'event_type',
                'status',
                'occurred_at',
                'latitude',
                'longitude',
                'notes',
            ]);

        return response()->json([
            'tracking_number' => $latestEvent->tracking_number,
            'current_status' => $latestEvent->status,
            'last_event_at' => optional($latestEvent->occurred_at)?->toISOString(),
            'last_location' => [
                'latitude' => $latestEvent->latitude,
                'longitude' => $latestEvent->longitude,
            ],
            'events' => $events,
        ]);
    }
}
