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

        if(!$user){
            return redirect()->back()->withErrors(['error' => 'You are not a myRADAR user.']);
        }

        $total_due_bill = $this->bkashPaymentService->totalDue($user->id, $this->paymentRepository);
        $cars_bill_details = $this->bkashPaymentService->carDueBillCheck($user->id, $this->paymentRepository)['cars_bill_details'];
    
        return view('bkash.checkout-url.amount')->with([
            'cars_bill_details' => $cars_bill_details,
            'total_due_bill' => $total_due_bill['total'],
            'user' => $user,
            'uId' => $uId
        ]);
    }
    
    public function payment(Request $request)
    {
        //$cars = $request->input('cars');
        //$selectedCarIndexs = $request->input('car_index');

        $user = $request->user;

        $language = $request->lang;

        $total_bill = $request->total_bill;

        $uId = $request->uId;

        // if(!$selectedCarIndexs){
        //     return redirect()->back()->withErrors(['error' => 'Please select a car']);
        // }

        //$total_pay_bill = 0;
        //$car_wise_bill = [];
        //$selectedCars = [];
        
        // foreach ($selectedCarIndexs as $selectedCarIndex) {

        //     if($request->input($selectedCarIndex) < 1){
        //         return redirect()->back()->withErrors(['error' => 'Minimum amount 1 TK']);
        //     } 
            
        //     array_push($selectedCars, $cars[$selectedCarIndex]);
        //     array_push($car_wise_bill, ['car_no' => $cars[$selectedCarIndex], 'bill' => $request->input($selectedCarIndex)]);

        //     $total_pay_bill +=  $request->input($selectedCarIndex);

        //   } 


        // if($language == 'en'){
        //     if($total_bill < 1){
        //         return redirect()->back()->withErrors(['error' => 'Amount must be minimum ৳ 1.']);
        //     }
        // }else{
        //     if($total_bill < 1){
        //         return redirect()->back()->withErrors(['error' => 'সর্বনিম্ন ১ টাকা দিন।']);
        //     }
        // }

        if ($total_bill < 1) {
           return redirect('/p/'.$uId);
        }
       
        return view('bkash.checkout-url.pay')->with([
            //'car_wise_bill' => json_encode($car_wise_bill),
            //'selected_cars' => $selectedCars,
            'language' => $language,
            'amount' => $total_bill,
            'user' => $user
        ]);
    }

    public function createPayment(Request $request)
    {
        $user = $request->user;
        $amount = $request->get('amount');
        //$car_wise_bill = $request->get('car_wise_bill');
      
        return $this->bkashCheckoutURLService->createPayment($user, $amount, $this->credential);
    }

    public function callback(Request $request, $uid)
    {
        $allRequest = $request->all();

        $paymentID = $allRequest['paymentID'];
        
        $data = $this->bkashCheckoutURLService->isPaymentIDExist($paymentID);

        if($data){
            return view('bkash.checkout-url.success');
        }

        if(isset($allRequest['status']) && $allRequest['status'] == 'success'){
            
            $response = $this->bkashCheckoutURLService->executePayment($paymentID, $this->credential);

            if(array_key_exists("message",$response)){
                // If Execute API Failed  
                sleep(1);
                $response = $this->bkashCheckoutURLService->queryPayment($paymentID, $this->credential);
            }

            if(array_key_exists("statusCode",$response) && $response['statusCode'] == '0000'){
                return view('bkash.checkout-url.success');
            }else{
                return view('bkash.checkout-url.fail')->with([
                    'message' => $response['statusMessage'],
                    'uid' => $uid,
                ]);
            }  

        } else{
            return view('bkash.checkout-url.fail')->with([
                'uid' => $uid,
            ]);       
        }

    }

    public function getRefund(Request $request)
    {
        return view('bkash.checkout-url.refund');
    }

    public function refundPayment(Request $request)
    {
        $paymentID = $request->get('paymentID');
        $trxID = $request->get('trxID');
        $amount = $request->get('amount');

        $response = $this->bkashCheckoutURLService->refundTransaction($paymentID, $trxID, $amount, $this->credential);

        if(isset($response['statusCode'])){
            return view('bkash.checkout-url.refund')->with([
                'response' => $response['statusMessage'],
            ]);
        }

        return view('bkash.checkout-url.refund')->with([
            'response' => "Refund Successfully Completed !!",
        ]);
    }        
    
    public function allBkashBill(Request $request){

        $params = $request->all();
        $transactions = $this->bkashCheckoutURLService->allBkashBill($params);

        return view('bkash.checkout-url.allBill')
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