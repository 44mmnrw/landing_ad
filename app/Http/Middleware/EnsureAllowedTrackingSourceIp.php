<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class EnsureAllowedTrackingSourceIp
{
    /**
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIps = $this->resolveAllowedIps();
        $clientIp = $request->ip();

        if (! is_array($allowedIps) || $allowedIps === []) {
            Log::warning('tracking.internal.ip_allowlist_not_configured');

            return response()->json([
                'message' => 'IP allowlist is not configured.',
            ], 403);
        }

        if (! in_array($clientIp, $allowedIps, true)) {
            Log::warning('tracking.internal.ip_rejected', [
                'ip' => $clientIp,
                'path' => $request->path(),
            ]);

            return response()->json([
                'message' => 'Forbidden.',
            ], 403);
        }

        return $next($request);
    }

    /**
     * @return array<int, string>
     */
    private function resolveAllowedIps(): array
    {
        $fromConfig = config('tracking.internal.allowed_ips', []);
        $fallbackIps = is_array($fromConfig)
            ? array_values(array_filter(array_map('trim', $fromConfig)))
            : [];

        if (app()->environment('testing')) {
            return $this->readAllowedIpsFromStorage($fallbackIps);
        }

        return Cache::remember('tracking_internal_allowed_ips', 60, function () use ($fallbackIps): array {
            return $this->readAllowedIpsFromStorage($fallbackIps);
        });
    }

    /**
     * @param  array<int, string>  $fallbackIps
     * @return array<int, string>
     */
    private function readAllowedIpsFromStorage(array $fallbackIps): array
    {
        if (! Schema::hasTable('site_settings')) {
            return $fallbackIps;
        }

        $raw = (string) (SiteSetting::query()
            ->where('key', 'tracking_internal_allowed_ips')
            ->value('value') ?? '');

        if ($raw === '') {
            return $fallbackIps;
        }

        $parts = preg_split('/[\s,;]+/', $raw) ?: [];

        return array_values(array_filter(array_map('trim', $parts)));
    }
}
