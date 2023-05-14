<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Carbon\Carbon;
use App\Entities\Position;
use App\Entities\Device;
use App\Entities\CarStatusLog;
use App\Entities\Setting;
use App\Service\Facades\Package;
use App\Service\PackageService;
use App\Util\GasPriceFactor;
use App\Util\FuelPriceFactor;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class Car extends Eloquent implements Presentable
{
    use PresentableTrait;

    const TYPE_CAR = 1;
    const TYPE_MICRO = 2;
    const TYPE_BIKE = 3;
    const TYPE_BUS = 4;
    const TYPE_GENERATOR = 5;
    const TYPE_RMS = 6;
    const TYPE_BIWTA_VESSEL = 7;
    const TYPE_PRIVATE_VESSEL = 8;

    const CNG_TYPE_A = 1;
    const CNG_TYPE_B = 2;

    protected $guarded = [];
    protected $dates = [
        'reg_date',
        'tax_date',
        'fitness_date',
        'insurance_date',
    ];
    protected $casts = [
        'color' => 'integer',
        'type' => 'integer',
        'engine_cc' => 'integer',
        'fuel_type' => 'integer',
        'seat_count' => 'integer',
    ];

    public function getTypeAttribute($value)
    {
        return !$value ? self::TYPE_CAR : $value;
    }

    public function getTypeNameAttribute()
    {
        $types = [
            self::TYPE_CAR => 'Car',
            self::TYPE_MICRO => 'Micro',
            self::TYPE_BIKE => 'Bike',
            self::TYPE_BUS => 'Bus',
        ];

        return isset($types[$this->type]) ? $types[$this->type] : '--';
    }

    public function getNewServiceAttribute($value)
    {
        return !$value ? 0 : $value;
    }

    public function getBillAttribute($value)
    {
        try {
            if( ! $value) {
                return $this->package == PackageService::CAR_BASIC ? 400 : 500;
            }
            return intval($value);
        } catch (\Exception $e) {
            return 500;
        }
    }

    public function getMetaDataAttribute($value)
    {
        $default = [
            'value' => config('car.refuel.gas.factor'),
            'status' => false,
            'event_status' => false,
        ];
        $value = is_null($value) ? collect() : collect($value);

        $factor = $value->get('gas_factor', null);
        $value->put('gas_factor', GasPriceFactor::mutate($factor));

        $factor = $value->get('fuel_factor', null);
        $value->put('fuel_factor', FuelPriceFactor::mutate($factor));

        if ( ! $value->has('cng_type')) $value->put('cng_type', self::CNG_TYPE_A);
        if ( ! $value->has('fuel_group')) $value->put('fuel_group', null);

        return $value;
    }

    public function getCngTypeAttribute()
    {
        return $this->meta_data->get('cng_type', self::CNG_TYPE_A);
    }
    
    public function getFuelGroupAttribute()
    {
        return $this->meta_data->get('fuel_group', 'g1');
    }

    public function getServicesAttribute($value)
    {
        $ret = !$value ? Package::basicCar()['services'] : $value;
        if ($this->type == self::TYPE_BUS) {
            array_push($ret, PackageService::TRIP);
            $ret = array_diff($ret, [PackageService::GEOFENCE]);
            $ret = array_values($ret);
        }
        return $ret;
    }

    public function getPackageAttribute()
    {
        return Package::getPackageId($this->attributes['services']);
    }

    public function getStatusAttribute($value)
    {
        if (array_key_exists('status', $this->attributes)) {
            return intval($value);
        }
        return 1;
    }

    public function getSpeedLimitAttribute($value)
    {
        if ( ! $value) {
            return [
                'soft' => [
                    'value' => 60,
                    'flag' => true,
                ],
                'hard' => [
                    'value' => 80,
                    'flag' => true,
                ]
            ];
        }

        if ( ! array_key_exists('soft', $value)) {
            $value['soft'] = [
                'value' => 60,
                'flag' => true,
            ];
        }

        if ( ! array_key_exists('hard', $value)) {
            $value['hard'] = [
                'value' => 80,
                'flag' => true,
            ];
        }

        return $value;
    }

    public function getInputsAttribute($value)
    {
      if(!$value){
        return [];
      }
      return $value;
    }

    public function totalBill()
    {
        $billableMonths = $this->findBillableMonths();
        $billableMonths = $billableMonths->values();
        if(!$this->bill || !sizeof($billableMonths)) return 0;
        return $this->bill * sizeof($billableMonths) - $this->getExtraPayment();
    }

    public function totalDue()
    {
        $billableMonths = $this->findBillableMonths();

        foreach($this->payments as $payment){
          foreach ($payment->months as $month) {
            $billableMonths = $billableMonths->reject(function($value) use ($month){
              return ($month[0] + 1 == $value[0] && $month[1] == $value[1]);
            });
          }
        }

        $billableMonths = $billableMonths->values();
        if(!$this->bill || !sizeof($billableMonths)) return 0;
        return $this->bill * sizeof($billableMonths) - $this->getExtraPayment();
    }

    public function totalPaid()
    {
        return $this->payments->sum('amount');
    }

    public function totalWaive()
    {
        return $this->payments->sum('waive');
    }

    public function findBillableMonths()
    {
        $billStartsFrom = $this->created_at->addMonthsNoOverflow(1);
        $billStartsFrom->day = 1;

        // We need set current time at 11
        $presentDate = Carbon::now();
        $presentDate->day = 1;
        $presentDate->hour = 23;
        $presentDate->minute = 59;

        $billableMonths = collect();
        for($i = $billStartsFrom->copy(); $i->lte($presentDate); $i->addMonth())
        {
            $billableMonths->push([$i->month, $i->year]);
        }
        return $billableMonths;
    }

    public function getExtraPayment() //check if the user has given some extra money on his last payment
    {
      $lastPayment = $this->getLatestPayment();
      if(!is_null($lastPayment) && !is_null($lastPayment->extra)){
        return $lastPayment->extra;
      }

      return 0;
    }


    /**
     * get ids of users with whom this car is shared
     * @param  array|null   $value column value
     * @return array
     */
    public function getSharedWithAttribute($value)
    {
        return is_array($value) ? $value : [];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function device()
    {
        return $this->hasOne(Device::class);
    }

    public function driver()
    {
        return $this->hasOne(Driver::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function fences()
    {
        return $this->belongsToMany(Fence::class);
    }

    public function mileage()
    {
        return $this->hasMany(Mileage::class);
    }

    public function driving_hour()
    {
        return $this->hasMany(DrivingHour::class);
    }

    public function duty_hour()
    {
        return $this->hasMany(DutyHour::class);
    }

    public function car_status_log()
    {
        return $this->hasMany(CarStatusLog::class);
    }

    public function fuel_calibration()
    {
        return $this->hasMany(FuelCalibration::class);
    }

    public function gas_calibration()
    {
        return $this->hasMany(GasCalibration::class);
    }

    public function gas_refuel_input()
    {
        return $this->hasMany(GasRefuelInput::class);
    }

    public function refuel_feeds()
    {
        return $this->hasMany(RefuelFeed::class);
    }

    public function getLastPayment()
    {
        return $this->payments()->orderBy('paid_on', 'desc')->first();
    }

    public function getLatestPayment()
    {
      return $this->payments()->orderBy('created_at', 'desc')->first();
    }

    public function getMonthlyMileage()
    {
        $from = Carbon::now()->subMonth();
        $to = Carbon::now();
        return $this->mileage()
            ->where('when', '<', $to)
            ->where('when', '>', $from)
            ->get()
            ->sum(function ($item) {
                return $item->value;
            });
    }

    public function getMonthlyDrivingHour()
    {
        $from = Carbon::now()->subMonth();
        $to = Carbon::now();

        return $this->driving_hour()
            ->where('when', '<', $to)
            ->where('when', '>', $from)
            ->get()
            ->sum(function ($item) {
                // in seconds on database ;in hour during presentation;
                return sprintf('%0.2f', $item->value/(60*60));
            });
    }

	public function getLatestComplain()
	{
		return $this->complains()
			->orderBy('_id', 'desc')
			->limit(1)
			->get()
			->first();
	}

    public function activation()
    {
        return $this->hasOne(Activation::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function settings()
    {
      return $this->hasMany(Setting::class);
    }

    public function complains()
    {
      return $this->hasMany(Complain::class);
    }

    public function status_log()
    {
        return $this->morphMany(StatusLog::class, 'entity');
    }

}
