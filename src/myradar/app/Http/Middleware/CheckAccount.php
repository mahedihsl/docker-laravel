<?php

namespace App\Http\Middleware;

use Closure;

class CheckAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( ! $request->user()->isEnabled()) {
            return response()->error('Your account is suspended');
        }

        return $next($request);
    }
}
