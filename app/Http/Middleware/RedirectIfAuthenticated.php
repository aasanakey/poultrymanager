<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // if (Auth::guard($guard)->check()) {
        //     return redirect('/home');
        // }
        switch ($guard) {
            case 'managers':
                if (Auth::guard($guard)->check()) {
                    return redirect('/dashboard');
                }
                break;
            
            default:
                # code...
                break;
        }

        return $next($request);
    }
}
