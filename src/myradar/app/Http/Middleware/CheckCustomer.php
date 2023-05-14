<?php

namespace App\Http\Middleware;

use Closure;

class CheckCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $required)
    {
        $type = $request->user()->customer_type;
        if ($type != intval($required)) {
            session()->flash('msg', 'You are not authorized');
            session()->flash('type', '0');

            return redirect()->route('home');
        }

        return $next($request);
    }
}
