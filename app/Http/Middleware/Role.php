<?php

namespace App\Http\Middleware;

use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (auth()->user()->type !== $role) {
            // If user type is not of input user type
            // Show forbidden error
            abort(403);
        }

        return $next($request);
    }
}
