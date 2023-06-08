<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('login', [App\Http\Controllers\Api\Device\RestAPIController::class, 'login']);
Route::post('sendVerificationCode', [App\Http\Controllers\Api\Device\RestAPIController::class, 'sendVerificationCode']);
Route::post('checkVerificationCode', [App\Http\Controllers\Api\Device\RestAPIController::class, 'checkVerificationCode']);
Route::post('updateCarDates', [App\Http\Controllers\Api\Device\RestAPIController::class, 'updateCarDates']);
Route::post('updateUserInfo', [App\Http\Controllers\Api\Device\RestAPIController::class, 'updateUserInfo']);
Route::post('changePassword', [App\Http\Controllers\Api\Device\RestAPIController::class, 'changePassword']);
Route::post('resetPassword', [App\Http\Controllers\Api\Device\RestAPIController::class, 'resetPassword']);
Route::post('isAuthorized', [App\Http\Controllers\Api\Device\RestAPIController::class, 'isAuthorized']);
Route::get('getState/{user_id}', [App\Http\Controllers\Api\Device\RestAPIController::class, 'getState']);

Route::post('/car/dates', [App\Http\Controllers\Api\Device\RestAPIController::class, 'getCarDates']);

Route::post('/mobile/getUserLocation', [App\Http\Controllers\Api\Device\RestAPIController::class, 'getUserLocation']);

Route::post('/logout', [App\Http\Controllers\Api\Device\RestAPIController::class, 'logout']);

Route::post('/auth/login', [App\Http\Controllers\Api\Auth\LoginController::class, 'login']);
Route::post('/auth/refresh', [App\Http\Controllers\Api\Auth\LoginController::class, 'refresh']);
Route::post('/auth/profile', [App\Http\Controllers\Api\Auth\LoginController::class, 'profile']);

Route::post('/demo-account/enroll', [App\Http\Controllers\Promotion\CampaignController::class, 'demoLead']);

Route::post('/customer/login', [App\Http\Controllers\Api\Auth\AuthController::class, 'login']);
Route::get('/app/version', function() {
    return response()->ok(config('app.version'));
});
Route::get('/health-check', function() {
    return response()->json(['status' => true]);
});
Route::get('/running-server', [App\Http\Controllers\HomeController::class, 'runningServer']);

Route::get('/device/find-by-imei', [App\Http\Controllers\Api\Device\LoginController::class, 'find']);

Route::get('/test', [App\Http\Controllers\Api\Account\SettingsController::class, 'test']);
Route::get('/remove-test/{type}', [App\Http\Controllers\Api\Device\ServiceController::class, 'removeData']);

Route::group(['middleware' => ['BkashPayment']], function() {
    Route::post('bkash/save/payment', [App\Http\Controllers\Payment\BkashPaymentController::class, 'save']);
    Route::post('bkash/bill/query', [App\Http\Controllers\Payment\BkashPaymentController::class, 'query']);
});

Route::group(['middleware' => ['LogMiddleware']], function () {
    Route::post('getLocknEngineState', [App\Http\Controllers\Api\Device\RestAPIController::class, 'getLocknEngineState'])->middleware('engage');

    Route::post('/device/setup/init', [App\Http\Controllers\Api\Device\SetupController::class, 'init']);
    Route::post('/v2/device/setup/init', [App\Http\Controllers\Api\Device\SetupController::class, 'initv2']);
    Route::post('/v3/device/setup/init', [App\Http\Controllers\Api\Device\SetupController::class, 'initv3']);
    Route::post('/v4/device/setup/init', [App\Http\Controllers\Api\Device\SetupController::class, 'initv4']);
    Route::post('/device/lock/status', [App\Http\Controllers\Api\Device\SetupController::class, 'status']);
    Route::post('/device/midnight/diff', [App\Http\Controllers\Api\Device\SetupController::class, 'midnight']);
    Route::post('/device/health/store', [App\Http\Controllers\Api\Health\HealthController::class, 'save']);
    Route::post('/device/speed/notify', [App\Http\Controllers\Api\Position\SpeedController::class, 'notify']);

    Route::post('/device/consume/service', [App\Http\Controllers\ServiceController::class, 'consume']);

    Route::post('/device/engine/update', [App\Http\Controllers\Api\Device\EngineController::class, 'update']);
    Route::post('/device/lock/update', [App\Http\Controllers\Api\Device\EngineController::class, 'updateLock']);
    Route::post('/device/engine/update/test', [App\Http\Controllers\Api\Device\EngineController::class, 'test']);
});

