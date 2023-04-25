<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\ActivationRepository;
use App\Criteria\LastCreatedCriteria;
use App\Criteria\WithinDatesCriteria;
use App\Service\Microservice\UserMicroservice;
use Carbon\Carbon;
use Excel;
use App\Transformers\ActivationExportTransformer;

class ActivationController extends Controller
{
    /**
     * @var ActivationRepository
     */
    private $repository;

    public function __construct(ActivationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function cleanup()
    {
        $list = $this->repository
            ->with(['car'])
            ->get()
            ->filter(function($item) {
                return is_null($item->car);
            });
        $count = 0;
        foreach ($list as $item) {
            // $item->delete();
            $count++;
        }
        return $count;
    }

    public function index(Request $request)
    {
        $this->repository->pushCriteria(new LastCreatedCriteria());

        return view('activation.index')->with([
            'items' => $this->repository->with(['car'])->paginate(50),
            'disable_count' => $request->get('disable', 0),
        ]);
    }

    public function export(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');

        if (!$from || !$to) {
            return redirect()->back();
        }

        $from = Carbon::createFromFormat("j M Y", $from);
        $to = Carbon::createFromFormat("j M Y", $to);

        $this->repository->pushCriteria(new WithinDatesCriteria($from, $to));
        $this->repository->pushCriteria(new LastCreatedCriteria());

        $data = $this->repository->with(['car'])->all()->filter(function ($model) {
            return !is_null($model->car);
        });

        Excel::create('ActivationKeys', function ($excel) use ($data) {
            $excel->sheet('data', function ($sheet) use ($data) {
                $data->transform(function ($item) {
                    $transformer = new ActivationExportTransformer();
                    return $transformer->transform($item);
                });

                $sheet->fromArray($data->toArray(), null, 'A1', false, true);
            });
        })->download('xls');

        return redirect()->back();
    }

    public function batchDisable(Request $request)
    {
        $carNames = Excel::load($request->file('blacklist'))
            ->get()
            ->map(function($row) {
                return $row->get('reg_no');
            })
            ->filter(function($name) {
                return !is_null($name);
            });
        $service = new UserMicroservice();
        foreach ($carNames as $name) {
            $service->disableByCar($name);
        }
        return redirect()->route('activation.report', [
            'disable' => $carNames->count(),
        ]);
    }
}
