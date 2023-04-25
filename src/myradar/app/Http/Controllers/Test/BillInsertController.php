<?php

namespace App\Http\Controllers\Test;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\Car;
use App\Entities\Device;
use App\Service\DirectionService;
use Carbon\Carbon;
use Excel;

class BillInsertController extends Controller
{


  public function test(Request $requst)
  {
    $car = Car::where('reg_no', '32-4945')->first();
    // return $car->findBillableMonths();

    // $creationDate = Carbon::createFromDate(2020, 8, 1);
    $creationDate = $car->created_at;
    // $creationDate = $creationDate->addMonth();

    $presentDate = Carbon::now();
    $presentDate->day = 1;
    $presentDate->hour = 23;
    $presentDate->minute = 59;

    $billableMonths = collect();
    for($i = $creationDate->copy(); $i->lte($presentDate); $i->addMonth())
    {
        $billableMonths->push([$i->month, $i->year]);
    }
    
    return [
      'creation' => $creationDate,
      'today' => $presentDate,
      'months' => $billableMonths,
    ];
  }
}
