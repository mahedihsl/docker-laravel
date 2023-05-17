<?php

namespace App\Models;


use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;
use Carbon\Carbon;

class User extends Eloquent implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, Presentable
{
    use Authenticatable, Authorizable, CanResetPassword,
        Notifiable, SoftDeletes, PresentableTrait;

    protected $connection = 'mongodb';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $collection = 'users';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = '_id';

    protected $dates = ['deleted_at', 'verification_code_expires', 'joined_at'];

    public static $TYPE_ADMIN = 1;
    public static $TYPE_AGENT = 2;
    public static $TYPE_OPERATION = 3;
    public static $TYPE_CUSTOMER = 4;
    public static $TYPE_GOVT = 5;
    public static $TYPE_CALIBRATION = 6;

    public static $CUSTOMER_PRIVATE = 1;
    public static $CUSTOMER_ENTERPRISE = 2;
    public static $CUSTOMER_PUBLIC = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'type' => 'integer',
        'customer_type' => 'integer',
    ];

    public function getImageUrlAttribute()
    {
        if ( ! is_null($this->image)) {
            return $this->image->url;
        }

        return \Storage::url('image/user-placeholder.jpg');
    }

    public function isEnabled()
    {
        return ! isset($this->enabled) || boolval($this->enabled);
    }

    public function getDeviceTokens()
    {
        $android = $this->user_logins()
                        ->where('device_type', 0)->get()
                        ->map(function($item) { return $item->device_token; })
                        ->values();

        $ios = $this->user_logins()
                        ->where('device_type', 1)->get()
                        ->map(function($item) { return $item->device_token; })
                        ->filter(function($item, $i) {
                            return strpos($item, '-') === FALSE;
                        })
                        ->values();

        return collect([
            'android' => $android,
            'ios' => $ios,
        ]);
    }

    public function getPlayerIds()
    {
        return $this->user_logins()
                ->where('device_type', 2)->get()
                ->map(function($item) { return $item->device_token; })
                ->values()
                ->toArray();
    }

    public function getSharedCarsAttribute($value)
    {
        return !$value ? [] : $value;
    }

    public function getSharedCars()
    {
        return Car::where('shared_with', 'all', [$this->id])->get();
    }

    public function isAdmin()
    {
        return $this->type == self::$TYPE_ADMIN;
    }

    public function isAgent()
    {
        return $this->type == self::$TYPE_AGENT;
    }

    public function isOperation()
    {
        return $this->type == self::$TYPE_OPERATION;
    }

    public function isCalibration()
    {
        return $this->type == self::$TYPE_CALIBRATION;
    }

    public function isCustomer()
    {
        return $this->type == self::$TYPE_CUSTOMER;
    }

    public function isSharedCar($id)
    {
      return in_array($id,$this->shared_cars);
    }

    public function getStatusAttribute()
    {
        if (array_key_exists('status', $this->attributes)) {
            return intval($this->attributes['status']);
        }
        return 1;
    }

    public function getTypeNameAttribute()
    {
        if ($this->isAdmin()) {
            return 'Admin';
        } elseif ($this->isAgent()) {
            return 'Customer Care';
        } elseif ($this->isOperation()) {
            return 'Int. & Operation';
        } elseif ($this->isCustomer()) {
            return 'Customer';
        }

        return 'Other';
    }

    public function getLatestActivity()
    {
        $records = Activity::where('user_id', $this->id)
                        ->where('when', '>=', Carbon::today()->subDays(6))
                        ->get();
        $data = [];
        for ($i=0; $i < 7; $i++) {
            $data[$i] = ['l' => 0, 'r' => 0];
            for ($j=0; $j < $records->count(); $j++) {
                if ($records[$j]->when->eq(Carbon::today()->subDays($i))) {
                    $data[$i] = [
                        'l' => $records[$j]->login,
                        'r' => $records[$j]->request,
                    ];
                    break;
                }
            }
        }
        return $data;
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function user_logins()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function promo_codes()
    {
        return $this->hasMany(PromoCode::class);
    }

    public function generateVerificationCode()
    {
        return substr(number_format(time() * rand(), 0, '', ''), 0, 6);
    }

    public function settings()
    {
        return $this->hasMany(Setting::class);
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function complains()
    {
      return $this->hasMany(Complain::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function status_log()
    {
        return $this->morphMany(StatusLog::class, 'entity');
    }

}
