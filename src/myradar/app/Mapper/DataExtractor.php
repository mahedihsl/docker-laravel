<?php

namespace App\Mapper;

use Carbon\Carbon;
use Illuminate\Support\Collection;

trait DataExtractor
{
    public function getRawData(Collection $data, $key, $default)
    {
        return $data->has($key) ? $data->get($key) : $default;
    }

    function getInteger(Collection $data, $key)
    {
        $val = $this->getRawData($data, $key, null);
        return is_null($val) ? $val : intval($val);
    }

    function getFloat(Collection $data, $key)
    {
        $val = $this->getRawData($data, $key, null);
        return is_null($val) ? $val : floatval($val);
    }

    function getBoolean(Collection $data, $key)
    {
        $val = $this->getRawData($data, $key, null);
        return is_null($val) ? $val : boolval($val);
    }

    function getString(Collection $data, $key)
    {
        $val = $this->getRawData($data, $key, '');
        return is_null($val) ? '' : $val;
    }

    function getDate(Collection $data, $key, $format)
    {
        $val = $this->getRawData($data, $key, null);
        return (is_null($val) || !strlen($val)) ? null : Carbon::createFromFormat($format, $val);
    }
}
