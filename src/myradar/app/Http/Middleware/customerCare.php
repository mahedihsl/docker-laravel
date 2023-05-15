<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class customerCare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next,$type)
     {
       $user = Auth::user();
       $user_type = $user['type'];
       //$customer_type = $user['customer_type'];

       if($user_type!=$type)
         {
           return redirect('/home');

         }
         return $next($request);
     }
}
