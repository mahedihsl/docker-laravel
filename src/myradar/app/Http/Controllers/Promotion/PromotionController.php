<?php

namespace App\Http\Controllers\Promotion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\SmsService;
use App\Contract\Repositories\PromotionRepository;
use App\Criteria\LastUpdatedCriteria;
use App\Entities\User;
use App\Entities\PromoScheme;
use App\Jobs\PushNotificationJob;
use App\Service\Microservice\PushMicroservice;

class PromotionController extends Controller
{
  /**
   * @var PromotionRepository
   */
   private $repository;
    public function __construct(PromotionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        return view('promotion.index');
    }

    public function save(Request $request)
    {
      $this->repository->save(collect($request->all()));
      return response()->ok();
    }

    public function show(Request $request)
    {
      $list = $this->repository->pushCriteria(new LastUpdatedCriteria())
                               ->all();
                               
                               
      return response()->json($list);
    }

    public function codeList(Request $request)
    {

    }

    public function message(Request $request)
    {
        $id = $request->get('id');
        $phone = $request->get('phone');
        $message = $request->get('message');

        try {
            $SmsService = new SmsService();
          $response = $SmsService->send($phone , $message, 'promo_1');
        } catch (\Exception $e) {
          return response()->error($e);
        }

        return response()->ok();
    }

    public function notification(Request $request)
    {
        $id = $request->get('id');
        $data = collect([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'type' => 1,
        ]);

        if ( ! is_null(User::find($id))) {
            $service = new PushMicroservice();
            $service->send($id, $data);

            return response()->ok();
        }

        return response()->error();
    }
}
