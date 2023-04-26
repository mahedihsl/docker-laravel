<?php

namespace App\Service\Microservice;

class POIMicroservice extends BaseService
{
  const SERVICE_NAME = 'poi';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function nearest($lat, $lng)
  {
    return $this->get('/api/nearest', compact('lat', 'lng'));
  }
}
