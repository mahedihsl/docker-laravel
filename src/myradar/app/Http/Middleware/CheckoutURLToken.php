<?php

namespace App\Http\Middleware;

use App\Service\Bkash\BkashCheckoutURLService;
use App\Util\BkashCredential;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CheckoutURLToken
{
    private $credential;
    private $BkashCheckoutURLService;

    public function __construct()
    {
        $this->BkashCheckoutURLService = new BkashCheckoutURLService();
        $this->credential = new BkashCredential(config('bkash.tokenized.production'));
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $accessTokenExpireTime = 50 * 60; // 50 minutes
        $refreshTokenExpireTime = 60 * 60 * 24 * 26; // 26 days
        $accessToken = Redis::command('GET', ['bkash:checkout_url:access_token']);
        if (!$accessToken) {
            $refreshToken = Redis::command('GET', ['bkash:checkout_url:refresh_token']);
            if (!$refreshToken) {
                $arr = $this->BkashCheckoutURLService->grantToken($this->credential);
                $accessToken = $arr['id_token'];
                $refreshToken = $arr['refresh_token'];
                
                Redis::command('SET', ['bkash:checkout_url:access_token', $accessToken, 'EX', strval($accessTokenExpireTime)]);
                Redis::command('SET', ['bkash:checkout_url:refresh_token', $refreshToken, 'EX', strval($refreshTokenExpireTime)]);
            } else {
                $arr = $this->BkashCheckoutURLService->refreshToken($refreshToken, $this->credential);
                $accessToken = $arr['id_token'];
                
                Redis::command('SET', ['bkash:checkout_url:access_token', $accessToken, 'EX', strval($accessTokenExpireTime)]);
            }
        }
        return $next($request);
    }
}
