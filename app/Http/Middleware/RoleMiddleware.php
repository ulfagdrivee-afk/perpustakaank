<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Pastikan user sudah login
        if (!$request->user()) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Unauthorized'
            ], 401);
        }

        // 2. Cek apakah level/role user ada di dalam daftar yang diizinkan
        if (!in_array($request->user()->level, $roles)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Forbidden: Anda tidak memiliki akses ke halaman ini.'
            ], 403);
        }

        return $next($request);
    }
}