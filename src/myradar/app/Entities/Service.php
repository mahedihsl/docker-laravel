<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Presenter\ServicePresenter;
use App\Contract\Presenter\ModelPresenter;

class Service extends Eloquent
{
    public static $TYPE_DIGITAL = 1;
    public static $TYPE_ANALOG = 2;

    public static $STATUS_GOOD = 1;
    public static $STATUS_MEDIUM = 2;
    public static $STATUS_POOR = 3;


    public static $DEFAULT_FREQ = 5;


    protected $guarded = [];
    protected $appends = ['type_text'];
    protected $casts = [
        'interval' => 'float',
    ];

  //  protected $primaryKey = 'sid';
    public function transform($type = null)
    {
        $presenter = new ServicePresenter();
        return $presenter->transform($this);
    }

    public function getTypeTextAttribute()
    {
        return $this->type == self::$TYPE_DIGITAL ? 'Digital' : 'Analog';
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }


    public function logs()
    {
        return $this->hasMany(ServiceLog::class);
    }
}
