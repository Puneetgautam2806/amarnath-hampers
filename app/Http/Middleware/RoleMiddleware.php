<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Ensure user has at least one of the allowed roles.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->isDeveloper()) {
            return $next($request);
        }

        if (empty($roles) || in_array($user->usertype, $roles, true)) {
            return $next($request);
        }

        abort(403, 'You do not have permission to access this module.');
    }
}
