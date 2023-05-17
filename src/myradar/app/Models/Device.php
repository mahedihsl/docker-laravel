<?php

namespace App\Models;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

use App\Util\Balance;
class Device extends Eloquent
{
    protected $guarded = [];
    protected $casts = [
        'system_status' => 'integer',
        'device_status' => 'integer',
        'engine_status' => 'integer',
        'lock_status' => 'integer',
    ];

    protected $dates =[
        'last_seen',
        'is_alive_when',
        'lock_status_when',
        'last_pulse',
        'last_start',
        'live_track',
    ];

    public static $TYPE_ARDUINO = 1;
    public static $TYPE_RASBERRY = 2;
    public static $TYPE_ORANGE = 3;

    public static $GOOD_FREQ_RATIO = 0.7;
    public static $MEDIUM_FREQ_RATIO = 0.3;

    public static $ENGINE_CONTROL_LOCK = 'lock';
    public static $ENGINE_CONTROL_WARM = 'warm';

    public static $STATUS_OFFLINE = 0;
    public static $STATUS_ONLINE = 1;
    public static $STATUS_CUT_OFF = 2;

    public static $STATUS_UNLOCKED = 0;
    public static $STATUS_LOCKED = 1;

    public static $ENGINE_ON = 1;
    public static $ENGINE_OFF = 0;

    /**
     * @var Balance
     */
    private $balance;

    public function getLockStatusAttribute($value)
    {
        return is_null($value) ? self::$STATUS_UNLOCKED : $value;
    }

    public function getEngineControlMethod() {
        if (!array_key_exists('engine_control', $this->attributes)) {
            return self::$ENGINE_CONTROL_LOCK;
        }
        return $this->attributes['engine_control']; // possible values are: lock, warm
    }

    public function getEngineStatusAttribute($value)
    {
        return is_null($value) ? self::$ENGINE_OFF : $value;
    }

    public function getPanicStateAttribute($value)
    {
        return intval($value); // 0 or 1
    }

    public function getNsStateAttribute($value)
    {
        return intval($value); // 0 or 1
    }

	public function getResetCallsAttribute($value)
	{
		if (!$value) {
			return 0;
		}

		return intval($value);
	}

    public function getSysStatusLabelAttribute()
    {
        switch ($this->system_status) {
            case self::$STATUS_ONLINE:
                return 'ONLINE';
                break;
            case self::$STATUS_OFFLINE:
                return 'OFFLINE';
                break;
            case self::$STATUS_CUT_OFF:
                return 'CUT OFF';
                break;

            default:
                return '--';
                break;
        }
    }

    public function getDevStatusLabelAttribute()
    {
        switch ($this->device_status) {
            case self::$STATUS_ONLINE:
                return 'ONLINE';
                break;
            case self::$STATUS_OFFLINE:
                return 'OFFLINE';
                break;
            case self::$STATUS_CUT_OFF:
                return 'CUT OFF';
                break;

            default:
                return '--';
                break;
        }
    }

    public function getSysStatusColorAttribute()
    {
        return $this->getStatusColor($this->system_status);
    }

    public function getDevStatusColorAttribute()
    {
        return $this->getStatusColor($this->device_status);
    }

    public function getStatusColor($status)
    {
        switch ($status) {
            case self::$STATUS_ONLINE:
                return 'text-success';
                break;
            case self::$STATUS_OFFLINE:
                return 'text-muted';
                break;
            case self::$STATUS_CUT_OFF:
                return 'text-danger';
                break;

            default:
                return '';
                break;
        }
    }

    public function getBalanceAttribute($value)
    {
        if ( ! is_array($value)) {
            return null;
        }

        if ( ! isset($this->balance)) {
            $this->balance = new Balance($value);
        }

        return $this->balance;
    }

