<?php

namespace App\Http\Controllers\Api\Poi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\PoiRepository;
use App\Criteria\LastUpdatedCriteria;
use App\Service\Microservice\POIMicroservice;
use App\Service\Microservice\ServiceException;

class PoiController extends Controller
{
    /**
     * @var PoiRepository
     */
    private $repository;
    private $service;

    public function __construct(PoiRepository $repository)
    {
        $this->repository = $repository;
        $this->service = new POIMicroservice();
    }

    public function nearest(Request $request)
    {
        try {
            $lat = $request->get('lat');
            $lng = $request->get('lng');
            return response()->json($this->service->nearest($lat, $lng));
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function index(Request $request)
    {
        $items = $this->repository->paginate(1000);
        if (count($items['data']) == 0) {
            return response()->json([
                'data' => [],
                'time' => $this->lastUpdatedTime(),
            ]);
        }

        return response()->json($items);
    }

    public function check(Request $request)
    {
        try {
            $lastTime = intval($request->get('time'));
            $updateAvailable = $lastTime < $this->lastUpdatedTime();
            return response()->json($updateAvailable);
        } catch (\Exception $e) {
            return response()->json(false);
        }
    }

    private function lastUpdatedTime()
    {
        return $this->repository
                ->skipPresenter()
                    ->pushCriteria(new LastUpdatedCriteria())
                        ->first(['updated_at'])
                            ->updated_at
                                ->timestamp;
    }
}
