<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InternalApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $expectedKey = env('INTERNAL_API_KEY');

        if (!$expectedKey) {
            return $next($request);
        }

        $providedKey = $request->header('X-Internal-Key');

        if (!$providedKey || !hash_equals($expectedKey, $providedKey)) {
            return response()->json([
                'error' => 'Forbidden',
                'message' => 'Direct access to this service is not allowed. Use the API gateway.'
            ], 403);
        }

        return $next($request);
    }
}
