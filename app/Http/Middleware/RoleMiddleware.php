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
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Pastikan user sudah login dan rolenya sesuai
        if (auth()->check() && auth()->user()->role === $role) {
            return $next($request); // lanjut ke controller
        }

        // Jika role tidak sesuai, tampilkan error 403
        abort(403, 'Kamu tidak punya akses.');
    }
}
