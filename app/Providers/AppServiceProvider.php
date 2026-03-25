<?php

namespace App\Providers;

use App\Models\LandingSection;
use App\Models\SiteSetting;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('internal-tracking', function (Request $request): Limit {
            $perMinute = (int) config('tracking.internal.rate_limit_per_minute', 120);

            return Limit::perMinute($perMinute)->by($request->ip());
        });

        if (! Schema::hasTable('site_settings') || ! Schema::hasTable('landing_sections') || ! Schema::hasTable('landing_section_items')) {
            View::share('siteSettings', []);
            View::share('landingSections', collect());

            return;
        }

        $siteSettings = SiteSetting::query()
            ->where('is_public', true)
            ->pluck('value', 'key')
            ->toArray();

        $landingSections = LandingSection::query()
            ->where('is_active', true)
            ->with(['items' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get()
            ->keyBy('code');

        View::share('siteSettings', $siteSettings);
        View::share('landingSections', $landingSections);
    }
}
