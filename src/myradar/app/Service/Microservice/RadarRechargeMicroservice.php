<?php

namespace App\Service\Microservice;

class RadarRechargeMicroservice extends BaseService
{
  const SERVICE_NAME = 'radar-recharge';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }
  
  public function signup($data)
  {
    return $this->post('/auth/signup', $data);
  }
  
  public function test($data, $headers)
  {
    return $this->post('/auth/test', $data, $headers);
  }

  public function validate($data, $headers)
  {
    return $this->post('/dpdc/validate', $data, $headers);
  }
  
  public function recharge($data, $headers)
  {
    return $this->post('/dpdc/recharge', $data, $headers);
  }
  
  public function confirm($data, $headers)
  {
    return $this->post('/dpdc/confirm', $data, $headers);
  }
}
