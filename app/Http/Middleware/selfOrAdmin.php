<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class selfOrAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('api')->check()) {
            abort(403);
        }

        if ($request->has('user_id') && $request->input('user_id') == Auth::user()->id) {
            return $next($request);
        }

        if (Auth('api')->user()->hasRole('admin') || Auth('api')->user()->hasRole('vrijwilliger')) {
            return $next($request);

        }

        abort(403);


    }
}
