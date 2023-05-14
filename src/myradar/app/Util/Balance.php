<?php

namespace App\Util;

use Carbon\Carbon;

/**
 * Balance subdocumet class
 */
class Balance
{
    public $recharged_at;
    public $validity;
    public $volume;
    public $consumed;
    public $remained;

    function __construct($arr)
    {
        $this->recharged_at = Carbon::createFromTimestamp($arr['recharged_at']);
        $this->validity = Carbon::createFromTimestamp($arr['validity']);
        $this->volume = $arr['volume'];
        $this->consumed = $arr['consumed'];
        $this->remained = $arr['remained'];
    }
    
}
