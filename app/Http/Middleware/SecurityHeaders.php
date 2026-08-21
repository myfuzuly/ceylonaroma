<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        // Allow public pages to be cached by browsers (override Laravel's no-store default)
        if ($request->isMethod('GET') && !$request->routeIs('admin.*') && !$request->user()) {
            $response->headers->set('Cache-Control', 'public, max-age=120, must-revalidate');
        }
        $response->headers->set('Content-Security-Policy', implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline'",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
            "font-src 'self' https://fonts.gstatic.com",
            "img-src 'self' data: https:",
            "connect-src 'self'",
            "frame-src https://www.google.com",
            "form-action 'self' https://www.payhere.lk https://sandbox.payhere.lk",
            "frame-ancestors 'none'",
            "base-uri 'self'",
            "object-src 'none'",
        ]));

        return $response;
    }
}