Route::get('/car/list', [App\Http\Controllers\Api\Car\CarController::class, 'list']);
Route::post('/car/assign-route', [App\Http\Controllers\Api\Car\CarController::class, 'assignRoute']);
Route::get('/device/list', [App\Http\Controllers\Api\Device\DeviceController::class, 'list']);

Route::get('/stoppage/list', [App\Http\Controllers\Api\Poi\StoppageController::class, 'list']);
Route::post('/stoppage/save', [App\Http\Controllers\Api\Poi\StoppageController::class, 'save']);
Route::post('/stoppage/update', [App\Http\Controllers\Api\Poi\StoppageController::class, 'update']);
Route::post('/stoppage/remove', [App\Http\Controllers\Api\Poi\StoppageController::class, 'remove']);

Route::get('/geofence/list', [App\Http\Controllers\Api\GeoFence\GeofenceController::class, 'list']);
Route::post('/geofence/save', [App\Http\Controllers\Api\GeoFence\GeofenceController::class, 'save']);
Route::post('/geofence/update', [App\Http\Controllers\Api\GeoFence\GeofenceController::class, 'update']);
Route::post('/geofence/remove', [App\Http\Controllers\Api\GeoFence\GeofenceController::class, 'remove']);
Route::get('/geofence/violations', [App\Http\Controllers\Api\GeoFence\GeofenceController::class, 'violations']);

Route::get('/trip/history', [App\Http\Controllers\Api\Car\TripController::class, 'history']);
Route::post('/trip/test', [App\Http\Controllers\Api\Car\TripController::class, 'test']);

// For Radar Recharge
Route::post('/radar/test', [App\Http\Controllers\Api\RadarRecharge\RadarController::class, 'test']);
Route::post('/radar/signup', [App\Http\Controllers\Api\RadarRecharge\RadarController::class, 'signup']);
Route::post('/radar/validate', [App\Http\Controllers\Api\RadarRecharge\RadarController::class, 'validateCard']);
Route::post('/radar/recharge', [App\Http\Controllers\Api\RadarRecharge\RadarController::class, 'rechargeCard']);
Route::post('/radar/confirm', [App\Http\Controllers\Api\RadarRecharge\RadarController::class, 'confirmWrite']);
Route::get('/radarpay/msgid', [App\Http\Controllers\Test\MicroServiceController::class, 'messageId']);

// For RMS
Route::get('/rms/site/list', [App\Http\Controllers\RMS\SiteController::class, 'index']);
Route::post('/rms/site/session-start', [App\Http\Controllers\RMS\SiteController::class, 'sessionStart']);
Route::post('/rms/site/cache-status', [App\Http\Controllers\RMS\SiteController::class, 'cacheSiteStatus']);
Route::get('/rms/site/status-counts', [App\Http\Controllers\RMS\SiteController::class, 'statusCounts']);
Route::get('/rms/site/pin/fetch', [App\Http\Controllers\RMS\SiteController::class, 'fetchPinConfig']);
Route::get('/rms/site/digital-control', [App\Http\Controllers\RMS\SiteController::class, 'getDigitalControl']);
Route::post('/rms/site/digital-control', [App\Http\Controllers\RMS\SiteController::class, 'setDigitalControl']);
Route::get('/rms/site/availability', [App\Http\Controllers\RMS\SiteController::class, 'availability']);
Route::get('/rms/site/site-events', [App\Http\Controllers\RMS\SiteController::class, 'siteEvents']);
Route::get('/rms/site/site-alarms', [App\Http\Controllers\RMS\SiteController::class, 'siteAlarms']);
Route::get('/rms/site/network-events', [App\Http\Controllers\RMS\SiteController::class, 'networkEvents']);
Route::get('/rms/site/network-healths', [App\Http\Controllers\RMS\SiteController::class, 'networkHealths']);
Route::post('/rms/site/save-settings', [App\Http\Controllers\RMS\SiteController::class, 'saveSettings']);
Route::post('/rms/site/clear-security-breach', [App\Http\Controllers\RMS\SiteController::class, 'clearSecurityBreach']);

Route::post('/rms/auth/login', [App\Http\Controllers\RMS\AuthController::class, 'login']);
Route::post('/rms/auth/refresh', [App\Http\Controllers\RMS\AuthController::class, 'refresh']);
Route::get('/rms/auth/user', [App\Http\Controllers\RMS\AuthController::class, 'user']);
Route::post('/rms/auth/logout', [App\Http\Controllers\RMS\AuthController::class, 'logout']);

Route::get('/rms/dg/events', [App\Http\Controllers\RMS\DGController::class, 'events']);
Route::get('/rms/dg/runhours', [App\Http\Controllers\RMS\DGController::class, 'runhours']);
Route::get('/rms/dg/export-data', [App\Http\Controllers\RMS\DGController::class, 'exportData']);
Route::get('/rms/dg/critical-sites', [App\Http\Controllers\RMS\DGController::class, 'criticalSites']);

