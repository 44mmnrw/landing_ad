<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureAllowedTrackingSourceIp
{
    /**
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIps = config('tracking.internal.allowed_ips', []);
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
}
