<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Extract JWT from Authorization header
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        try {
            // Get secret key from environment
            $secretKey = env('JWT_SECRET_KEY');

            if (!$secretKey) {
                return response()->json(['error' => 'JWT secret key not configured'], 500);
            }

            // Decode and validate JWT
            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));

            // Add user information to request attributes
            $request->attributes->add([
                'userId' => $decoded->userId,
                'username' => $decoded->username,
                'role' => $decoded->role,
            ]);

            // Also add as headers for easier access in controllers
            $request->headers->set('X-User-Id', $decoded->userId);
            $request->headers->set('X-Username', $decoded->username);
            $request->headers->set('X-User-Role', $decoded->role);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid or expired token', 'message' => $e->getMessage()], 401);
        }

        return $next($request);
    }
}
