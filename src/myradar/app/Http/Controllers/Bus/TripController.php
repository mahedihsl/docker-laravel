<?php

namespace App\Http\Controllers\Bus;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\TripRepository;
use App\Criteria\CarIdCriteria;
use App\Criteria\OrderByIdCriteria;
use App\Criteria\WithinDatesCriteria;
use App\Presenters\TripPresenter;
use Carbon\Carbon;

class TripController extends Controller
{
    /**
     * @var TripRepository
     */
    private $repository;

    public function __construct(TripRepository $repository)
    {
        $this->repository = $repository;
    }

    public function report(Request $request, $id, $days)
    {
        $days = intval($days);
        $start = Carbon::now()->subDays($days - 1);
        $list = $this->repository
                    ->pushCriteria(new CarIdCriteria($id))
                    ->scopeQuery(function($query) use ($start) {
                        return $query->where('start', '>=', $start);
                    })
                    ->all();

        $ret = collect();
        for ($i=0; $i < $days; $i++) {
            $temp = Carbon::today()->subDays($i);

            $count = $list->filter(function($trip) use ($temp) {
                $temp2 = $temp->copy()->addDay();
                return $temp->lte($trip->start) && $temp2->gte($trip->start);
            })->count();

            $ret->push([
                'value' => $count,
                'date' => $temp->format('j M'),
            ]);
        }

        return response()->ok($ret);
    }

    public function details(Request $request, $id, $day)
    {
        $start = Carbon::today()->subDays($day);
        $end = $start->copy()->addDay();
        $list = $this->repository
                ->setPresenter(TripPresenter::class)
                ->pushCriteria(new CarIdCriteria($id))
                ->pushCriteria(new WithinDatesCriteria($start, $end, 'start'))
                ->pushCriteria(new OrderByIdCriteria())
                ->all();
        return response()->ok($list);
    }

}
