<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiKey;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey) {
            return response()->json(['error' => 'API Key is required'], 401);
        }

        $keyRecord = ApiKey::where('key', $apiKey)->first();

        if (!$keyRecord || $keyRecord->quota <= 0) {
            return response()->json(['error' => 'Invalid or expired API Key'], 403);
        }

        return $next($request);
    }
}
