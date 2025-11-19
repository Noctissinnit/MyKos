<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Accepts a single permission string (e.g. 'manage_users').
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (! auth()->check()) {
            abort(403, 'Akses ditolak');
        }

        $user = auth()->user();

        if ($user->hasPermission($permission)) {
            return $next($request);
        }

        abort(403, 'Akses ditolak');
    }
}
