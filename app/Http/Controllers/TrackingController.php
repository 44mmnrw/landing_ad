<?php

namespace App\Http\Controllers;

use App\Models\TrackingEvent;
use App\Models\TrackingRequest;
use App\Support\TrackingEventCatalog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackingController extends Controller
{
    public function index(Request $request): View
    {
        $trackingNumber = $request->query('tracking_number');
        $legacyCode = $request->query('code');

        $request->validate([
            'tracking_number' => ['nullable', 'string', 'max:20'],
            'code' => ['nullable', 'string', 'max:20'],
        ]);

        $searchedWithCode = $trackingNumber !== null || $legacyCode !== null;
        $rawSearchCode = $trackingNumber ?? $legacyCode ?? '';
        $searchCode = mb_strtoupper(trim((string) $rawSearchCode));

        $events = collect();
        $latestEvent = null;

        if ($searchCode !== '') {
            $events = TrackingEvent::query()
                ->where('tracking_number', $searchCode)
                ->orderByDesc('occurred_at')
                ->orderByDesc('id')
                ->limit(20)
                ->get();

            $latestEvent = $events->first();
        }

        if ($searchedWithCode) {
            TrackingRequest::query()->create([
                'search_code' => $searchCode !== '' ? $searchCode : null,
                'is_found' => (bool) $latestEvent,
                'source_page' => $request->fullUrl(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return view('tracking', [
            'latestEvent' => $latestEvent,
            'events' => $events,
            'statusLabels' => TrackingEventCatalog::statusLabels(),
            'eventLabels' => TrackingEventCatalog::eventLabels(),
            'searchCode' => $searchCode,
            'searchedWithCode' => $searchedWithCode,
        ]);
    }
}
