<?php

namespace App\Http\Middleware;

use Closure;

class BkashPayment
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
        $userName = $request->get('username');
        $passWord = $request->get('password');
        // $amount   = $request->get('bill_amount', '0');

        $expectedUsername = config('bkash.credential.username');
        $expectedPassword = config('bkash.credential.password');

        if($userName != $expectedUsername || $passWord != $expectedPassword){
          return response()->json([ "Error_code" => "401", "Error_msg" => "Authentication failed"]);
          //, "total_amount" => $amount, "trxId" => null
        }

        return $next($request);
    }
}
