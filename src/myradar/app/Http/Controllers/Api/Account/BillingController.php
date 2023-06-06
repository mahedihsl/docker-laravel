<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Criteria\UserIdCriteria;
use App\Criteria\BillingMonthCriteria;
use App\Contract\Repositories\PaymentRepository;

class BillingController extends Controller
{
    private $repository;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function status(Request $request)
    {
        // TODO: remove always TRUE statement
        return response()->json();

        $user = $this->getApiUser();

        $today = Carbon::today();
        $previous = $today->copy()->subDays(7);

        $this->repository->pushCriteria(new UserIdCriteria($user->id));
        $this->repository->pushCriteria(new BillingMonthCriteria($previous));

        if ($this->repository->all()->count() > 0) {
            return response()->json();
        }

        return response()->error('Your monthly bill has not been paid. You can no longer use our services.');
    }
}
