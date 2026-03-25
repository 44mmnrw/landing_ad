<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class VerifyTrackingRequestSignature
{
    /**
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $secret = (string) config('tracking.internal.hmac_secret', '');
        $timestamp = (string) $request->header('X-Timestamp', '');
        $providedSignature = (string) $request->header('X-Signature', '');

        if ($secret === '') {
            Log::error('tracking.internal.hmac_secret_missing');

            return response()->json([
                'message' => 'Internal auth is not configured.',
            ], 500);
        }

        if ($timestamp === '' || $providedSignature === '') {
            Log::warning('tracking.internal.hmac_headers_missing', [
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);
        }

        if (! ctype_digit($timestamp)) {
            Log::warning('tracking.internal.hmac_timestamp_invalid', [
                'ip' => $request->ip(),
                'timestamp' => $timestamp,
            ]);

            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);
        }

        $clockSkew = (int) config('tracking.internal.clock_skew_seconds', 300);
        $age = abs(now()->timestamp - (int) $timestamp);

        if ($age > $clockSkew) {
            Log::warning('tracking.internal.hmac_timestamp_expired', [
                'ip' => $request->ip(),
                'timestamp' => $timestamp,
                'age' => $age,
            ]);

            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);
        }

        $rawBody = $request->getContent();
        $expectedSignature = hash_hmac('sha256', $timestamp.$rawBody, $secret);

        if (! hash_equals($expectedSignature, $providedSignature)) {
            Log::warning('tracking.internal.hmac_signature_invalid', [
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);
        }

        return $next($request);
    }
}
