<?php

namespace App\Util;

class FuelPriceFactor
{

    function __construct()
    {
        // code...
    }

    public static function getFactor($magnitude, $factors) {
        $last = null;
        $len = sizeof($factors);

        for ($i=0; $i < $len; $i++) {
            if ($magnitude <= $factors[$i]['value']) {
                if (is_null($last)) {
                    return $factors[$i]['factor'];
                }

                $frac = ($magnitude - $last['value']) / ($factors[$i]['value'] - $last['value']);
                return $last['factor'] + (($factors[$i]['factor'] - $last['factor']) * $frac);
            }
            $last = $factors[$i];
        }

        return $factors[$len - 1]['factor'];
    }

    public static function getTuneFactor($peakval, $factors) {
        $last = null;
        if(is_null($factors) || sizeof($factors['data']) <= 1 || ! $factors['status']){
            return 1;
        }

        $factors = $factors['data'];
        $len = sizeof($factors);

        for ($i=0; $i < $len; $i++) {
            if ($peakval <= $factors[$i]['value']) {
                if (is_null($last)) {
                    return $factors[$i]['factor'];
                }

                $frac = ($peakval - $last['value']) / ($factors[$i]['value'] - $last['value']);
                return $last['factor'] + (($factors[$i]['factor'] - $last['factor']) * $frac);
            }
            $last = $factors[$i];
        }

        return $factors[$len - 1]['factor'];
    }

    public static function mutate($value) {
        if (is_null($value)) {
            return self::default();
        }
        if(!isset($value['event_status'])){ //old pricefactors don't have event_status
           $value['event_status'] = FALSE;
        }

        if (array_key_exists('value', $value)) { // old price factor check
            return self::convert($value);
        }

        return $value;
    }

    public static function default() {
        $default = [
            'value' => 100,
            'factor' => config('car.refuelByFiltering.fuel.factor'),
        ];

        return [
            'data' => [$default],
            'status' => FALSE,
            'event_status' => FALSE,
        ];
    }

    /**
     * Converts old price factor(single factor design) value to
     * new price factor(multi factor design) format
     * @param  array $value  old factor value+status
     * @return array         new factor array
     */
    public static function convert($value) {
        $ret = self::default();
        $ret['data'][0]['factor'] = $value['value'];
        $ret['status'] = $value['status'];
        $ret['event_status'] = $value['event_status'];
        return $ret;
    }

    /**
     * Returs an array from json string
     * @param  string $json json string
     * @return array        deserialized array
     */
    public static function deserialize($json) {
        $ret = collect(json_decode($json, TRUE));
        $ret = $ret->sortBy('value');
        return $ret->values()->toArray();
    }
}
