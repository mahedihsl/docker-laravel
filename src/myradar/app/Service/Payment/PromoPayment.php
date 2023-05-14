<?php

namespace App\Service\Payment;

use Illuminate\Support\Collection;
use App\Entities\User;
use App\Entities\Car;
use App\Entities\PromoScheme;
use App\Entities\Payment;
use App\Entities\PromoCode;
use Carbon\Carbon;
use App\Service\NotificationService;
use App\Jobs\PushNotificationJob;
use App\Events\PaymentReceived;
use Illuminate\Support\Facades\Log;

class PromoPayment
{

    function __construct()
    {

    }

    public function autoPay(PromoCode $promo)
    {
      $carList = $promo->user->cars;
      $minMonth = array(12,2500);
      $minCar = new Car;
      foreach ($carList as $key => $car) {
        $ret=$this->getMaxPaidMonth($car);

        if($ret['month'][1] < $minMonth[1]   || $ret['month'][1] == $minMonth[1]  && $ret['month'][0] < $minMonth[0]){
          $minMonth = $ret['month'];
          $minCar   = $ret['car'];
        }
      }

      $this->payBill($promo, $minMonth, $minCar);
    }

    public function payBill($promo, $minMonth, $minCar)
    {
      $monthCount  = $promo->promo_scheme->free_month;
      $payableMonths = $this->getPayableMonths($minMonth, $monthCount);

      $payment = Payment::create([
          'amount'  => $minCar->bill*$monthCount,
          'months'  => $payableMonths,
          'car_id'  => $minCar->id,
          'user_id' => $promo->user_id,
          'paid_on' => Carbon::now(),
          'auto'    => 1,
      ]);
      
      event(new PaymentReceived($payment));
    }

    public function getPayableMonths($minMonth, $monthCount)
    {
      $payable = [];
      while($monthCount--){
        if($minMonth[0] == 11){
          $minMonth[0] = -1;
          $minMonth[1]++;
        }

        $ar=[++$minMonth[0], $minMonth[1]];
        array_push($payable, $ar);
      }

      return $payable;
    }

    public function getMaxPaidMonth(Car $car)
    {
      $max = [0,0];
      $maxCar = new Car;
      if($car->payments->isEmpty()){
        $max[0] = $car->created_at->format('n')-1; //month is 1 indexed
        $max[1] = $car->created_at->format('Y');

        return ['month' => $max, 'car' => $car];
      }

      foreach ($car->payments as $k => $payment) {
        $temp = $payment->months[sizeof($payment->months)-1];
        if($temp[1] > $max[1] || $temp[1] == $max[1] && $temp[0] > $max[0]){
          $max = $temp;
          $maxCar = $car;
        }
      }
      return ['month' => $max, 'car' => $car];
    }


}
