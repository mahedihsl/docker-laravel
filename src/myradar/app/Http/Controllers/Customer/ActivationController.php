<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Repositories\ActivationRepository;
use App\Criteria\LastUpdatedCriteria;
use App\Criteria\WithinDatesCriteria;
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

    public function index(Request $request)
    {
        $this->repository->pushCriteria(new LastUpdatedCriteria());

        return view('activation.index')->with([
            'items' => $this->repository->paginate(50),
        ]);
    }

    public function export(Request $request)
    {
        $from = Carbon::createFromFormat("j M Y", $request->get('from'));
        $to = Carbon::createFromFormat("j M Y", $request->get('to'));

        $this->repository->pushCriteria(new WithinDatesCriteria($from, $to));
        $this->repository->pushCriteria(new LastUpdatedCriteria());

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
}
