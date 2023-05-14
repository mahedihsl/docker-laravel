<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Util\BkashCredential;
use App\Contract\Repositories\PaymentRepository;
use App\Service\Bkash\BkashCheckoutURLService;
use App\Service\Bkash\BkashPaymentService;
use Illuminate\Support\Facades\Redis;
use URL;
use Excel;
use Illuminate\Support\Str;
use Auth;
use App\Entities\User;

class BkashCheckoutURLController extends Controller
{  /**
    * @var PaymentRepository
    */
    private $repository;
    private $credential;
    private $bkashCheckoutURLService;
    private $bkashPaymentService;

    public function __construct(PaymentRepository $repository)
    {
        $this->paymentRepository = $repository;
        $this->bkashCheckoutURLService = new BkashCheckoutURLService();
        $this->bkashPaymentService = new BkashPaymentService();
        $this->credential = new BkashCredential(config('bkash.tokenized.production'));
    }

    public function amount(Request $request, $uId)
    {   
        $user = User::where('uid', intval($uId))->first();
        $total_due_bill = $this->bkashPaymentService->totalDue($user->id, $this->paymentRepository);
        $cars_bill_details = $this->bkashPaymentService->carDueBillCheck($user->id, $this->paymentRepository)['cars_bill_details'];
        //dd($cars_bill_details);
        return view('bkash.chcekout-url.amount')->with([
            'cars_bill_details' => $cars_bill_details,
            'total_due_bill' => $total_due_bill['total'],
            'user' => $user
        ]);
    }
    
    public function payment(Request $request)
    {
        $cars = $request->input('cars');
        $selectedCarIndexs = $request->input('car_index');

        $user = $request->user;

        if(!$selectedCarIndexs){
            return redirect()->back()->withErrors(['error' => 'Please select a car']);
        }

        $total_pay_bill = 0;
        $car_wise_bill = [];
        $selectedCars = [];
        
        foreach ($selectedCarIndexs as $selectedCarIndex) {

            if($request->input($selectedCarIndex) < 1){
                return redirect()->back()->withErrors(['error' => 'Minimum amount 1 TK']);
            } 
            
            array_push($selectedCars, $cars[$selectedCarIndex]);
            array_push($car_wise_bill, ['car_no' => $cars[$selectedCarIndex], 'bill' => $request->input($selectedCarIndex)]);

            $total_pay_bill +=  $request->input($selectedCarIndex);

          } 
          
        return view('bkash.chcekout-url.pay')->with([
            'car_wise_bill' => json_encode($car_wise_bill),
            'selected_cars' => $selectedCars,
            'amount' => $total_pay_bill,
            'user' => $user
        ]);
    }

    public function createPayment(Request $request)
    {
        $user = $request->user;
        $amount = $request->get('amount');
        $car_wise_bill = $request->get('car_wise_bill');
      
        return $this->bkashCheckoutURLService->createPayment($user, $amount, json_decode($car_wise_bill,true), $this->credential);
    }

    public function callback(Request $request)
    {
        $allRequest = $request->all();

        if(isset($allRequest['status']) && $allRequest['status'] == 'success'){
            
            $response = $this->bkashCheckoutURLService->executePayment($allRequest['paymentID'], $this->credential);

            if(array_key_exists("message",$response)){
                // If Execute API Failed  
                sleep(1);
                $response = $this->bkashCheckoutURLService->queryPayment($allRequest['paymentID'], $this->credential);
            }

            if(array_key_exists("statusCode",$response) && $response['statusCode'] == '0000'){
                return view('bkash.chcekout-url.success');
            }else{
                return view('bkash.chcekout-url.fail')->with([
                    'message' => $response['statusMessage'],
                ]);
            }  

        }else{
            return view('bkash.chcekout-url.fail')->with([
                'message' => $allRequest['status'],
            ]);       
        }

    }

    public function getRefund(Request $request)
    {
        return view('bkash.chcekout-url.refund');
    }

    public function refundPayment(Request $request)
    {
        $paymentID = $request->get('paymentID');
        $trxID = $request->get('trxID');
        $amount = $request->get('amount');

        $response = $this->bkashCheckoutURLService->refundTransaction($paymentID, $trxID, $amount, $this->credential);

        return view('bkash.chcekout-url.refund')->with([
            'response' => "Refund Successful",
        ]);
    }        
    
    public function allBkashBill(Request $request){

        $params = $request->all();
        $transactions = $this->bkashCheckoutURLService->allBkashBill($params);

        return view('bkash.chcekout-url.allBill')
            ->with(compact('transactions', 'params'));
    }

    private function export($data)
    {
        Excel::create('BillingRecords', function ($excel) use ($data) {
            $excel->sheet('data', function ($sheet) use ($data) {
                $data->transform(function ($car) {
                    $transformer = new CarExportTransformer();
                    return $transformer->transform($car);
                });

                $sheet->fromArray($data->toArray(), null, 'A1', false, true);

                $sheet->row(1, function ($row) {
                    $row->BalancesetFontWeight('bold');
                });
            });
        })->download('xlsx');
    }
}