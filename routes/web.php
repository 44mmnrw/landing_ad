<?php

use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\CustomPageController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::post('/quote-requests', [QuoteRequestController::class, 'store'])->name('quote-requests.store');

Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking');

Route::get('/pages/{slug}', [CustomPageController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-]+')
    ->name('custom-pages.show');
