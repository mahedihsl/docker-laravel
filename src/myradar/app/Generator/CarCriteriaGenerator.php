<?php

namespace App\Generator;

use Illuminate\Support\Collection;
use App\Criteria\CarRegNoCriteria;
use App\Criteria\CarUserNameCriteria;
use App\Criteria\CarUserPhoneCriteria;
use App\Criteria\RemainingMbCriteria;
use App\Criteria\CarBalanceValidityCriteria;

use Carbon\Carbon;

class CarCriteriaGenerator
{
    private $params = [
        'name' => CarUserNameCriteria::class,
        'phone' => CarUserPhoneCriteria::class,
        'reg' => CarRegNoCriteria::class,
        'remain' => RemainingMbCriteria::class,
        'valid' => CarBalanceValidityCriteria::class,
    ];

    private $numerics = ['remain'];
    private $dates = ['valid'];
    /**
     * @var Collection
     */
    private $data;

    function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function all()
    {
        $criteria = collect();
        foreach ($this->params as $key => $class) {
            if ($this->isValidInput($key)) {
                $criteria->push(new $class($this->getValue($key)));
            }
        }
        return $criteria;
    }

    public function getValue($key)
    {
        $value = $this->data->get($key);

        if (in_array($key, $this->numerics)) {
            $value = intval($value);
        }

        if (in_array($key, $this->dates)) {
            $value = Carbon::parse($value);
        }

        return $value;
    }

    public function isValidInput($key)
    {
        if ( ! $this->isNotEmpty($key) ) {
            return false;
        }

        if (in_array($key, $this->numerics)) {
            if ( ! $this->isNumeric($key)) {
                return false;
            }
        }

        if (in_array($key, $this->dates)) {
            try {
                Carbon::parse($this->data->get($key));
            } catch (Exception $e) {
                return false;
            }
        }

        return true;
    }

    private function isNotEmpty($key)
    {
        return boolval(strlen(trim($this->data->get($key, ''))));
    }

    private function isNumeric($key)
    {
        return is_numeric($this->data->get($key, ''));
    }

}
