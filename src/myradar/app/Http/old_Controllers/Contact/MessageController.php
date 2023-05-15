<?php

namespace App\Http\Controllers\Contact;

use App\Service\Microservice\PromotionMicroservice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMessage;
use App\Contract\Repositories\MessageRepository;
use App\Presenters\MessagePresenter;
use App\Criteria\LastUpdatedCriteria;

class MessageController extends Controller
{
    /**
     * @var MessageRepository
     */
    private $repository;
    private $promotionService;

    public function __construct(MessageRepository $repository)
    {
        $this->repository = $repository;
        $this->promotionService = new PromotionMicroservice();
    }

    public function index(Request $request)
    {
        $this->repository->pushCriteria(new LastUpdatedCriteria());
        return view('message.index')->with([
            'messages' => $this->repository->paginate(),
        ]);
    }

    public function store(CreateMessage $request)
    {
        try {
            $this->promotionService->saveContactMessage($request->all());
            return response()->ok('Message Sent');
        } catch (\Exception $th) {
            return response()->error($th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        # code...
    }
}
