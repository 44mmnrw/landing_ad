<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackingController extends Controller
{
    public function index(Request $request): View
    {
        $request->validate([
            'code' => ['nullable', 'string', 'max:50'],
        ]);

        $searchCode = mb_strtoupper(trim((string) $request->query('code', '')));

        $shipment = null;

        if ($searchCode !== '') {
            $shipment = Shipment::query()
                ->with(['statuses' => fn ($query) => $query->orderBy('sort_order')])
                ->where('code', $searchCode)
                ->first();
        }

        if (! $shipment) {
            $shipment = Shipment::query()
                ->with(['statuses' => fn ($query) => $query->orderBy('sort_order')])
                ->orderBy('code')
                ->first();

            if ($searchCode === '' && $shipment) {
                $searchCode = $shipment->code;
            }
        }

        return view('tracking', [
            'shipment' => $shipment,
            'searchCode' => $searchCode,
            'searchedWithCode' => $request->query('code') !== null,
        ]);
    }
}