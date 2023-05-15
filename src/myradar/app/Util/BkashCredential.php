<?php

namespace App\Util;

class BkashCredential
{
  public $baseUrl;
  public $appKey;
  public $appSecret;
  public $username;
  public $password;

  public function __construct($arr)
  {
    $this->baseUrl = $arr['baseUrl'];
    $this->appKey = $arr['appKey'];
    $this->appSecret = $arr['appSecret'];
    $this->username = $arr['username'];
    $this->password = $arr['password'];
  }

  public function getURL($path)
  {
    return $this->baseUrl . $path;
  }

  public function getAuthHeaders()
  {
    return [
      'Content-Type' => 'application/json',
      'Accept' => 'application/json',
      'username' => $this->username,
      'password' => $this->password,
    ];
  }

  public function getAccessHeaders($accessToken)
  {
    return [
      'Content-Type' => 'application/json',
      'Accept' => 'application/json',
      'Authorization' => $accessToken,
      'X-App-Key' => $this->appKey,
    ];
  }
}
