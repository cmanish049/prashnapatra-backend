<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-Key');

        if (! $apiKey || ! $this->isValidKey($apiKey)) {
            return response()->json([
                'status' => 'error',
                'error' => true,
                'message' => 'Invalid or missing API key',
            ], 401);
        }

        return $next($request);
    }

    private function isValidKey(string $key): bool
    {
        return hash_equals((string) config('prasnapatra.api_key'), $key);
    }
}
