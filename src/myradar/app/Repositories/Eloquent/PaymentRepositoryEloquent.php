<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\PaymentRepository;
use App\Entities\Payment;
use App\Events\PaymentReceived;
use Carbon\Carbon;

/**
 * Class PaymentRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class PaymentRepositoryEloquent extends BaseRepository implements PaymentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Payment::class;
    }

    public function save(Collection $data)
    {
        $months = collect(json_decode($data->get('months')))
                    ->sort()
                    ->map(function($item) use ($data) {
                        return [$item, intval($data->get('year'))];
                    })->toArray();

        if ( ! sizeof($months)) {
            return null;
        }

        // $months = json_decode($data->get('months'));

        $payment = $this->create([
            'amount' => intval($data->get('amount')),
            'months' => $months,
            'car_id' => $data->get('car_id'),
            'user_id' => $data->get('user_id'),
            'paid_on' => Carbon::createFromTimestamp(intval($data->get('date'))),
            'extra'  => intval($data->get('extra')),
            'waive'  => intval($data->get('waive')),
			'note' => $data->get('note'),
            'type' => intval($data->get('type')),
        ]);

        event(new PaymentReceived($payment));

        return $payment;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
