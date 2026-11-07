<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $response->headers->add([
            'X-Frame-Options' => 'SAMEORIGIN', 'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'strict-origin-when-cross-origin', 'Permissions-Policy' => 'camera=(), microphone=(), geolocation=()',
        ]);
        return $response;
    }
}
