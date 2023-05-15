<?php

namespace App\Http\Middleware;

use Closure;

class DebugMiddleware
{
    private static $arr = ['93991', '28540'];

    public function __construct()
    {
        
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // return redirect()->route('home');
        //$flag = in_array($request->get('com_id'), self::$arr);
        return $next($request);
    }

    public function terminate($request, $response)
    {
        //$flag = in_array($request->get('com_id'), self::$arr);
    }

}
