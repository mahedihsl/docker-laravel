<?php

namespace App\Util;

class Test
{

    function __construct()
    {
        // code...
    }

    public function test($device)
    {
        return $device->engine_status;
    }
}
