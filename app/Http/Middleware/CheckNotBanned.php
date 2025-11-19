<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckNotBanned
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->banned) {
            auth()->logout();
            abort(403, 'Akun Anda diblokir. Hubungi administrator.');
        }

        return $next($request);
    }
}
