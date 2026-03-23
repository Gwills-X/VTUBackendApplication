<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next)
{
    // Check if user is authenticated AND is an admin
    // Assuming your column is 'is_admin' (boolean) or 'role' === 'admin'
    if ($request->user() && $request->user()->is_admin) {
        return $next($request);
    }

    // Return 403 if they are a valid user but NOT an admin
    return response()->json(['message' => 'Access Denied: Admins Only'], 403);
}
}