    public function getMeterAttribute($value)
    {
        if ( ! $value) {
            return collect([
                'fuel' => collect(),
                'gas' => collect(),
                'newGas' => collect(),
                'newFuel'=> collect(),
            ]);
        }

        $fuel    = isset($value['fuel']) ? $value['fuel'] : [];
        $gas     = isset($value['gas']) ? $value['gas'] : [];
        $newGas  = isset($value['new_gas']) ? $value['new_gas'] : [];
        $newFuel = isset($value['new_fuel']) ? $value['new_fuel'] : [];
        return collect([
            'fuel'    => collect($fuel),
            'gas'     => collect($gas),
            'newGas'  => collect($newGas),
            'newFuel' => collect($newFuel),
        ]);
    }

    public function setMeterAttribute($value)
    {
        $this->attributes['meter'] = [
            'fuel' => $value->get('fuel')->values()->toArray(),
            'gas' => $value->get('gas')->values()->toArray(),
            'new_gas' => $value->get('newGas')->values()->toArray(),
            'new_fuel'=> $value->get('newFuel')->values()->toArray(),
        ];
    }

    public function getMetaAttribute($value)
    {
        if ( ! $value) {
            return collect([
                'fence_out' => null,
                'fence_id' => null,
                'pos' => null,
                'mil_pos' => null,
                'gas_min' => config('car.meter.gas.min'),
                'prevGas' => null,
                'prevFuel'=> null,
            ]);
        }

        return collect([
            'fence_out' => isset($value['fence_out']) ? $value['fence_out'] : null,
            'fence_id'  => isset($value['fence_id']) ? $value['fence_id'] : null,
            'pos'       => isset($value['pos']) ? $value['pos'] : null,
            'mil_pos'   => isset($value['mil_pos']) ? $value['mil_pos'] : null,
            'gas_min'   => isset($value['gas_min']) ? $value['gas_min'] : config('car.meter.gas.min'),
            'prevGas'   => isset($value['prev_gas']) ? $value['prev_gas'] : null,
            'prevFuel'  => isset($value['prev_fuel']) ? $value['prev_fuel'] : null,
        ]);
    }

    public function getLastRechargeAttribute()
    {
        return $this->recharges()
            ->orderBy('recharged_at', 'desc')
                ->first();
    }

    public function getServiceStatus($service)
    {

        $time_range = 24 * 60;
        $ideal_count = floor($time_range / 5);
        $actual_count = $this->logs()->where('service_id', $service->sid)
            ->where('when', '>', Carbon::now()->subMinutes($time_range))
                ->count();

        $ratio = $actual_count / $ideal_count;
        if ($ratio >= self::$GOOD_FREQ_RATIO) {
            return Service::$STATUS_GOOD;
        } else if ($ratio >= self::$MEDIUM_FREQ_RATIO) {
            return Service::$STATUS_MEDIUM;
        } else {
            return Service::$STATUS_POOR;
        }
    }

    public function getLastPulseLabelAttribute()
    {
        return $this->last_pulse ? $this->last_pulse->diffForHumans() : 'Never';
    }

    public function getFuelMethodAttribute($value)
    {
        return ! $value ? 0 : intval($value);
    }

    public function getGasMethodAttribute($value)
    {
        return ! $value ? 0 : intval($value);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function powers()
    {
        return $this->hasMany(Power::class);
    }

    public function logs()
    {
        return $this->hasMany(ServiceLog::class);
    }

    public function recharges()
    {
        return $this->hasMany(Recharge::class);
    }

    public function healths()
    {
        return $this->hasMany(Health::class);
    }

    public function driving_hour()
    {
        return $this->hasMany(DrivingHour::class);
    }

    public function duty_hour()
    {
        return $this->hasMany(DutyHour::class);
    }

    public function mileage()
    {
        return $this->hasMany(Mileage::class);
    }

    public function fuel_histories()
    {
        return $this->hasMany(FuelHistory::class);
    }

    public function gas_histories()
    {
        return $this->hasMany(GasHistory::class);
    }

    public function daily_gas()
    {
        return $this->hasMany(DailyGas::class);
    }

    public function fuel_calibration()
    {
        return $this->hasMany(FuelCalibration::class);
    }

    public function daily_fuel()
    {
        return $this->hasMany(DailyFuel::class);
    }

    public function gas_calibration()
    {
        return $this->hasMany(GasCalibration::class);
    }

    public function refuel_feeds()
    {
        return $this->hasMany(RefuelFeed::class);
    }
}
