<?php

namespace App\Http\Controllers\Payment;

use App\Service\Bkash\CheckoutService;
use App\Http\Controllers\Controller;
use App\Util\BkashCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CheckoutIFrameController extends Controller
{
    private $credential;
    private $checkoutService;

    public function __construct()
    {
        $this->checkoutService = new CheckoutService();
        $this->credential = new BkashCredential(config('bkash.checkout.production'));
    }

    public function grant(Request $request)
    {
        return $this->checkoutService->grantToken($this->credential);
    }

    public function pay(Request $request)
    {
        $amount = $request->get('amount');
        $reg_no = $request->get('reg_no');
        return view('bkash.checkout-iframe.pay')->with([
            'amount' => $amount,
            'reg_no' => $reg_no,
        ]);
    }

    public function refresh(Request $request)
    {
        $refreshToken = Redis::command('GET', ['bkash:checkout_iframe:refresh_token']);
        return $this->checkoutService->refreshToken($refreshToken, $this->credential);
    }

    public function create(Request $request)
    {
        $amount = $request->get('amount');
        return $this->checkoutService->createPayment($amount, $this->credential);
    }

    public function execute(Request $request)
    {
        $paymentID = $request->get('paymentID');
        return $this->checkoutService->executePayment($paymentID, $this->credential);
    }

    public function query(Request $request)
    {
        $paymentID = $request->get('paymentID');
        return $this->checkoutService->queryPayment($paymentID, $this->credential);
    }

    public function search(Request $request)
    {
        $trxID = $request->get('trxID');
        return $this->checkoutService->searchTransaction($trxID, $this->credential);
    }

    public function refund(Request $request)
    {
        $trxID = $request->get('trxID');
        $paymentID = $request->get('paymentID');
        $amount = $request->get('amount');

        return $this->checkoutService->refundTransaction($paymentID, $trxID, $amount, $this->credential);
    }

    public function refundStatus(Request $request)
    {
        $trxID = $request->get('trxID');
        $paymentID = $request->get('paymentID');

        return $this->checkoutService->refundStatus($paymentID, $trxID, $this->credential);
    }

    public function amount(Request $request)
    {
        return view('bkash.checkout-iframe.amount');
    }
    
    public function success(Request $request)
    {
        return view('bkash.checkout-iframe.success');
    }
    
    public function fail(Request $request)
    {
        $message = $request->get('message', 'Payment Failed, Please try again');
        return view('bkash.checkout-iframe.fail')->with([
            'message' => $message
        ]);
    }
}
