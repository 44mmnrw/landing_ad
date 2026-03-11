<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\TrackingRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackingController extends Controller
{
    public function index(Request $request): View
    {
        $request->validate([
            'code' => ['nullable', 'string', 'max:50'],
        ]);

        $searchedWithCode = $request->query('code') !== null;
        $searchCode = mb_strtoupper(trim((string) $request->query('code', '')));

        $shipment = null;

        if ($searchCode !== '') {
            $shipment = Shipment::query()
                ->with(['statuses' => fn ($query) => $query->orderBy('sort_order')])
                ->where('code', $searchCode)
                ->first();
        }

        if (! $searchedWithCode && ! $shipment) {
            $shipment = Shipment::query()
                ->with(['statuses' => fn ($query) => $query->orderBy('sort_order')])
                ->orderBy('code')
                ->first();

            if ($shipment) {
                $searchCode = $shipment->code;
            }
        }

        if ($searchedWithCode) {
            TrackingRequest::query()->create([
                'shipment_id' => $shipment?->id,
                'search_code' => $searchCode !== '' ? $searchCode : null,
                'is_found' => (bool) $shipment,
                'source_page' => $request->fullUrl(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return view('tracking', [
            'shipment' => $shipment,
            'searchCode' => $searchCode,
            'searchedWithCode' => $searchedWithCode,
        ]);
    }
}