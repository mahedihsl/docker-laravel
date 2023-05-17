<?php
use App\Http\Controllers\Api\Device\RestAPIController;
use App\Http\Controllers\Api\Device\SetupController;
use App\Http\Controllers\Api\Poi\StoppageController;
use App\Http\Controllers\Api\GeoFence\GeofenceController;
use App\Http\Controllers\Api\RadarRecharge\RadarController;
use App\Http\Controllers\RMS\SiteController;
use App\Http\Controllers\RMS\DGController;
use App\Http\Controllers\RMS\AuthController as RmsAuthController;
use App\Http\Controllers\RMS\BatteryController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\RMS\MainsController;
use App\Http\Controllers\RMS\DoorController;
use App\Http\Controllers\RMS\TemperatureController;
use App\Http\Controllers\Api\Poi\PoiController;
use App\Http\Controllers\Api\Position\TrackingController;
use App\Http\Controllers\Test\NotificationController;
use App\Http\Controllers\Api\GeoFence\DistrictController;
use App\Http\Controllers\Api\GeoFence\ThanaController;
use App\Http\Controllers\Api\GeoFence\FenceController;
use App\Http\Controllers\Api\GeoFence\FenceLogController;
use App\Http\Controllers\Api\Car\EventController;
use App\Http\Controllers\Api\Account\BillingController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Api\Account\SettingsController;
use App\Http\Controllers\Api\Device\EngineController;
use App\Http\Controllers\Api\User\NotificationController as UserNotificationController;
use App\Http\Controllers\Service\GasController;
use App\Http\Controllers\Service\FuelController;
use App\Http\Controllers\Api\Position\MileageController;
use App\Http\Controllers\Service\MileageController as ServiceMileageController;
use App\Http\Controllers\Bus\TripController;
use App\Http\Controllers\Api\Car\CarController;
use App\Http\Controllers\Input\GasRefuelInputController;
use App\Http\Controllers\Input\FuelCalibrationInputController;
use App\Http\Controllers\Device\DeviceController;
use App\Http\Controllers\Api\Device\DeviceController as ApiDeviceController;
use App\Http\Controllers\Api\Account\SessionController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//restapi
Route::post('login', [App\Http\Controllers\Api\Device\RestAPIController::class,'login']);
Route::post('sendVerificationCode', [App\Http\Controllers\Api\Device\RestAPIController::class,'sendVerificationCode']);
Route::post('checkVerificationCode', [App\Http\Controllers\Api\Device\RestAPIController::class,'checkVerificationCode']);
Route::post('updateCarDates', [App\Http\Controllers\Api\Device\RestAPIController::class,'updateCarDates']);
Route::post('updateUserInfo', [App\Http\Controllers\Api\Device\RestAPIController::class,'updateUserInfo']);
Route::post('changePassword', [App\Http\Controllers\Api\Device\RestAPIController::class,'changePassword']);
Route::post('resetPassword', [App\Http\Controllers\Api\Device\RestAPIController::class,'resetPassword']);
Route::post('isAuthorized', [App\Http\Controllers\Api\Device\RestAPIController::class,'isAuthorized']);
Route::get('getState/{user_id}', [App\Http\Controllers\Api\Device\RestAPIController::class,'getState']);
Route::post('/car/dates', [App\Http\Controllers\Api\Device\RestAPIController::class,'getCarDates']);
Route::post('/mobile/getUserLocation', [App\Http\Controllers\Api\Device\RestAPIController::class,'getUserLocation']);
Route::post('/logout', [App\Http\Controllers\Api\Device\RestAPIController::class,'logout']);

// login
Route::post('/auth/login', [App\Http\Controllers\Api\Auth\LoginController::class,'login']);
Route::post('/auth/refresh', [App\Http\Controllers\Api\Auth\LoginController::class,'refresh']);
Route::post('/auth/profile', [App\Http\Controllers\Api\Auth\LoginController::class,'profile']);

Route::post('/demo-account/enroll', 'Promotion\CampaignController@demoLead');

Route::post('/customer/login', [App\Http\Controllers\Api\Auth\AuthController::class,'login']);
Route::get('/app/version', function () {
    return response()->ok(config('app.version'));
});
Route::get('/health-check', function () {
    return response()->json(['status' => true]);
});
Route::get('/running-server', [App\Http\Controllers\HomeController::class,'runningServer']);

Route::get('/device/find-by-imei',  [App\Http\Controllers\Api\Device\LoginController::class,'find']);

