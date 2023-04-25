<?php

namespace App\Http\Controllers\Api\Ussd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\DeviceRepository;

use App\Criteria\CommercialIdCriteria;
use App\Events\DeviceBalanceReceived;

class UssdController extends Controller
{
    /**
     * @var DeviceRepository
     */
    private $repository;

    public function __construct(DeviceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function find(Request $request)
    {
        $this->repository->skipPresenter();

        $criteria = new CommercialIdCriteria($request->get('com_id'));
        $this->repository->pushCriteria($criteria);

        $device = $this->repository->first();

        if ( ! is_null($device)) {
            $op = $device->operator;
            $ret = array($op->ussd, $op->start, $op->sender);
            return implode(',', $ret);
        }

        return '0';
    }

    public function update(Request $request)
    {
        $this->repository->skipPresenter();

        $criteria = new CommercialIdCriteria($request->get('com_id'));
        $this->repository->pushCriteria($criteria);

        $device = $this->repository->first();

        if ( ! is_null($device)) {
            event(new DeviceBalanceReceived($device, $request->get('balance')));

            return '1';
        }

        return '0';
    }
}
