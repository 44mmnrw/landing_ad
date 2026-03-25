<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnforceHttpsForInternalTracking
{
    /**
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requireHttps = (bool) config('tracking.internal.require_https', true);

        if ($requireHttps && ! $request->isSecure() && ! app()->environment('testing')) {
            Log::warning('tracking.internal.https_required', [
                'ip' => $request->ip(),
                'path' => $request->path(),
            ]);

            return response()->json([
                'message' => 'HTTPS is required.',
            ], 403);
        }

        return $next($request);
    }
}