Route::get('/test', 'Api\Account\SettingsController@test');
Route::get('/remove-test/{type}', 'Api\Device\ServiceController@removeData');

Route::group(['middleware' => ['BkashPayment']], function () {
    Route::post('bkash/save/payment', 'Payment\BkashPaymentController@save');
    Route::post('bkash/bill/query', 'Payment\BkashPaymentController@query');
});

Route::middleware(['LogMiddleware'])->group(function () {
    Route::post('getLocknEngineState', [RestAPIController::class, 'getLocknEngineState'])->middleware('engage');

    Route::post('/device/setup/init', [SetupController::class, 'init']);
    Route::post('/v2/device/setup/init', [SetupController::class, 'initv2']);
    Route::post('/v3/device/setup/init', [SetupController::class, 'initv3']);
    Route::post('/v4/device/setup/init', [SetupController::class, 'initv4']);
    Route::post('/device/lock/status', [SetupController::class, 'status']);
    Route::post('/device/midnight/diff', [SetupController::class, 'midnight']);
    Route::post('/device/health/store', [HealthController::class, 'save']);
    Route::post('/device/speed/notify', [SpeedController::class, 'notify']);

    Route::post('/device/consume/service', [ServiceController::class, 'consume']);
    Route::post('/device/consume/engine', [EngineController::class, 'consume']); // called from myradar-receiver
    Route::post('/gas/on-refuel', [GasController::class, 'onRefuel']); // called from myradar-receiver

    Route::post('/device/engine/update', [EngineController::class, 'update']);
    Route::post('/device/lock/update', [EngineController::class, 'updateLock']);
    Route::post('/device/engine/update/test', [EngineController::class, 'test']);
});

Route::get('/car/list', [CarController::class, 'list']);
Route::post('/car/assign-route', [CarController::class, 'assignRoute']);
Route::get('/device/list', [ApiDeviceController::class, 'list']);

Route::get('/stoppage/list', [StoppageController::class, 'list']);
Route::post('/stoppage/save', [StoppageController::class, 'save']);
Route::post('/stoppage/update', [StoppageController::class, 'update']);
Route::post('/stoppage/remove', [StoppageController::class, 'remove']);

Route::get('/geofence/list', [GeofenceController::class, 'list']);
Route::post('/geofence/save', [GeofenceController::class, 'save']);
Route::post('/geofence/update', [GeofenceController::class, 'update']);
Route::post('/geofence/remove', [GeofenceController::class, 'remove']);
Route::get('/geofence/violations', [GeofenceController::class, 'violations']);

Route::get('/trip/history', [TripController::class, 'history']);
Route::post('/trip/test', [TripController::class, 'test']);

// For Radar Recharge
Route::post('/radar/test', [RadarController::class, 'test']);
Route::post('/radar/signup', [RadarController::class, 'signup']);
Route::post('/radar/validate', [RadarController::class, 'validateCard']);
Route::post('/radar/recharge', [RadarController::class, 'rechargeCard']);
Route::post('/radar/confirm', [RadarController::class, 'confirmWrite']);
Route::get('/radarpay/msgid', [Test\MicroServiceController::class, 'messageId']);

//For RMS
Route::get('/rms/site/list', [SiteController::class, 'index']);
Route::post('/rms/site/session-start', [SiteController::class, 'sessionStart']);
Route::post('/rms/site/cache-status', [SiteController::class, 'cacheSiteStatus']);
Route::get('/rms/site/status-counts', [SiteController::class, 'statusCounts']);
Route::get('/rms/site/pin/fetch', [SiteController::class, 'fetchPinConfig']);
Route::get('/rms/site/digital-control', [SiteController::class, 'getDigitalControl']);
Route::post('/rms/site/digital-control', [SiteController::class, 'setDigitalControl']);
Route::get('/rms/site/availability', [SiteController::class, 'availability']);
Route::get('/rms/site/site-events', [SiteController::class, 'siteEvents']);
Route::get('/rms/site/site-alarms', [SiteController::class, 'siteAlarms']);
Route::get('/rms/site/network-events', [SiteController::class, 'networkEvents']);
Route::get('/rms/site/filter-network-events', [SiteController::class, 'filterNetworkEvents']);
Route::get('/rms/site/network-healths', [SiteController::class, 'networkHealths']);
Route::post('/rms/site/save-settings', [SiteController::class, 'saveSettings']);
Route::post('/rms/site/clear-security-breach', [SiteController::class, 'clearSecurityBreach']);
Route::post('/rms/site/unlock', [SiteController::class, 'unlockSite']);
Route::post('/rms/user/update-profile', [UserController::class, 'updateProfile']);
Route::post('/rms/user/change-password', [UserController::class, 'changePassword']);

