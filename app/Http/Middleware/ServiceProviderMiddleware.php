<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceProviderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         $user = auth('api')->user();


        if (! $user) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Unauthorized',
            ], 401);
        }

        // Load role if not loaded
        $user->loadMissing('role');

        if (! $user->isServiceProvider()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Access denied. Service Provider only.',
            ], 403);
        }

        return $next($request);
    }
}
