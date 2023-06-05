<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Carbon\Carbon;
use App\Entities\Setting;
use App\Service\Facades\Package;

class BkashPGWTransaction extends Eloquent 
{

    protected $guarded = [];

    protected $table = 'bkash_transactions';
   
}
