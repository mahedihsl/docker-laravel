<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\PaymentRepository;

class BillingController extends Controller
{
    private $repository;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function entry(Request $request)
    {
        $records = $this->repository->scopeQuery(function ($query) {
            return $query->orderBy('paid_on', 'desc');
        })
        ->with(['user', 'car'])
        ->paginate(30);

        return view('billing.entry')->with([
            'items' => $records,
        ]);
    }
}
