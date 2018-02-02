<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string|null              $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->error(
                    'Forbidden Access to this Application',
                    403,
                    'invalid token or token not provided',
                    false,
                    true
                );
            } else {
                return redirect()->guest('login');
            }
        }

        return $next($request);
    }
}