Route::get('/rms/battery/voltage/history', [App\Http\Controllers\RMS\BatteryController::class, 'voltageHistory']);
Route::get('/rms/battery/voltage/profile', [App\Http\Controllers\RMS\BatteryController::class, 'voltageProfile']);
Route::get('/rms/battery/health/history', [App\Http\Controllers\RMS\BatteryController::class, 'healthHistory']);
Route::get('/rms/battery/critical-sites', [App\Http\Controllers\RMS\BatteryController::class, 'criticalSites']);
Route::get('/rms/battery/events', [App\Http\Controllers\RMS\BatteryController::class, 'events']);
Route::get('/rms/battery/energy-consumption', [App\Http\Controllers\RMS\BatteryController::class, 'energyConsumption']);

Route::get('/rms/mains/recent', [App\Http\Controllers\RMS\MainsController::class, 'recent']);
Route::get('/rms/mains/events', [App\Http\Controllers\RMS\MainsController::class, 'events']);
Route::get('/rms/mains/offhours', [App\Http\Controllers\RMS\MainsController::class, 'offhours']);
Route::get('/rms/mains/export-data', [App\Http\Controllers\RMS\MainsController::class, 'exportData']);
Route::get('/rms/mains/critical-sites', [App\Http\Controllers\RMS\MainsController::class, 'criticalSites']);
Route::get('/rms/mains/availability', [App\Http\Controllers\RMS\MainsController::class, 'availability']);
Route::post('/rms/mains/last-event', [App\Http\Controllers\RMS\MainsController::class, 'LastEvent']);

Route::get('/rms/door/openhours', [App\Http\Controllers\RMS\DoorController::class, 'openhours']);
Route::get('/rms/door/events', [App\Http\Controllers\RMS\DoorController::class, 'events']);
Route::get('/rms/door/access/fetch-records', [App\Http\Controllers\RMS\DoorController::class, 'getAccessRecords']);
Route::post('/rms/door/access/save-record', [App\Http\Controllers\RMS\DoorController::class, 'saveAccessRecord']);
Route::get('/rms/door/access/fetch-cards', [App\Http\Controllers\RMS\DoorController::class, 'getAccessCards']);
Route::post('/rms/door/access/add-card', [App\Http\Controllers\RMS\DoorController::class, 'addAccessCard']);
Route::post('/rms/door/access/delete-card', [App\Http\Controllers\RMS\DoorController::class, 'deleteAccessCard']);
Route::post('/rms/door/access/clear-cards', [App\Http\Controllers\RMS\DoorController::class, 'clearAccessCardList']);

Route::get('/rms/temperature/recent', [App\Http\Controllers\RMS\TemperatureController::class, 'recent']);
Route::get('/rms/temperature/aggregate', [App\Http\Controllers\RMS\TemperatureController::class, 'aggregate']);
Route::get('/rms/temperature/events', [App\Http\Controllers\RMS\TemperatureController::class, 'events']);
Route::get('/rms/temperature/critical-sites', [App\Http\Controllers\RMS\TemperatureController::class, 'criticalSites']);

Route::get('/mileage/list', [App\Http\Controllers\Api\Position\MileageController::class, 'list']);
Route::get('/poi/nearest', [App\Http\Controllers\Api\Poi\PoiController::class, 'nearest']);
Route::get('/location/history', [App\Http\Controllers\Api\Position\TrackingController::class, 'history']);
Route::get('/location/latest', [App\Http\Controllers\Api\Position\TrackingController::class, 'latest']);

