<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleCheckMiddleware
{
    public function handle(Request $request, Closure $next, ...$role)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // If the user is not authenticated, redirect or return error
            return response('Unauthorized.', 401);
        }

        $user = Auth::user();

        // Check if the user has any of the specified roles
        if (in_array($user->role, $role)) {
            // If the user has the required role, continue with the request
            return $next($request);
        }

        // If the user does not have the required role, redirect or return error
        return response('Forbidden', 403);
    }
}
