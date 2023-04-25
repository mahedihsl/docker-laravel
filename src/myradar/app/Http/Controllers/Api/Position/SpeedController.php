<?php

namespace App\Http\Controllers\Api\Position;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\DeviceRepository;

use App\Criteria\CommercialIdCriteria;
use App\Events\SpeedLimitCrossEvent;

class SpeedController extends Controller
{
    /**
     * @var DeviceRepository
     */
    private $repository;

    public function __construct(DeviceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function notify(Request $request)
    {
        $this->repository->skipPresenter();

        $criteria = new CommercialIdCriteria($request->get('com_id'));
        $this->repository->pushCriteria($criteria);

        $device = $this->repository->first();

        if ( ! is_null($device)) {
            $speed = intval($request->get('sp')); // current speed
            $limit = intval($request->get('lm')); // speed limit

            event(new SpeedLimitCrossEvent($device, $speed, $limit));

            return '1';
        }

        return '0';
    }
}
