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
        $request->validate([
            'code' => ['nullable', 'string', 'max:20'],
        ]);

        $searchedWithCode = $request->query('code') !== null;
        $searchCode = mb_strtoupper(trim((string) $request->query('code', '')));

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
