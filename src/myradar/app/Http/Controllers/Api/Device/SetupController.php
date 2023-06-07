<?php

namespace App\Http\Controllers\Api\Device;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Contract\Repositories\DeviceRepository;
use App\Criteria\CommercialIdCriteria;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SetupController extends Controller
{
    /**
     * @var repositorysitory
     */
    private $repository;

    public function __construct(DeviceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function init(Request $request)
    {
        $this->repository->skipPresenter();

        $criteria = new CommercialIdCriteria($request->get('com_id'));
        $this->repository->pushCriteria($criteria);

        $device = $this->repository->first();

        if ( ! is_null($device)) {
            return implode("\n", array(
                intval($device->lock_status),
                time(),
                Str::random(40),
                $this->getUssd($device),
                $this->getFences($device),
            ));
        }

        return '0';
    }

    public function initv2(Request $request)
    {
        $this->repository->skipPresenter();

        $criteria = new CommercialIdCriteria($request->get('com_id'));
        $this->repository->pushCriteria($criteria);

        $device = $this->repository->first();

        if ( ! is_null($device)) {
            $body = implode("\n", array(
                intval($device->lock_status),
                time(),
                Str::random(40),
                $this->speed($device),
                $this->getFences($device),
            ));
            if ($request->get('test', '0') == '1') {
                return response($body)->header('Content-Type', 'text/strings');
            }
            return response($body);
        }
        return '0';
    }

    public function initv3(Request $request)
    {
        $this->repository->skipPresenter();

        $criteria = new CommercialIdCriteria($request->get('com_id'));
        $this->repository->pushCriteria($criteria);

        $device = $this->repository->first();

        if ( ! is_null($device)) {
            $fence = $device->car->fences()->first();
            $text = '';
            if ( ! is_null($fence)) {
                $val = array($fence->id, $fence->lat, $fence->lng, $fence->radius);
                $text = implode(",", $val);
            }

            return implode("\n", array(
                intval($device->lock_status),
                $this->speed($device),
                Str::random(40),
                time(),
                $text,
            ));
        }
        return '0';
    }

	public function initv4(Request $request)
    {
        $this->repository->skipPresenter();

        $criteria = new CommercialIdCriteria($request->get('com_id'));
        $this->repository->pushCriteria($criteria);

        $device = $this->repository->first();

        if ( ! is_null($device)) {
            $voice = is_null($device->car) ? 0 : intval($device->car->voice_service);
            $voice = strval($voice);
            $body = implode("\n", array(
                intval($device->lock_status),
                time(),
                Str::random(40),
                $this->speed($device),
				$voice,
                $this->getFences($device),
            ));
            if ($request->get('test', '0') == '1') {
                return response($body)->header('Content-Type', 'text/strings');
            }
            return response($body);
        }
        return '0';
    }

    public function speed($device)
    {
        $car = $device->car;
        if (is_null($car)) {
            return '';
        }
        return "{$car->speed_limit['soft']['value']},{$car->speed_limit['hard']['value']}";
    }

    public function status(Request $request)
    {
        $criteria = new CommercialIdCriteria($request->get('com_id'));

        $device = $this->repository
            ->skipPresenter()
                ->pushCriteria($criteria)
                    ->first();

        if ( ! is_null($device)) {
            return strval($device->lock_status);
        }

        return '0';
    }

    public function midnight(Request $request)
    {
        $now = Carbon::now();
        $tomorrow = Carbon::tomorrow();
        $tomorrow->setTime(0, 0, 0);
        return strval($tomorrow->timestamp - $now->timestamp);
    }

    public function getUssd($device)
    {
        return '4545';
        $op = $device->operator;
        return implode(',', array($op->ussd, $op->start, $op->sender));
    }

    public function getFences($device)
    {
        if (is_null($device->car)) return '';

        $fences = $device->car->fences->reduce(function($carry, $item) {
            $val = array($item->id, $item->lat, $item->lng, $item->radius);
            if (strlen($carry)) {
                $carry .= "\n";
            }
            return $carry . implode(',', $val);
        }, '');

        return $fences;
    }

}
