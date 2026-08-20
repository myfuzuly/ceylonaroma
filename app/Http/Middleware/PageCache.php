<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PageCache
{
    private const TTL = 300; // 5 minutes
    private const CACHE_DIR = 'framework/cache/pages';

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only cache GET requests, 200 HTML responses, for guests with no query string
        if (
            $request->method() !== 'GET'
            || $request->user()
            || $request->getQueryString()
            || $response->getStatusCode() !== 200
            || !str_contains($response->headers->get('Content-Type', ''), 'text/html')
        ) {
            return $response;
        }

        $dir  = storage_path(self::CACHE_DIR);
        $file = $dir . '/' . md5($request->getRequestUri()) . '.html';

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($file, $response->getContent());

        return $response;
    }
}
