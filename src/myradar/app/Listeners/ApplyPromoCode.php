<?php

namespace App\Listeners;

use App\Events\CarCreated;
use App\Entities\PromoCode;
use App\Entities\PromoScheme;
use App\Service\Payment\PromoPayment;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplyPromoCode
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    private $service;
    public function __construct()
    {
        $this->service = new PromoPayment();
    }

    /**
     * Handle the event.
     *
     * @param  CarCreated  $event
     * @return void
     */
    public function handle(CarCreated $event)
    {
        $promo = PromoCode::where('code', $event->promo)->first();

        if ( ! is_null($promo)) {
            $applied_users = $promo->applied;
            array_push($applied_users, $event->car->user->id);
            $promo->applied = $applied_users;
            $promo->save();

            if($promo){
              $this->service->autoPay($promo);
            }
        }
    }
}
