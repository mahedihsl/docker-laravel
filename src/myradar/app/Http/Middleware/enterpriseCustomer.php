<?php

namespace App\Http\Middleware;
use Auth;
use App\Entities\User;
use Closure;

class enterpriseCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next,$type,$c_type)
     {
       $user = Auth::user();
       $user_type = $user['type'];
       $customer_type = $user['customer_type'];

       if($user_type!=$type && $customer_type!=$c_type)
         {
           return redirect('/home');

         }
         return $next($request);
     }
}
