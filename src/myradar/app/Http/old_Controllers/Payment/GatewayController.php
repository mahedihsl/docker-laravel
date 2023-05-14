<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentInitRequest;
use App\Service\PaymentService;
use App\Util\PaymentParams;
use \Exception;
use Illuminate\Http\Request;

class GatewayController extends Controller
{
    use PaymentService;

    public function __construct()
    {

    }

    public function show(PaymentInitRequest $request)
    {
        $amount = $request->getAmount();
        $user = $request->getApiUser();

        if (is_null($user)) {
            throw new Exception('User is not authenticated');
        }

        $paymentParams = new PaymentParams();
        $paymentParams->setAmount($amount)
            ->setTransactionId($request->getTransactionId())
            ->setUser($user)
            ->setProduct('Bill of Jan 2022', 'Monthly Bill', 'Subscription')
            ->setIntent(PaymentParams::MONTHLY_BILL_INTENT, 1);

        try {
            $this->payViaHostedService($paymentParams->getParams());
        } catch (Exception $e) {
            return 'Error' . $e->getMessage();
        }
    }

    public function success(Request $request)
    {
        return view('payment.success');
    }

    public function fail(Request $request)
    {
        return view('payment.fail');
    }

    public function cancel()
    {
        return view('payment.cancel');
    }
}
