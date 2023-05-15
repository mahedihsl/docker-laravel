<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\SmsService;
use Illuminate\Support\Collection;
use App\Contract\Repositories\PaymentRepository;
use App\Criteria\WithinDatesCriteria;
use App\Criteria\UserIdCriteria;
use App\Criteria\GroupByCriteria;
use App\Entities\User;
use App\Entities\Car;
use App\Entities\Payment;
use Carbon\Carbon;

class BkashPaymentController extends Controller
{
    /**
     * @var PaymentRepository
     */
    private $repository;

    public function __construct()
    {

    }

    public function save(Request $request)
    {
      $userName   = $request->get('username');
      $password   = $request->get('password');
      $refNo      = $request->get('ref_no');
      $billAmount = $request->get('bill_amount');
      $trxId      = $request->get('bKash_trxid');
      $paytime    = $request->get('Paytime');

      if(is_null($userName) || is_null($password) ||
        is_null($refNo) ||is_null($billAmount) ||
        is_null($trxId) ||is_null($userName) ||
        is_null($paytime) ) {

        return response()->json([
            "Error_code" => "402",
            "Error_msg" => "Mandatory Field missing",
            "total_amount" => $billAmount,
            "trxId" => null
        ]);
      }

      $user       = User::where('ref_no', $refNo)->first();

      if(is_null($user)){
        return response()->json([ "Error_code" => "403", "Error_msg" => "Data Mismatch", "total_amount" => $billAmount, "trxId" => null ]);
      }

      $cars       = $user->cars;


      $minInfo    = $this->getMinInfo($cars);
      $minMonth   = $minInfo['minMonth'];
      $minCar     = $minInfo['minCar'];

      return $this->payBill($billAmount, $minMonth, $minCar, $trxId);
    }

    public function getMinInfo(Collection $carList)
    {

      $minMonth = array(12,2500);
      $minCar = new Car;
      foreach ($carList as $key => $car) {
        $ret=$this->getMaxPaidMonth($car);

        if($ret['month'][1] < $minMonth[1]   || $ret['month'][1] == $minMonth[1]  && $ret['month'][0] < $minMonth[0]){
          $minMonth = $ret['month'];
          $minCar   = $ret['car'];
        }
      }

      return ['minMonth' => $minMonth, 'minCar' => $minCar];

    }

    public function payBill($amount, $minMonth, $minCar, $trxId)
    {
      $latestPayment  = $minCar->getLatestPayment();
      $prevExtraMoney = 0;
      if(!is_null($latestPayment)){
        $prevExtraMoney = $latestPayment->extra;
      }
      $amount       += $prevExtraMoney;

      if($amount < $minCar->bill){
        return response()->json([ "Error_code" => "407", "Error_msg" => "Minimum amount not paid", "total_amount" => $amount, "trxId" => null]);
      }

      $monthCount  = intval($amount / $minCar->bill);
      $extraMoney  = intval($amount % $minCar->bill);
      $payableMonths = $this->getPayableMonths($minMonth, $monthCount);

      $payment = Payment::create([
          'amount'  => $amount - $prevExtraMoney,
          'months'  => $payableMonths,
          'car_id'  => $minCar->id,
          'user_id' => $minCar->user->id,
          'paid_on' => Carbon::now(),
          'extra'   => $extraMoney,
          'waive'   => 0,
          'bkash'   => 1,
          'trx_id'  => $trxId,
      ]);

      //event(new PaymentReceived($payment));

      return response()->json([ "Error_code" => "200", "Error_msg" => "Success", "total_amount" => $amount - $prevExtraMoney, "trxId" => null]);
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

    public function query(Request $request)
    {
        $refNo = $request->get('ref_no');

        $user = User::where('ref_no', $refNo)->first();
        if (is_null($user)) {
            return response()->json([
                'code' => '403',
                'msg' => 'Data Mismatch',
                'name' => null,
                'amount' => null,
            ]);
        }

        $due = 0;
        foreach ($user->cars as $key => $car) {
            $act = $car->activation;
            if ( ! is_null($act)) {
                $due += $act->totalBill() - $act->totalPaid() - $act->totalWaive();
            }
        }

        return response()->json([
            'code' => '200',
            'msg' => 'Success',
            'name' => $user->name,
            'amount' => max(0, $due),
        ]);


    }


}
