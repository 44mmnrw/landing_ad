<?php

namespace App\Http\Controllers;

use App\Models\CustomPage;
use Illuminate\Contracts\View\View;

class CustomPageController extends Controller
{
    public function show(string $slug): View
    {
        $page = CustomPage::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('custom-page', [
            'page' => $page,
        ]);
    }
}