Route::post('/rms/auth/login', [RmsAuthController::class, 'login']);
Route::post('/rms/auth/refresh', [RmsAuthController::class, 'refresh']);
Route::get('/rms/auth/user', [RmsAuthController::class, 'user']);
Route::post('/rms/auth/logout', [RmsAuthController::class, 'logout']);

Route::get('/rms/dg/events', [DGController::class, 'events']);
Route::get('/rms/dg/runhours', [DGController::class, 'runhours']);
Route::get('/rms/dg/export-data', [DGController::class, 'exportData']);
Route::get('/rms/dg/critical-sites', [DGController::class, 'criticalSites']);
Route::get('/rms/battery/voltage/history', [BatteryController::class, 'voltageHistory']);
Route::get('/rms/battery/voltage/export', [BatteryController::class, 'exportVoltage']);
Route::get('/rms/battery/current/export', [BatteryController::class, 'exportCurrent']);
Route::get('/rms/battery/current/trend', [BatteryController::class, 'currentTrend']);
Route::get('/rms/battery/voltage/profile', [BatteryController::class, 'voltageProfile']);
Route::get('/rms/battery/health/history', [BatteryController::class, 'healthHistory']);
Route::get('/rms/battery/critical-sites', [BatteryController::class, 'criticalSites']);
Route::get('/rms/battery/events', [BatteryController::class, 'events']);
Route::get('/rms/battery/energy-consumption', [BatteryController::class, 'energyConsumption']);
Route::get('/rms/battery/power-trend', [BatteryController::class, 'powerTrend']);
Route::get('/rms/battery/power-history', [BatteryController::class, 'powerHistory']);

Route::get('/rms/mains/recent', [MainsController::class, 'recent']);
Route::get('/rms/mains/events', [MainsController::class, 'events']);
Route::get('/rms/mains/offhours', [MainsController::class, 'offhours']);
Route::get('/rms/mains/export-data', [MainsController::class, 'exportData']);
Route::get('/rms/mains/critical-sites', [MainsController::class, 'criticalSites']);
Route::get('/rms/mains/availability', [MainsController::class, 'availability']);
Route::get('/rms/mains/power-trend', [MainsController::class, 'powerTrend']);
Route::get('/rms/mains/hourly-power-trend', [MainsController::class, 'hourlyPowerTrend']);
Route::post('/rms/mains/last-event', [MainsController::class, 'lastEvent']);

Route::get('/rms/door/openhours', [DoorController::class, 'openhours']);
Route::get('/rms/door/events', [DoorController::class, 'events']);
Route::get('/rms/door/access/fetch-records', [DoorController::class, 'getAccessRecords']);
Route::post('/rms/door/access/save-record', [DoorController::class, 'saveAccessRecord']);
Route::get('/rms/door/access/fetch-cards', [DoorController::class, 'getAccessCards']);
Route::post('/rms/door/access/add-card', [DoorController::class, 'addAccessCard']);
Route::post('/rms/door/access/delete-card', [DoorController::class, 'deleteAccessCard']);
Route::post('/rms/door/access/clear-cards', [DoorController::class, 'clearAccessCardList']);

Route::get('/rms/acs/site/group-list', [DoorController::class, 'getSiteGroups']);
Route::post('/rms/acs/site/save-group', [DoorController::class, 'saveSiteGroup']);
Route::post('/rms/acs/site/delete-group', [DoorController::class, 'deleteSiteGroup']);
Route::get('/rms/acs/card/list', [DoorController::class, 'getCardList']);
Route::post('/rms/acs/card/save', [DoorController::class, 'saveAccessCard']);
Route::get('/rms/acs/card/group-list', [DoorController::class, 'getCardGroups']);
Route::post('/rms/acs/card/save-group', [DoorController::class, 'saveCardGroup']);
Route::post('/rms/acs/card/delete-group', [DoorController::class, 'deleteCardGroup']);
Route::post('/rms/acs/attach-groups', [DoorController::class, 'attachSiteAndCardGroups']);

