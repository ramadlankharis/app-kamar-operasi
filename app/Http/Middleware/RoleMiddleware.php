<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized access.');
        }

        // Menggunakan hasAnyRole dari Spatie
        if (!auth()->user()->hasAnyRole($roles)) {
            abort(403, 'Unauthorized access.');
        }
        return $next($request);
    }
}
