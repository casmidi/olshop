<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddDiagnosticHeaders
{
    /**
     * Add lightweight headers to help identify which app instance produced a response.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $route = $request->route();

        $response->headers->set('X-Debug-App', (string) config('app.name', 'Laravel'));
        $response->headers->set('X-Debug-Node', gethostname() ?: php_uname('n'));
        $response->headers->set('X-Debug-Host', $request->getHost());
        $response->headers->set('X-Debug-Scheme', $request->getScheme());
        $response->headers->set('X-Debug-Route-Name', $route?->getName() ?: 'unmatched');
        $response->headers->set('X-Debug-Route-Uri', $route?->uri() ?: 'unmatched');

        return $response;
    }
}
