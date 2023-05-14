<?php

namespace App\Listeners;

use App\Events\DeviceBalanceReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateDeviceBalance
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
     * @param  DeviceBalanceReceived  $event
     * @return void
     */
    public function handle(DeviceBalanceReceived $event)
    {
        $factors = [
            'kb' => 1 / 1024,
            'mb' => 1,
            'gb' => 1024,
        ];

        $balance = strtolower($event->balance);
        $unit = preg_replace('/[^a-zA-Z]/', '', $balance);
        $value = floatval($balance) * $factors[$unit];

        $current = $event->device->last_recharge;
        $event->device->update([
            'balance.consumed' => $current->volume - $value,
            'balance.remained' => $value,
            'balance.updated_at' => time(),
        ]);

        $current->update([
            'consumed' => $current->volume - $value,
            'remained' => $value,
        ]);
    }
}
