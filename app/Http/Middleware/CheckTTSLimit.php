<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CheckTTSLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            return $next($request);
        }

        if (!$request->isMethod('post') || !$request->filled('text')) {
            return $next($request);
        }

        $ttsCount = (int) Cookie::get('ttsvoiceover', 0);
        $ttsCount++;
        Cookie::queue(Cookie::make('ttsvoiceover', $ttsCount, 60 * 24));
        if ($ttsCount > 5) {
            if ($request->ajax()) { 
                return response()->json([
                    'error'   => true,
                    'message' => 'Free limit reached! Please Sign up to continue.',
                ], 403);
            }
        }
    
        return $next($request);
    }
}
