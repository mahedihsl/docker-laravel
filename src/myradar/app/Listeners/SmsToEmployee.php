<?php

namespace App\Listeners;

use App\Events\AssignmentCreated;
use App\Entities\Assignment;
use App\Service\SmsService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SmsToEmployee
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
        if ($event->assignment->type == Assignment::TYPE_EMPLOYEE) {
            $phone = $event->assignment->employee->phone;
            $content = $this->content($event->assignment);

            $service = new SmsService();
            $service->send($phone, $content, 'employee');
        }
    }

    public function content($model)
    {
        $message  = "A driver is assigned to you.\n";
        $message .= "Time: {$model->from->toDayDateTimeString()}\n";
        $message .= "Driver: {$model->driver->name}\n";
        $message .= "Phone: {$model->driver->phone}\n";
        return $message;
    }
}
