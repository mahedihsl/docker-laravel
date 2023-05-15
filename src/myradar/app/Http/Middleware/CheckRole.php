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
     * @param  integer  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $type = $request->user()->type;
        if ( ! ($type == 1 || $type == intval($role))) {
            session()->flash('msg', 'You are not authorized');
            session()->flash('type', '0');

            return redirect()->route('home');
        }

        return $next($request);
    }
}
