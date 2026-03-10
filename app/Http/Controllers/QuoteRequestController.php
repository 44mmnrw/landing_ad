<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuoteRequestController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'route' => ['required', 'string', 'max:255'],
            'cargo_type' => ['required', 'string', 'max:255'],
            'comment' => ['nullable', 'string', 'max:2000'],
            'consent' => ['accepted'],
            'source_page' => ['nullable', 'string', 'max:255'],
        ]);

        QuoteRequest::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'route' => $validated['route'],
            'cargo_type' => $validated['cargo_type'],
            'comment' => $validated['comment'] ?? null,
            'consent' => true,
            'source_page' => $validated['source_page'] ?? null,
            'status' => 'new',
        ]);

        return back()->with('quote_success', 'Спасибо! Заявка отправлена, мы свяжемся с вами в ближайшее время.');
    }
}