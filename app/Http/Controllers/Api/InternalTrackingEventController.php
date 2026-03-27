<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RevokeTrackingEventRequest;
use App\Http\Requests\StoreTrackingEventRequest;
use App\Models\TrackingEvent;
use App\Support\TrackingEventCatalog;
use Carbon\CarbonImmutable;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class InternalTrackingEventController extends Controller
{
    public function store(StoreTrackingEventRequest $request)
    {
        $payload = $request->validated();

        if (TrackingEvent::query()->where('event_uid', $payload['event_uid'])->exists()) {
            return response()->json([
                'ok' => true,
                'duplicate' => true,
            ]);
        }

        $occurredAt = CarbonImmutable::parse($payload['occurred_at'])->utc();
        $mappedStatus = TrackingEventCatalog::statusFromEventType($payload['event_type']);

        if ($mappedStatus === null) {
            Log::warning('tracking.internal.unknown_event_type', [
                'event_type' => $payload['event_type'],
                'event_uid' => $payload['event_uid'],
            ]);
        }

        $effectiveStatus = $mappedStatus ?? $payload['status'];

        if ($mappedStatus !== null && $mappedStatus !== $payload['status']) {
            Log::notice('tracking.internal.status_overridden_by_event_type', [
                'event_uid' => $payload['event_uid'],
                'event_type' => $payload['event_type'],
                'received_status' => $payload['status'],
                'effective_status' => $effectiveStatus,
            ]);
        }

        try {
            TrackingEvent::query()->create([
                'event_uid' => $payload['event_uid'],
                'tracking_number' => $payload['tracking_number'],
                'event_type' => $payload['event_type'],
                'status' => $effectiveStatus,
                'occurred_at' => $occurredAt,
                'latitude' => $payload['latitude'] ?? null,
                'longitude' => $payload['longitude'] ?? null,
                'notes' => $payload['notes'] ?? null,
                'source_system' => $payload['source_system'],
                'received_at' => now()->utc(),
            ]);
        } catch (QueryException $exception) {
            if (TrackingEvent::query()->where('event_uid', $payload['event_uid'])->exists()) {
                return response()->json([
                    'ok' => true,
                    'duplicate' => true,
                ]);
            }

            throw $exception;
        }

        return response()->json([
            'ok' => true,
            'duplicate' => false,
        ]);
    }

    public function revoke(RevokeTrackingEventRequest $request)
    {
        $payload = $request->validated();

        $eventUid = trim((string) ($payload['event_uid'] ?? ''));
        if ($eventUid === '' && isset($payload['event_id']) && is_numeric($payload['event_id'])) {
            $eventUid = 'trip_event_'.(int) $payload['event_id'];
        }

        if ($eventUid === '') {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'event_uid' => ['The event_uid field is required.'],
                ],
            ], 422);
        }

        $deleted = TrackingEvent::query()
            ->where('event_uid', $eventUid)
            ->delete();

        return response()->json([
            'ok' => true,
            'event_uid' => $eventUid,
            'state' => $deleted > 0 ? 'revoked' : 'already_revoked_or_missing',
        ]);
    }
}