Route::group(['middleware' => ['auth:api', 'account', 'engage']], function() {
    Route::get('/poi/list', [App\Http\Controllers\Api\Poi\PoiController::class, 'index']);
    Route::get('/poi/check/update', [App\Http\Controllers\Api\Poi\PoiController::class, 'check']);

    Route::post('/customer/logout', [App\Http\Controllers\Api\Auth\AuthController::class, 'logout']);
    Route::post('/bind/token', [App\Http\Controllers\Api\User\NotificationController::class, 'bind']);

    Route::post('/test/sms', [App\Http\Controllers\Test\NotificationController::class, 'sms']);
    Route::post('/test/noti', [App\Http\Controllers\Test\NotificationController::class, 'noti']);
    Route::post('/test/one-signal', [App\Http\Controllers\Test\NotificationController::class, 'onesignal']);

    Route::get('/district/list', [App\Http\Controllers\Api\GeoFence\DistrictController::class, 'index']);
    Route::get('/thana/list/{district}', [App\Http\Controllers\Api\GeoFence\ThanaController::class, 'index']);
    Route::get('/fence/list/{thana}', [App\Http\Controllers\Api\GeoFence\FenceController::class, 'index']);
    Route::post('/fence/toggle', [App\Http\Controllers\Api\GeoFence\FenceController::class, 'toggle']);

    Route::get('/fence/history/{id}', [App\Http\Controllers\Api\GeoFence\FenceLogController::class, 'index']);
    Route::post('/fence/save', [App\Http\Controllers\Api\GeoFence\FenceController::class, 'save']);
    Route::post('/fence/add', [App\Http\Controllers\Api\GeoFence\FenceLogController::class, 'save']);
    Route::post('/fence/delete', [App\Http\Controllers\Api\GeoFence\FenceController::class, 'delete']);

    // Route::get('/poi/check/update/test', [App\Http\Controllers\Api\Poi\PoiController::class, 'test']);

    Route::get('/event/list/{car}', [App\Http\Controllers\Api\Car\EventController::class, 'events']);
    Route::get('/event/list/test/{car}', [App\Http\Controllers\Api\Car\EventController::class, 'test']);

    Route::get('/car/last/position/{id}', [App\Http\Controllers\Api\Position\TrackingController::class, 'last']);

    Route::get('/billing/status', [App\Http\Controllers\Api\Account\BillingController::class, 'status']);
    Route::get('/payment/paymentlist/{userId}', [App\Http\Controllers\Payment\PaymentController::class, 'index']);
    Route::get('/payment/due/{userId}', [App\Http\Controllers\Payment\PaymentController::class, 'getDue']);
    Route::get('/user/ref/{userId}', [App\Http\Controllers\Payment\PaymentController::class, 'getRefNo']);

    Route::get('/settings/status', [App\Http\Controllers\Api\Account\SettingsController::class, 'status']);
    Route::post('/settings/toggle', [App\Http\Controllers\Api\Account\SettingsController::class, 'toggle']);

    Route::post('/lock/status/toggle', [App\Http\Controllers\Api\Device\EngineController::class, 'toggle']);
    Route::post('/control/status/toggle', [App\Http\Controllers\Api\Device\EngineController::class, 'updateControlState']);
    Route::get('/lock/transition/status', [App\Http\Controllers\Api\Device\EngineController::class, 'transitionStatus']);

    Route::get('/noti/test/{id}', [App\Http\Controllers\Api\User\NotificationController::class, 'test']);

    Route::get('/gas/latest/{id}', [App\Http\Controllers\Service\GasController::class, 'latest']);
    Route::get('/gas/history/{id}', [App\Http\Controllers\Service\GasController::class, 'archive']);
    Route::get('/gas/history/{id}/{days}', [App\Http\Controllers\Service\GasController::class, 'history']);
    Route::get('/fuel/latest/{id}', [App\Http\Controllers\Service\FuelController::class, 'latest']);
    Route::get('/fuel/history/{id}/{days}', [App\Http\Controllers\Service\FuelController::class, 'history']);
    Route::get('/fuel/history/{days}', [App\Http\Controllers\Service\FuelController::class, 'archive']);
    Route::get('/mileage/history/{id}', [App\Http\Controllers\Service\MileageController::class, 'archive']);
    Route::get('/mileage/history/{carId}/{days}', [App\Http\Controllers\Service\MileageController::class, 'records']);

    Route::get('/trip/report/{id}/{days}', [App\Http\Controllers\Bus\TripController::class, 'report']);
    Route::get('/trip/details/{id}/{day}', [App\Http\Controllers\Bus\TripController::class, 'details']);

    Route::post('/set/current/car', [App\Http\Controllers\Api\Account\SettingsController::class, 'test']);

    Route::get('/get/car/dates/{id}', [App\Http\Controllers\Api\Car\CarController::class, 'dates']);
    Route::post('/update/car/dates', [App\Http\Controllers\Api\Car\CarController::class, 'update']);
    Route::post('/update/calibration', [App\Http\Controllers\Input\GasRefuelInputController::class, 'setPriceFactorByUser']);
    Route::post('/fuel/calibration/input', [App\Http\Controllers\Input\FuelCalibrationInputController::class, 'store']);
    Route::post('/device/phone', [App\Http\Controllers\Device\DeviceController::class, 'getPhone']);

    // New API developed for Android App migration by PALATOK
    Route::post('/session/register', [App\Http\Controllers\Api\Account\SessionController::class, 'register']);
    Route::post('/session/logout', [App\Http\Controllers\Api\Account\SessionController::class, 'logout']);

    Route::get('/device/config', [App\Http\Controllers\Api\Device\ConfigController::class, 'fetch']);
});
