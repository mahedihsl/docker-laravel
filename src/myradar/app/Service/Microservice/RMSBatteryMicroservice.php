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

  public function exportVoltage($query)
  {
    return $this->get('/voltage/aggregate', $query);
  }

  public function exportCurrent($query)
  {
    return $this->get('/current/aggregate', $query);
  }

  public function currentTrend($query)
  {
    return $this->get('/current/trend', $query);
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

  public function siteAvailability($query)
  {
    return $this->get('/analytics/availability', $query);
  }

  public function getEvents($query)
  {
    return $this->get('/event/fetch', $query);
  }

  public function getEnergyConsumption($query)
  {
    return $this->get('/energy/consumption', $query);
  }

  public function getPowerTrend($query)
  {
    return $this->get('/power/trend', $query);
  }

  public function getPowerHistory($query)
  {
    return $this->get('/power/history', $query);
  }
}
