<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('vrijwilliger'))) {
            return $next($request);
        }

        if (Auth::guard('api')->check() && (Auth::guard('api')->user()->hasRole('admin')
                || Auth::guard('api')->user()->hasRole('vrijwilliger'))) {
            return $next($request);
        }

        return redirect()->route('home')->with(['message' => 'niet ingelogd als beheerder of vrijwilliger']);
    }
}
