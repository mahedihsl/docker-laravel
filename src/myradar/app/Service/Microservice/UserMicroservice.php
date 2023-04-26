<?php

namespace App\Service\Microservice;

class UserMicroservice extends BaseService
{
    const SERVICE_NAME = 'user';

    public function __construct()
    {
        parent::__construct(self::SERVICE_NAME);
    }

    public function getAuthUser($api_token)
    {
        return $this->get('/auth/api-user-v1', compact('api_token'));
    }

    public function disableByCar($reg_no)
    {
        return $this->post('/account/disable/by-car', compact('reg_no'));
    }

    public function toggleStatus($user_id, $actor_id)
    {
        return $this->post('/account/toggle/status', compact('user_id', 'actor_id'));
    }

    public function statusHistory($user_id)
    {
        return $this->get('/account/status/history', compact('user_id'));
    }

    public function registerSession($data)
    {
        return $this->post('/session/save', $data);
    }

    public function removeSessionsOfUser($data)
    {
        return $this->post('/session/remove', $data);
    }

    public function removeSessionById($session_id)
    {
        return $this->post('/session/remove-by-id', compact('session_id'));
    }

    public function login($data)
    {
        return $this->post('/auth/login', $data);
    }

    public function token($user_id)
    {
        return $this->post('/auth/token', compact('user_id'));
    }

    public function refresh($refresh_token)
    {
        return $this->post('/auth/refresh', compact('refresh_token'));
    }

    public function profile($token)
    {
        $headers = ['authorization' => $token];
        return $this->post('/auth/profile', [], $headers);
    }

    public function forceLogout($session_id)
    {
        return $this->post('/session/force-logout', compact('session_id'));
    }

    public function getSessionList($user_id)
    {
        return $this->get('/session/list', compact('user_id'));
    }

    public function logPasswordChange($user_id)
    {
        return $this->post('/session/password-changed', compact('user_id'));
    }

    public function scanUnderengagedUsers()
    {
        return $this->post('/engage/sms-pack1-enable');
    }

    public function testMileagePush($user_id)
    {
        return $this->get('/test/mileage-push', compact('user_id'));
    }

    public function createAccount($data)
    {
        return $this->post('/account/create', $data);
    }

    public function onAccountCreated($data)
    {
        return $this->post('/account/on-create', $data);
    }

    public function filterAccounts($query)
    {
        return $this->get('/account/filter', $query);
    }

    public function test()
    {
        return $this->get('/test', ['user' => 'palatok']);
    }
}
