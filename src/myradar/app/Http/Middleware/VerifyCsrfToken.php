<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/*',
        '*/api/',
        'latlng/receive',
        'toggleEngine',
        'services/api/update',
        'api/getUserDevice',
        'api/mobile/getUserLocation',
        'CheckDeviceAlive',
        '/login',
        '/logout',
        '/message/save',
        'customers/sendCredential/api',
        'service/api/get_service_diagnosis',
        'send/single/notice',
        '/test/*',
        '/test/excel-import',
        '/test/concox/lock',
        '/test/concox/unlock',
        '/emergency/restore',
        '/emergency/restore2',
        '/emergency/restore3',
        '/emergency/patch',
        '/test/fuel-avarage',
        '/online-payment/*',
        '/enroll/save',
    ];
}
