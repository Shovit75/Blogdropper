<?php

namespace App\Http\Middleware;

use Closure;

class AddSecurityHeaders
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Add security headers
        // $response->header('X-XSS-Protection', '1; mode=block');
        // $response->header('Content-Security-Policy', "script-src 'self'");
        // $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        // $response->header('X-Content-Type-Options', 'nosniff');
        // $response->header('X-Frame-Options', 'DENY');
        return $response;
    }
}
