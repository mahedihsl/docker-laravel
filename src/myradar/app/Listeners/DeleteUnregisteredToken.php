<?php

namespace App\Listeners;

use App\Events\UnregisteredTokenFound;
use App\Entities\UserLogin;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteUnregisteredToken
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
     * @param  UnregisteredTokenFound  $event
     * @return void
     */
    public function handle(UnregisteredTokenFound $event)
    {
        UserLogin::where('device_type', $event->type)
                    ->where('device_token', $event->token)
                        ->delete();
    }
}
