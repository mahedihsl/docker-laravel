<?php

namespace App\Service\Microservice;

class RMSUserMicroservice extends BaseService
{
  const SERVICE_NAME = 'rms-user';

  public function __construct()
  {
    parent::__construct(self::SERVICE_NAME);
  }

  public function filterSites($query)
  {
    return $this->get('/site/fetch', $query);
  }

  public function saveSite($data)
  {
    return $this->post('/site/save', $data);
  }

  public function updateSite($data)
  {
    return $this->post('/site/update', $data);
  }

  public function cacheSiteStatus($data)
  {
    return $this->post('/cache/site-status', $data);
  }

  public function statusCounts($query)
  {
    return $this->get('/site/status-counts', $query);
  }

  public function getSiteDigitalControl($query)
  {
    return $this->get('/site/digital-control', $query);
  }

  public function setSiteDigitalControl($data)
  {
    return $this->post('/site/digital-control', $data);
  }

  public function siteEvents($query)
  {
    return $this->get('/site/events', $query);
  }

  public function siteAlarms($query)
  {
    return $this->get('/site/alarms', $query);
  }

  public function networkEvents($query)
  {
    return $this->get('/network/events', $query);
  }

  public function filterNetworkEvents($query)
  {
    return $this->get('/network/filter-events', $query);
  }

  public function networkHealths($query)
  {
    return $this->get('/network/healths', $query);
  }

  public function loginUser($data)
  {
    return $this->post('/auth/login', $data);
  }

  public function refreshToken($data)
  {
    return $this->post('/auth/refresh', $data);
  }

  public function getUser($headers)
  {
    return $this->get('/auth/user', [], $headers);
  }

  public function logoutUser($data)
  {
    return $this->post('/auth/logout', $data);
  }

  public function startSession($data)
  {
    return $this->post('/session/start', $data);
  }

  public function saveSettings($data)
  {
    return $this->post('/settings/save', $data);
  }

  public function clearSecurityBreach($data)
  {
    return $this->post('/site/clear-security-breach', $data);
  }

  public function updateProfile($data)
  {
    return $this->post('/profile/update', $data);
  }

  public function changePassword($data)
  {
    return $this->post('/profile/change-password', $data);
  }

  public function unlockSite($data)
  {
    return $this->post('/site/unlock', $data);
  }
}
