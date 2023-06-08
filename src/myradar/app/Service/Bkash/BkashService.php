<?php

namespace App\Service\Bkash;

use Illuminate\Support\Facades\Redis;

class BkashService
{
  private $product;

  public function __construct($product) {
    $this->product = $product;
  }

  public function httpClient()
  {
    return new \GuzzleHttp\Client();
  }

  public function getAccessToken()
  {
    return Redis::command('GET', ['bkash:' . $this->product . ':access_token']);
  }
  
  public function getRefreshToken()
  {
    return Redis::command('GET', ['bkash:' . $this->product . ':refresh_token']);
  }
}