Route::get('/rms/temperature/recent', [TemperatureController::class, 'recent']);
Route::get('/rms/temperature/aggregate', [TemperatureController::class, 'aggregate']);
Route::get('/rms/temperature/events', [TemperatureController::class, 'events']);
Route::get('/rms/temperature/critical-sites', [TemperatureController::class, 'criticalSites']);

Route::get('/mileage/list', [MileageController::class, 'list']);
Route::get('/poi/nearest', [PoiController::class, 'nearest']);
Route::get('/location/history', [TrackingController::class, 'history']);
Route::get('/location/latest', [TrackingController::class, 'latest']);

Route::group(['middleware' => ['auth:api', 'account', 'engage']], function () {
    Route::get('/poi/list', [PoiController::class, 'index']);
    Route::get('/poi/check/update', [PoiController::class, 'check']);

    Route::post('/customer/logout', [AuthController::class, 'logout']);
    Route::post('/bind/token', [UserNotificationController::class, 'bind']);

    Route::post('/test/sms', [NotificationController::class, 'sms']);
    Route::post('/test/noti', [NotificationController::class, 'noti']);
    Route::post('/test/one-signal', [NotificationController::class, 'onesignal']);

    Route::get('/district/list', [DistrictController::class, 'index']);
    Route::get('/thana/list/{district}', [ThanaController::class, 'index']);
    Route::get('/fence/list/{thana}', [FenceController::class, 'index']);
    Route::post('/fence/toggle', [FenceController::class, 'toggle']);

    Route::get('/fence/history/{id}', [FenceLogController::class, 'index']);
    Route::post('/fence/save', [FenceController::class, 'save']);
    Route::post('/fence/add', [FenceLogController::class, 'save']);
    Route::post('/fence/delete', [FenceController::class, 'delete']);

    // Route::get('/poi/check/update/test', [PoiController::class, 'test']);

    Route::get('/event/list/{car}', [EventController::class, 'events']);
    Route::get('/event/list/test/{car}', [EventController::class, 'test']);

    Route::get('/car/last/position/{id}', [TrackingController::class, 'last']);

    Route::get('/billing/status', [BillingController::class, 'status']);
    Route::get('/payment/paymentlist/{userId}', [PaymentController::class, 'index']);
    Route::get('/payment/due/{userId}', [PaymentController::class, 'getDue']);
    Route::get('/user/ref/{userId}', [PaymentController::class, 'getRefNo']);

    Route::get('/settings/status', [SettingsController::class, 'status']);
    Route::post('/settings/toggle', [SettingsController::class, 'toggle']);

    Route::post('/lock/status/toggle', [EngineController::class, 'toggle']);
    Route::post('/control/status/toggle', [EngineController::class, 'updateControlState']);
    Route::get('/lock/transition/status', [EngineController::class, 'transitionStatus']);

    Route::get('/noti/test/{id}', [UserNotificationController::class, 'test']);

    Route::get('/gas/latest/{id}', [GasController::class, 'latest']);
    Route::get('/gas/history/{id}', [GasController::class, 'archive']);
    Route::get('/gas/history/{id}/{days}', [GasController::class, 'history']);
    Route::get('/fuel/latest/{id}', [FuelController::class, 'latest']);
    Route::get('/fuel/history/{id}/{days}', [FuelController::class, 'history']);
    Route::get('/fuel/history/{days}', [FuelController::class, 'archive']);
    Route::get('/mileage/history/{id}', [ServiceMileageController::class, 'archive']);
    Route::get('/mileage/history/{carId}/{days}', [ServiceMileageController::class, 'records']);

    Route::get('/trip/report/{id}/{days}', [TripController::class, 'report']);
    Route::get('/trip/details/{id}/{day}', [TripController::class, 'details']);

    Route::post('/set/current/car', [SettingsController::class, 'test']);

    Route::get('/get/car/dates/{id}', [CarController::class, 'dates']);
    Route::post('/update/car/dates', [CarController::class, 'update']);
    Route::post('/update/calibration', [GasRefuelInputController::class, 'setPriceFactorByUser']);
    Route::post('/fuel/calibration/input', [FuelCalibrationInputController::class, 'store']);
    Route::post('/device/phone', [DeviceController::class, 'getPhone']);

    // New api developed for Android App migration by PALATOK
    Route::post('/session/register', [SessionController::class, 'register']);
    Route::post('/session/logout', [SessionController::class, 'logout']);

    Route::get('/device/config', [ConfigController::class, 'fetch']);
});