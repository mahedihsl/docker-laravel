<?php

namespace App\Listeners;

use App\Events\AssignmentCreated;
use App\Entities\Assignment;
use App\Service\SmsService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SmsToDriver
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AssignmentCreated  $event
     * @return void
     */
    public function handle(AssignmentCreated $event)
    {
        $phone = $event->assignment->driver->phone;
        $content = $this->content($event->assignment);

        $service = new SmsService();
        $service->send($phone, $content, 'driver');
    }

    public function content($model)
    {
        $message  = "New assignment for you.\n";
        $message .= "Time: {$model->from->toDayDateTimeString()}\n";
        if ($model->type == Assignment::TYPE_EMPLOYEE) {
            $message .= "Officer: {$model->employee->name}\n";
            $message .= "Phone: {$model->employee->phone}\n";
        } else {
            $message .= $model->message;
        }
        return $message;
    }
}
