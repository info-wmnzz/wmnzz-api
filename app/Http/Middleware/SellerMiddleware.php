<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class SellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
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

        if (! $user->isSeller()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Access denied. Seller only.',
            ], 403);
        }

        return $next($request);
    }
}
