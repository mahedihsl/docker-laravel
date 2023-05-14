<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Carbon\Carbon;
class Recharge extends Eloquent
{
    protected $guarded = [];
    public $dates = ['recharged_at', 'validity'];
    protected $casts = [
        'amount' => 'integer',
        'volume' => 'integer',
        'consumed' => 'integer',
        'remained' => 'integer',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

 }
