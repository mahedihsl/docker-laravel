<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class bkash extends Eloquent
{
    protected $guarded = [];

    protected $table = 'bkash_transactions';
}
