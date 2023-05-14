<?php

namespace App\Listeners;

use App\Events\AccountStatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveAccountStatusLog
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
     * @param  AccountStatusChanged  $event
     * @return void
     */
    public function handle(AccountStatusChanged $event)
    {
        $event->user->status_log()->create([
            'status' => intval($event->user->isEnabled())
        ]);
    }
}
