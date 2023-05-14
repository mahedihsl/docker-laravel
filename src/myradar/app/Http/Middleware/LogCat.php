<?php

namespace App\Http\Middleware;

use Closure;

class LogCat
{
	private $DEV_ID_POOL = [
		"5aeeb88d3264d3508a2f7d9a",
		"5c503cb246bcba7e8135f690",
	];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
	{
		return $next($request);
	}

	public function terminate($request, $response)
	{
		
	}
}
