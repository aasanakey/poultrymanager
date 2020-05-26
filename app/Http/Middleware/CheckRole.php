<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
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
        $user = \auth()->user();
        if ($user->hasRole($role)) {
            return $next($request);
        }
        return response()->view('errors.401', [], 401);
    }
}