<?php

namespace App\Service\Refuel;

use Illuminate\Support\Collection;

abstract class DetectRefuel
{
    protected $magnitude;

    function __construct()
    {
        $this->magnitude = null;
    }

    public function magnitude() {
        return $this->magnitude;
    }

    abstract public function check(Collection $samples);

    abstract public function sampleCount();

}
