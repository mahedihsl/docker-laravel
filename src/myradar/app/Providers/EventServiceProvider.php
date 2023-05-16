<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\CustomerCreated' => [
            'App\Listeners\SendPasswordSms',
            'App\Listeners\SetCustomerSettings',
        ],

        'App\Events\PasswordChanged' => [
            'App\Listeners\SendNewPasswordSms',
        ],

        'App\Events\CarCreated' => [
            'App\Listeners\MakeActivationKey',
            'App\Listeners\ApplyPromoCode',
        ],

        'App\Events\DeviceBinded' => [
            'App\Listeners\HideGasData',
            'App\Listeners\HideFuelData',
            'App\Listeners\HideLatLngData',
            'App\Listeners\HideEventData',
        ],

        'App\Events\LatLngReceived' => [
            'App\Listeners\PushLatLngToApp',
            'App\Listeners\StoreLatLngToDevice',
        ],

        'App\Events\ServiceStringReceived' => [
            'App\Listeners\UpdateEventCache',
        ],

        'App\Events\FenceAttached' => [
            'App\Listeners\UpdateFenceLog',
        ],

        'App\Events\FenceCreated' => [
            'App\Listeners\AttemptToAttachFence',
        ],

        'App\Events\UnregisteredTokenFound' => [
            'App\Listeners\DeleteUnregisteredToken',
        ],

        'App\Events\FenceDeleted' => [
            'App\Listeners\UnsubscribeFence',
            'App\Listeners\DeleteFenceLog',
            'App\Listeners\DeleteCustomFence',
        ],

        'App\Events\FuelReceived' => [
            // 'App\Listeners\UpdateDailyFuel',
            'App\Listeners\CheckFuelRefuel',
        ],

        'App\Events\GasReceived' => [
            'App\Listeners\UpdateDailyGas',
            'App\Listeners\CheckGasRefuel',
            'App\Listeners\CheckGasRefuelByFiltering',
        ],

        'App\Events\GasRefueled' => [
            'App\Listeners\SendGasRefuelPush',
            // 'App\Listeners\SendGasRefuelSms',
            'App\Listeners\SaveGasRefuelEvent',
        ],

        'App\Events\GasRefueledByFiltering' => [
            'App\Listeners\SaveGasRefuelEventByFiltering',
        ],

        'App\Events\FuelRefueled' => [
            'App\Listeners\SaveFuelRefuelEvent',
            //'App\Listeners\SendFuelRefuelSms',
            //'App\Listeners\SendGasRefuelPush',
        ],

        'App\Events\FenceCrossEvent' => [
            'App\Listeners\NotifyFenceCross',
            'App\Listeners\UpdateFenceMetaData',
            'App\Listeners\StoreGeoFenceEvent',
            'App\Listeners\CheckTripOver',
        ],

        'App\Events\SpeedLimitCrossEvent' => [
            'App\Listeners\SpeedLimitCrossListener',
            'App\Listeners\StoreSpeedEvent',
        ],

        // !NOTE: this module is moved to 'user' microservice
        'App\Events\AccountStatusChanged' => [
            'App\Listeners\SendAccountStatusNoti',
            'App\Listeners\SendAccountStatusSms',
            'App\Listeners\SaveAccountStatusLog',
        ],

        'App\Events\CarStatusChanged' => [
            'App\Listeners\SendCarStatusNoti',
            'App\Listeners\SendCarStatusSms',
            'App\Listeners\SaveCarStatusLog',
        ],

        'App\Events\LockWhenEngineOnEvent' => [
            'App\Listeners\LockWhenEngineOnListener',
        ],

        'App\Events\LockWhenEngineOffEvent' => [
            'App\Listeners\LockWhenEngineOffListener',
        ],

        'App\Events\UnlockWhenEngineOnEvent' => [
            'App\Listeners\UnlockWhenEngineOnListener',
        ],

        'App\Events\UnlockWhenEngineOffEvent' => [
            'App\Listeners\UnlockWhenEngineOffListener',
        ],

        'App\Events\UnlockWhenEngineOffEvent' => [
            'App\Listeners\UnlockWhenEngineOffListener',
        ],

        'App\Events\EngineStatusChanged' => [
            'App\Listeners\NotifyEngineStatus',
            'App\Listeners\BroadcastEngineStatus',
            'App\Listeners\StoreEngineEvent',
            'App\Listeners\UpdateEventMetaData',
            'App\Listeners\UpdateDrivingHour',
            'App\Listeners\UpdateDutyHour',
            'App\Listeners\UpdateAcStatus',
        ],

        'App\Events\DeviceTokenReceived' => [
            'App\Listeners\SyncDeviceToken',
        ],

        'App\Events\FitnessDateExpire' => [
            'App\Listeners\NotifyFitnessExpire',
        ],

        'App\Events\TaxDateExpire' => [
            'App\Listeners\NotifyTaxExpire',
        ],

        'App\Events\InsuranceDateExpire' => [
            'App\Listeners\NotifyInsuranceExpire',
        ],

        'App\Events\AssignmentCreated' => [
            'App\Listeners\SmsToDriver',
            'App\Listeners\SmsToEmployee',
        ],

        'App\Events\DeviceHealthReceived' => [
          'App\Listeners\UpdateImei',
          'App\Listeners\CheckFrequestReset',
        ],

        'App\Events\PanicStateTriggered' => [
            'App\Listeners\SendPanicSms',
            'App\Listeners\SendPanicPush',
            'App\Listeners\StorePanicEvent',
        ],

        'App\Events\AcStateChanged' => [
            'App\Listeners\SendAcPush',
            'App\Listeners\StoreAcEvent',
        ],

        'App\Events\DoorStateChanged' => [
            'App\Listeners\SendDoorPush',
            'App\Listeners\StoreDoorEvent',
        ],

        'App\Events\PaymentReceived' => [
            'App\Listeners\SendPaymentAcknowledgeSms',
            'App\Listeners\SendPaymentAcknowledgePush',
        ],
        'App\Events\ComplainCreated' => [
            'App\Listeners\SendComplainAckSms',
        ],
        'App\Events\ComplainClosed' => [
            'App\Listeners\SendComplainCloseSms',
        ],
	    'App\Events\ExternalDeviceDataReceived' => [
            'App\Listeners\SendToExternalServer',
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */

     protected $subscribe = [
       'App\Listeners\UpdateDeviceLastPulse',
     ];


    public function boot()
    {
        parent::boot();
    }
}
