<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Entities\Car;
use App\Service\SmsService;
use App\Service\Microservice\PushMicroservice;
use App\Service\Sms\DailySummerySms;
use Carbon\Carbon;

class DailySummerySmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $car;
    private $date;
    private $via;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($car_id, $via)
    {
        $this->car = Car::find($car_id);
        $this->date = Carbon::yesterday();
        $this->via = $via;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sms = new DailySummerySms($this->car, $this->date);

        if ($this->via == 'sms') {
            $service = new SmsService();
            $service->send($this->car->user->phone, $sms->content(), 'pack1');
        } else if ($this->via == 'push') {
            $data = [
                'title' => 'Report of car - ' . $this->car->reg_no,
                'body' => $sms->content(),
                'type' => 0,
            ];
            $pushService = new PushMicroservice();
            $pushService->send($this->car->user_id, $data);
        }
    }
}
