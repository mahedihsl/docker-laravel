<?php

namespace App\Http\Controllers\Car;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\EventRepository;
use App\Criteria\CarIdCriteria;
use App\Criteria\NRecordsCriteria;
use App\Criteria\EventTypeCriteria;
use App\Criteria\OrderByIdCriteria;

use App\Entities\Device;
use App\Entities\Event;
use Carbon\Carbon;
use App\Criteria\LastCreatedCriteria;
use Illuminate\Pagination\LengthAwarePaginator;

class EventController extends Controller
{
    /**
     * @var EventRepository
     */
    private $repository;

    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, $id)
    {
        $query = [
            '$and' => [
                ['car_id' => ['$eq' => $id]],
                ['deleted_at' => ['$eq' => null]],
            ]
        ];
        $per_page = 50;
        $page = intval($request->get('page', 1));
        $options = [
            'skip' => ($page - 1) * $per_page,
            'limit' => $per_page,
            'sort' => ['created_at' => -1],
        ];

        $total = Event::raw(function($collection) use ($query) {
            return $collection->count($query);
        });
        $items = Event::raw(function($collection) use ($query, $options) {
            return $collection->find($query, $options);
        });
        $items = $this->repository->parserResult($items);
        // $data = new LengthAwarePaginator($items, $total, $per_page, $page);
        return response()->ok([
            'data' => $items['data'],
            'meta' => [
                'pagination' => [
                    'total' => $total,
                    'per_page' => $per_page,
                    'current_page' => $page,
                    'total_pages' => ceil($total / $per_page),
                ]
            ]
        ]);
        // return response()->ok($data);
    }
    public function recent(Request $request, $id)
    {
        $device= Device::find($id);
        $models = $this->repository
                        ->pushCriteria(new CarIdCriteria($device->car_id))
                        ->pushCriteria(new OrderByIdCriteria(false))
                        ->pushCriteria(new EventTypeCriteria($request->get('type')))
                        ->pushCriteria(new NRecordsCriteria($request->get('limit')))
                        ->all();

        return response()->ok($models);
    }
}
