<?php

namespace App\Service\Microservice;

class RMSBatteryMicroservice extends BaseService
{
  const SERVICE_NAME = 'rms-battery';

  public function __construct()
  {
    parent::__construct(self::SERVICE_NAME);
  }

  public function voltageHistory($query)
  {
    return $this->get('/voltage/history', $query);
  }

  public function voltageProfile($query)
  {
    return $this->get('/voltage/profile', $query);
  }

  public function healthHistory($query)
  {
    return $this->get('/health/history', $query);
  }

  public function criticalSites($query)
  {
    return $this->get('/analytics/critical-sites', $query);
  }

  public function getEvents($query)
  {
    return $this->get('/event/fetch', $query);
  }
  
  public function getEnergyConsumption($query)
  {
    return $this->get('/energy/consumption', $query);
  }
}
