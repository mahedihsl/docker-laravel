<?php

namespace App\Service\Microservice;

class FuelMicroservice extends BaseService
{
  const SERVICE_NAME = 'fuel';

  public function __construct() {
    parent::__construct(self::SERVICE_NAME);
  }

  public function latest($device_id = null, $car_id = null)
  {
    return $this->get('/fuel/latest', compact('device_id', 'car_id'));
  }
  
  public function consume($com_id, $value)
  {
    return $this->post('/fuel/receive', compact('com_id', 'value'));
  }

  public function history($car_id, $type)
  {
    return $this->get('/fuel/history', compact('car_id', 'type'));
  }

  public function fetchAvarage($device_id, $from, $to, $page, $per_page, $type = 1)
  {
    return $this->get('/fuel/fetch-avarage', compact('device_id', 'from', 'to', 'page', 'per_page', 'type'));
  }

  public function storeAvarage($value, $device_id)
  {
    return $this->post('/fuel/store-avarage', compact('value', 'device_id'));
  }

  public function getRefuelEvents($car_id, $days)
  {
    return $this->get('/refuel/events', compact('car_id', 'days'));
  }

  public function fetchGroups()
  {
    return $this->get('/fuel/fetch-groups');
  }

  public function seedGroups()
  {
    return $this->post('/fuel/seed-groups');
  }
}
