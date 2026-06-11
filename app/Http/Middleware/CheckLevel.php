<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLevel
{
    public function handle(Request $request, Closure $next, ...$levels): Response
    {
        // Memeriksa apakah user memiliki level yang diizinkan
        if (in_array($request->user()->level, $levels)) {
            return $next($request);
        }

        return response()->json([
            'status' => 'Error',
            'message' => 'Anda tidak memiliki akses (Forbidden)'
        ], 403);
    }
}