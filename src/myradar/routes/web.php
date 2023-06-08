<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Rout23.823415, 90.371000es
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//routes for testing purposes

Route::group(['middleware' => ['auth']], function() {
    Route::get('/testmileage', [App\Http\Controllers\Test\MileageTestController::class, 'show']);
    Route::get('/gasfilter', [App\Http\Controllers\Test\GasFilterController::class, 'show']);
    Route::get('/insertbill', [App\Http\Controllers\Test\BillInsertController::class, 'populate']);
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');
Route::get('/landing-dev', [App\Http\Controllers\HomeController::class, 'welcomeDev']);
Route::get('/fuel-meter', [App\Http\Controllers\HomeController::class, 'fuelMeter'])->name('fuel-meter');
Route::get('/archive', function() {
    return view('landing.welcome');
});

Route::post('/test', [App\Http\Controllers\Auth\CustomLoginController::class,'login'])->name('test');
Auth::routes();


Route::get('/enroll', [App\Http\Controllers\Promotion\CampaignController::class, 'bikroy']);
Route::get('/eheater', [App\Http\Controllers\Promotion\CampaignController::class, 'eheater']);
Route::post('/enroll/save', [App\Http\Controllers\Promotion\CampaignController::class, 'enroll']);

Route::post('/login', [App\Http\Controllers\Auth\CustomLoginController::class, 'login']);
Route::get('/logout', [App\Http\Controllers\Auth\CustomLoginController::class, 'logout']);
Route::get('/forgetPassword', [App\Http\Controllers\Auth\CustomLoginController::class, 'getUserName']);
Route::get('/password/setNewPassword', [App\Http\Controllers\Auth\CustomLoginController::class, 'setNewPassword'])->name('setNewPassword');
Route::post('/password/newPassword', [App\Http\Controllers\Auth\CustomLoginController::class, 'newPassword']);

Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/car/tracking', [App\Http\Controllers\Customer\PositionController::class, 'show'])->name('car-tracking');
    Route::get('/car/positions/{deviceId}/{start}/{finish}/{skip}', [App\Http\Controllers\Customer\PositionHistoryController::class, 'getPositions']);
});


Route::get('/privacy-policy', [App\Http\Controllers\HomeController::class, 'privacy']);
Route::get('/terms-of-service', [App\Http\Controllers\HomeController::class, 'privacy']);

Route::post('/emergency/restore', [App\Http\Controllers\Test\DatabaseTestController::class, 'restore']);
Route::post('/emergency/restore2', [App\Http\Controllers\Test\DatabaseTestController::class, 'restore2']);
Route::post('/emergency/restore3', [App\Http\Controllers\Test\DatabaseTestController::class, 'restore3']);
Route::post('/emergency/patch', [App\Http\Controllers\Test\DatabaseTestController::class, 'patch']);
Route::get('/emergency/demo-patch', [App\Http\Controllers\Test\DatabaseTestController::class, 'demoPatch']);
Route::get('/test/demo-user', [App\Http\Controllers\Test\DatabaseTestController::class, 'demoUser']);
Route::get('/test/demo/vessel', [App\Http\Controllers\Test\DemoController::class, 'vessel']);
Route::get('/test/demo/password-reset', [App\Http\Controllers\Test\DemoController::class, 'resetPassword']);
Route::get('/test/microservice/geofence', [App\Http\Controllers\Test\MicroServiceController::class, 'testGeofence']);
Route::get('/test/microservice/session', [App\Http\Controllers\Test\MicroServiceController::class, 'session']);
Route::get('/test/microservice/device', [App\Http\Controllers\Test\MicroServiceController::class, 'deviceConfig']);
Route::get('/test/microservice/speed', [App\Http\Controllers\Test\MicroServiceController::class, 'speed']);
Route::get('/test/microservice/mileage', [App\Http\Controllers\Test\MicroServiceController::class, 'mileage']);
Route::get('/test/microservice/sms', [App\Http\Controllers\Test\MicroServiceController::class, 'testSms']);
Route::get('/test/microservice/engine', [App\Http\Controllers\Test\MicroServiceController::class, 'testEngineNotification']);
Route::get('/test/speed/diagnose', [App\Http\Controllers\Test\SpeedLimitController::class, 'diagnose']);
Route::get('/test/fuel-events', [App\Http\Controllers\Test\FuelMeterController::class, 'test']);
Route::get('/test/mileage-push', [App\Http\Controllers\Test\NotificationController::class, 'testMileagePush']);
Route::post('/test/websocket', [App\Http\Controllers\Test\SocketController::class, 'send']);
Route::get('/test/redis', [App\Http\Controllers\Test\DatabaseTestController::class, 'redis']);
Route::get('/test/noti', [App\Http\Controllers\Test\NotificationController::class, 'noti']);
Route::get('/test/bill-notice', [App\Http\Controllers\Promotion\NoticeController::class, 'test']);
Route::get('/test/activation-cleanup', [App\Http\Controllers\Admin\ActivationController::class, 'cleanup']);
Route::get('/test/sms', [App\Http\Controllers\Test\NotificationController::class, 'sms']);
Route::get('/test/last-pos', [App\Http\Controllers\Test\DatabaseTestController::class, 'lastPost']);

Route::get('/online-payment/checkout', [App\Http\Controllers\Payment\GatewayController::class, 'show']);
Route::post('/online-payment/success', [App\Http\Controllers\Payment\GatewayController::class, 'success']);
Route::post('/online-payment/fail', [App\Http\Controllers\Payment\GatewayController::class, 'fail']);
Route::post('/online-payment/cancel', [App\Http\Controllers\Payment\GatewayController::class, 'cancel']);

Route::get('/test/geofence/read-cache', [App\Http\Controllers\Test\GeofenceController::class, 'testCacheRead']);
Route::get('/test/geofence/write-cache', [App\Http\Controllers\Test\GeofenceController::class, 'testCacheWrite']);
Route::get('/test/bill', [App\Http\Controllers\Test\BillInsertController::class, 'test']);
Route::get('/test/remove', [App\Http\Controllers\Test\DatabaseTestController::class, 'remove']);
Route::get('/test/throttle', [App\Http\Controllers\Test\DatabaseTestController::class, 'throttle']);
Route::get('/test/notice', [App\Http\Controllers\Promotion\NoticeController::class, 'lastMonthDue']);
Route::any('/test/speed-noti', [App\Http\Controllers\Test\SpeedLimitController::class, 'noti']);
Route::any('/test/push-noti', [App\Http\Controllers\Test\PushNotificationController::class, 'test']);
Route::any('/test/engine-noti', [App\Http\Controllers\Test\EngineStatusController::class, 'noti']);

Route::get('/test/jt808/lock', [App\Http\Controllers\Test\JT808Controller::class, 'lock']);
Route::get('/test/jt808/unlock', [App\Http\Controllers\Test\JT808Controller::class, 'unlock']);
Route::get('/test/jt808/status', [App\Http\Controllers\Test\JT808Controller::class, 'status']);

Route::get('/test/bkash', [App\Http\Controllers\Test\BkashController::class, 'test']);
Route::post('/test/bkash', [App\Http\Controllers\Test\BkashController::class, 'test']);

Route::post('/test/gp33/lock', [App\Http\Controllers\Test\GP33Controller::class, 'test']);
Route::post('/test/concox/lock', [App\Http\Controllers\Test\ConcoxController::class, 'lock']);
Route::post('/test/concox/unlock', [App\Http\Controllers\Test\ConcoxController::class, 'unlock']);
Route::get('/test/concox/status', [App\Http\Controllers\Test\ConcoxController::class, 'status']);

Route::post('/test/excel-import', [App\Http\Controllers\Test\ExcelController::class, 'testImport']);
Route::any('/concox/test', [App\Http\Controllers\Test\ConcoxController::class, 'receive']);

 //Bkash Checkout URL

Route::get('/p/{uId}', [App\Http\Controllers\Payment\BkashCheckoutURLController::class, 'amount'])->name('url-amount');
Route::post('/bkash/pay', [App\Http\Controllers\Payment\BkashCheckoutURLController::class, 'payment'])->name('url-pay');
Route::post('/bkash/create', [App\Http\Controllers\Payment\BkashCheckoutURLController::class, 'createPayment'])->name('url-create')->middleware(['checkout_url_jwt']);
Route::get('/bkash/callback/{uId}', [App\Http\Controllers\Payment\BkashCheckoutURLController::class, 'callback'])->name('url-callback')->middleware(['checkout_url_jwt']);

// Private Customer

Route::group(['middleware' => ['auth', 'role:4', 'customer:1']], function() {

    /**
     * APIs for car tracking
     */
    Route::get('/user/device/ids/{userId}', [\App\Http\Controllers\Customer\DeviceController::class, 'devices']);

    Route::get('/refuel/log', [\App\Http\Controllers\Calibration\RefuelFeedController::class, 'customer'])->name('refuel-feed');
    Route::post('/refuel/feed/save', [\App\Http\Controllers\Calibration\RefuelFeedController::class, 'store']);

    Route::get('/checkout-iframe/success', [\App\Http\Controllers\Payment\CheckoutIFrameController::class, 'success']);
    Route::get('/checkout-iframe/fail', [\App\Http\Controllers\Payment\CheckoutIFrameController::class, 'fail']);

    Route::get('/checkout-iframe/amount', [\App\Http\Controllers\Payment\CheckoutIFrameController::class, 'amount']);
    Route::get('/checkout-iframe/grant', [\App\Http\Controllers\Payment\CheckoutIFrameController::class, 'grant']);
    Route::get('/checkout-iframe/refresh', [\App\Http\Controllers\Payment\CheckoutIFrameController::class, 'refresh']);
    Route::post('/checkout-iframe/pay', [\App\Http\Controllers\Payment\CheckoutIFrameController::class, 'pay']);
    Route::post('/checkout-iframe/create', [\App\Http\Controllers\Payment\CheckoutIFrameController::class, 'create'])->middleware(['checkout_iframe_jwt']);
    Route::post('/checkout-iframe/execute', [\App\Http\Controllers\Payment\CheckoutIFrameController::class, 'execute'])->middleware(['checkout_iframe_jwt']);
    Route::get('/checkout-iframe/query', [\App\Http\Controllers\Payment\CheckoutIFrameController::class, 'query'])->middleware(['checkout_iframe_jwt']);
    Route::get('/checkout-iframe/search', [\App\Http\Controllers\Payment\CheckoutIFrameController::class, 'search'])->middleware(['checkout_iframe_jwt']);
    Route::get('/checkout-iframe/refund', [\App\Http\Controllers\Payment\CheckoutIFrameController::class, 'refund'])->middleware(['checkout_iframe_jwt']);

});


Route::get('/concox/lock/test', [App\Http\Controllers\Device\ConcoxController::class, 'test']);


// TODO: remove these with backwawrd check
// Private Customer API
// Route::group(['middleware' => ['querylog']], function() {
    Route::post('/api/fuelHistories', [App\Http\Controllers\Api\Device\HistoryAPIController::class, 'fuel_histories']);
Route::post('/api/gasHistories', [App\Http\Controllers\Api\Device\HistoryAPIController::class, 'gas_histories']);
Route::post('/api/getFuelGasLevel', [App\Http\Controllers\Api\Device\HistoryAPIController::class, 'getFuelGasLevel']);
Route::get('/api/event/recent/{id}', [App\Http\Controllers\Car\EventController::class, 'recent']);

// });

// Enterprise
Route::group(['middleware' => ['auth', 'role:4', 'customer:2']], function() {
    Route::get('/enterprise/demo-modules', function() {
        return view('enterprise.modules');
    });

    Route::get('/generators', [App\Http\Controllers\Enterprise\GeneratorController::class, 'index'])->name('generators');
    Route::get('/generator/list', [App\Http\Controllers\Enterprise\GeneratorController::class, 'all']);

    Route::get('/enterprise/car/list/{id}', [App\Http\Controllers\Enterprise\CarController::class, 'all']);

    Route::get('/driver/manage', [App\Http\Controllers\Enterprise\DriverController::class, 'manage'])->name('drivers');
    Route::get('/driver/list/{id}', [App\Http\Controllers\Enterprise\DriverController::class, 'index']);
    Route::post('/driver/save', [App\Http\Controllers\Enterprise\DriverController::class, 'save']);
    Route::post('/driver/update', [App\Http\Controllers\Enterprise\DriverController::class, 'update']);
    Route::post('/driver/delete', [App\Http\Controllers\Enterprise\DriverController::class, 'delete']);

    Route::post('/driver/assign', [App\Http\Controllers\Enterprise\AssignmentController::class, 'save']);
    Route::post('/driver/assignmentList/{id}', [App\Http\Controllers\Enterprise\AssignmentController::class, 'all']);

    Route::get('/employee/manage', [App\Http\Controllers\Enterprise\EmployeeController::class, 'manage'])->name('employees');
    Route::get('/employee/list/{id}', [App\Http\Controllers\Enterprise\EmployeeController::class, 'index']);
    Route::post('/employee/save', [App\Http\Controllers\Enterprise\EmployeeController::class, 'save']);
    Route::post('/employee/update', [App\Http\Controllers\Enterprise\EmployeeController::class, 'update']);
    Route::post('/employee/delete', [App\Http\Controllers\Enterprise\EmployeeController::class, 'delete']);

    Route::get('/driving/hour', [App\Http\Controllers\Enterprise\DrivingController::class, 'show'])->name('driving-hour');
    Route::get('/driving/hour/sum/{id}', [App\Http\Controllers\Enterprise\DrivingController::class, 'sum']);
    Route::get('/driving/hour/report/{id}', [App\Http\Controllers\Enterprise\DrivingController::class, 'report']);
    Route::get('/driving/hour/export', [App\Http\Controllers\Enterprise\DrivingController::class, 'export']);

    Route::get('/duty/hour', [App\Http\Controllers\Enterprise\DutyController::class, 'show'])->name('duty-hour');
    Route::get('/duty/hour/sum/{id}', [App\Http\Controllers\Enterprise\DutyController::class, 'sum']);
    Route::get('/duty/hour/report/{id}', [App\Http\Controllers\Enterprise\DutyController::class, 'report']);
    Route::get('/duty/hour/export', [App\Http\Controllers\Enterprise\DutyController::class, 'export_v2']);

    Route::get('/mileage/report', [App\Http\Controllers\Enterprise\MileageController::class, 'show'])->name('mileage-report');
    Route::get('/mileage/sum/{id}', [App\Http\Controllers\Enterprise\MileageController::class, 'sum']);
    Route::get('/mileage/report/{id}', [App\Http\Controllers\Enterprise\MileageController::class, 'report']);
    Route::get('/mileage/export', [App\Http\Controllers\Enterprise\MileageController::class, 'export']);

    Route::get('/tail/report', [App\Http\Controllers\Enterprise\TailController::class, 'show'])->name('tail-report');

    Route::get('/text/tracker', [App\Http\Controllers\Enterprise\TextTrackerController::class, 'show'])->name('text-tracker');

    Route::get('/map/search', [App\Http\Controllers\Enterprise\MapController::class, 'show'])->name('map-search');
    Route::get('/zone/car/list/{id}', [App\Http\Controllers\Enterprise\MapController::class, 'cars']);
    Route::get('/car/current/assignment/{id}', [App\Http\Controllers\Enterprise\AssignmentController::class, 'current']);

    Route::get('/text/tracker', [App\Http\Controllers\Enterprise\TextTrackerController::class, 'show'])->name('text-tracker');
    Route::get('/text/text-tracker/location/list/{carId}', [App\Http\Controllers\Enterprise\TextTrackerController::class, 'locations']);
    Route::get('/text/text-tracker/car/list/{userId}', [App\Http\Controllers\Enterprise\VehicleController::class, 'all'])->name('text-tracker-car-list');
    Route::get('/text/text-tracker/thana/list/{district}', [App\Http\Controllers\Enterprise\TextTrackerController::class, 'thanalist']);
    Route::get('/text/driver/assignment/info/{driverId}', [App\Http\Controllers\Enterprise\TextTrackerController::class, 'assignmentInfo']);

    Route::get('/enterprise/car/tracking', [App\Http\Controllers\Car\TrackingController::class, 'show']);
    Route::get('/enterprise/car/route/{id}', [App\Http\Controllers\Enterprise\TrackingController::class, 'route']);

    Route::get('/enterprise/settings', [App\Http\Controllers\Enterprise\SettingsController::class, 'show'])->name('enterprise-settings');
    Route::get('/enterprise/settings/{userId}/{carId}', [App\Http\Controllers\Enterprise\SettingsController::class, 'view']);
    Route::post('/enterprise/settings/change', [App\Http\Controllers\Enterprise\SettingsController::class, 'change']);

    Route::get('enterprise/fence/list/{id}', [App\Http\Controllers\Api\GeoFence\FenceController::class, 'enterpriseIndex']);
    Route::post('/fence/save', [App\Http\Controllers\Api\GeoFence\FenceController::class, 'save']);
    Route::post('/fence/delete', [App\Http\Controllers\Api\GeoFence\FenceController::class, 'delete']);
});


// Admin
Route::group(['middleware' => ['auth', 'role:1']], function() {
    Route::get('/users', [App\Http\Controllers\User\UserController::class, 'index']);
    Route::get('/user/details/{id}', [App\Http\Controllers\User\UserController::class, 'show']);
    Route::get('/user/create', [App\Http\Controllers\User\UserController::class, 'create']);
    Route::post('/user/save', [App\Http\Controllers\User\UserController::class, 'save']);
    Route::get('/user/edit/{id}', [App\Http\Controllers\User\UserController::class, 'edit']);
    Route::post('/user/update', [App\Http\Controllers\User\UserController::class, 'update']);
    Route::get('/user/activate/{id}', [App\Http\Controllers\User\UserController::class, 'activate']);
    Route::get('/user/deactivate/{id}', [App\Http\Controllers\User\UserController::class, 'deactivate']);

    Route::get('/billing/report', [App\Http\Controllers\Admin\BillingController::class, 'index']);
    //Route::get('/billing/export', [App\Http\Controllers\Admin\BillingController::class, 'export']);
    Route::get('/billing/drilldown', [App\Http\Controllers\Admin\BillingController::class, 'drilldown']);

    Route::get('/activation/report', [App\Http\Controllers\Admin\ActivationController::class, 'index'])->name('activation.report');
    Route::post('/activation/export', [App\Http\Controllers\Admin\ActivationController::class, 'export']);
    Route::post('/activation/batch/disable', [App\Http\Controllers\Admin\ActivationController::class, 'batchDisable']);

    Route::get('/devices', [App\Http\Controllers\Device\DeviceController::class, 'index'])->name('devices');
    Route::get('/device/newid', [App\Http\Controllers\Device\DeviceController::class, 'generateId']);

    Route::get('/device/bind/history', [App\Http\Controllers\Device\DeviceController::class, 'bindHistory'])->name('bind.history');
    Route::get('/device/bind/export', [App\Http\Controllers\Device\DeviceController::class, 'bindExport']);

    Route::post('/device/create', [App\Http\Controllers\Device\DeviceController::class, 'save']);
    Route::get('/devices/recent/{skip}', [App\Http\Controllers\Device\DeviceController::class, 'recent']);
    Route::get('/devices/print/recent', [App\Http\Controllers\Device\DeviceController::class, 'print']);
    Route::get('/devices/export', [App\Http\Controllers\Device\DeviceController::class, 'export']);
    Route::post('/device/update/version', [App\Http\Controllers\Device\DeviceController::class, 'updateVersion']);

    Route::get('/bus/routes', [App\Http\Controllers\Bus\RouteController::class, 'index']);
    Route::get('/bus/company/names', [App\Http\Controllers\Bus\RouteController::class, 'companies']);
    Route::get('/bus/list/{id}', [App\Http\Controllers\Bus\RouteController::class, 'buses']);
    Route::post('/bus/route/save', [App\Http\Controllers\Bus\RouteController::class, 'save']);
    Route::post('/bus/route/delete', [App\Http\Controllers\Bus\RouteController::class, 'delete']);

    Route::get('/payment/message', [App\Http\Controllers\Payment\PaymentController::class, 'sendAll']);
    Route::get('/payment/method/sms', [App\Http\Controllers\Payment\PaymentController::class, 'sendMethodAll']);

    Route::get('/promotion', [App\Http\Controllers\Promotion\PromotionController::class, 'index']);
    Route::post('/save/scheme', [App\Http\Controllers\Promotion\PromotionController::class, 'save']);
    Route::get('/customer/ids', [App\Http\Controllers\User\CustomerController::class, 'getIds']);

    Route::get('/due/notice', [App\Http\Controllers\Promotion\NoticeController::class, 'dueNotice'])->name('due-notice');
    Route::post('/clear/due/notice', [App\Http\Controllers\Promotion\NoticeController::class, 'clear']);
    Route::post('/send/single/notice', [App\Http\Controllers\Promotion\NoticeController::class, 'sendSingleNotice']);
    Route::post('/send/due/notice', [App\Http\Controllers\Promotion\NoticeController::class, 'sendDueNotice']);

    Route::get('/export/due/notice/{via}', [App\Http\Controllers\Promotion\NoticeController::class, 'exportDueNotice']);
});

// int ops
Route::group(['middleware' => ['auth', 'role:3']], function() {
    Route::post('/service/api/get_service_diagnosis', [App\Http\Controllers\Service\ServiceApiController::class, 'get_service_diagnosis']);

    Route::get('/service-monitor', [App\Http\Controllers\ServiceMonitor\ServiceMonitorController::class, 'show']);
    Route::get('/user/devices/{id}', [App\Http\Controllers\Device\DeviceController::class, 'allOfUser']);

    Route::post('/device/update/phone', [App\Http\Controllers\Device\DeviceController::class, 'changePhone']);

    Route::get('/services/api', [App\Http\Controllers\Service\ServiceApiController::class, 'index']);
    Route::post('/services/api/update', [App\Http\Controllers\Service\ServiceApiController::class, 'update']);

    Route::get('/fuel/calibration/log/{id}', [App\Http\Controllers\Calibration\FuelCalibrationController::class, 'index']);
    Route::get('/user/fuel/calibration/log/{id}', [App\Http\Controllers\Input\FuelCalibrationInputController::class, 'userData']);
    Route::post('/fuel/calibration/save', [App\Http\Controllers\Calibration\FuelCalibrationController::class, 'store']);
    Route::post('/fuel/calibration/delete', [App\Http\Controllers\Calibration\FuelCalibrationController::class, 'remove']);

    Route::get('/gas/calibration/log/{id}', [App\Http\Controllers\Calibration\GasCalibrationController::class, 'index']);
    Route::get('/gas/calibration/min/{id}', [App\Http\Controllers\Calibration\GasCalibrationController::class, 'getGasMin']);
    Route::get('/gas/calibration/min/save/{carId}/{gasMin}', [App\Http\Controllers\Calibration\GasCalibrationController::class, 'setGasMin']);
    Route::post('/gas/calibration/save', [App\Http\Controllers\Calibration\GasCalibrationController::class, 'store']);
    Route::post('/gas/calibration/delete', [App\Http\Controllers\Calibration\GasCalibrationController::class, 'remove']);
    Route::get('/gas/refuel/input/{id}', [App\Http\Controllers\Calibration\GasCalibrationController::class, 'refuelInput']);

    Route::get('/car/meta-data/find/{id}', [App\Http\Controllers\Calibration\MetaDataController::class, 'show']);
    Route::get('/car/meta-data/find/price/tune/{id}', [App\Http\Controllers\Calibration\MetaDataController::class, 'showpricetune']);
    Route::post('/car/meta-data/update', [App\Http\Controllers\Calibration\MetaDataController::class, 'update']);
    Route::post('/car/meta-data/tune/update', [App\Http\Controllers\Calibration\MetaDataController::class, 'updatepricetune']);

    Route::get('/vehicles', [App\Http\Controllers\Car\CarController::class, 'index']);
    Route::get('/vehicles/search', [App\Http\Controllers\Car\CarController::class, 'search']);
    Route::get('/vehicles/export', [App\Http\Controllers\Car\CarController::class, 'export']);

    Route::get('unhealthy/device', [App\Http\Controllers\Device\PerformanceController::class, 'unhealthy']);
});


// customer care
Route::group(['middleware' => ['auth', 'role:2']], function() {
    Route::get('/billing/export', [App\Http\Controllers\Admin\BillingController::class, 'export']);
    Route::get('/payment/paymentlist/{userId}', [App\Http\Controllers\Payment\PaymentController::class, 'index']);
    Route::get('/payment/message/{userId}', [App\Http\Controllers\Payment\PaymentController::class, 'getMsgContent']);
    Route::get('/payment/total-due/{userId}', [App\Http\Controllers\Payment\PaymentController::class, 'totalDue']);
    Route::post('/payment/sms/send', [App\Http\Controllers\Payment\PaymentController::class, 'send']);
    Route::get('/payment/method/sms/{userId}', [App\Http\Controllers\Payment\PaymentController::class, 'sendMethod']);
    Route::post('/save/payment', [App\Http\Controllers\Payment\PaymentController::class, 'save']);
    Route::get('/get/payments/{userId}', [App\Http\Controllers\Payment\PaymentController::class, 'getPayments']);

    Route::post('/promotion/notification', [App\Http\Controllers\Promotion\PromotionController::class, 'notification']);
    Route::get('/promotion/schemelist', [App\Http\Controllers\Promotion\PromotionController::class, 'show']);
    Route::get('/promo/code/list', [App\Http\Controllers\Promotion\PromoCodeController::class, 'show']);
    Route::get('/generate/promo', [App\Http\Controllers\Promotion\PromoCodeController::class, 'generate']);
    Route::post('/save/promo', [App\Http\Controllers\Promotion\PromoCodeController::class, 'save']);

    Route::get('/bkash/allbill', [App\Http\Controllers\Payment\BkashCheckoutURLController::class, 'allBkashBill'])->name('bkash-pgw-bill');
    Route::get('/billing', [App\Http\Controllers\Account\BillingController::class, 'index'])->name('billing');

    Route::get('/bkash/refund', [App\Http\Controllers\Payment\BkashCheckoutURLController::class, 'getRefund'])->name('url-refund')->middleware(['checkout_url_jwt']);
    Route::post('/bkash/post-refund', [App\Http\Controllers\Payment\BkashCheckoutURLController::class, 'refundPayment'])->name('url-post-refund')->middleware(['checkout_url_jwt']);


    Route::get('/bill/entry', [App\Http\Controllers\Finance\BillingController::class, 'entry']);
    Route::post('/importExcel', [App\Http\Controllers\Account\BillingController::class, 'importExcel']);

    Route::get('/find/customer/{phone}', [App\Http\Controllers\User\CustomerController::class, 'findByPhone']);

    Route::get('/customers', [App\Http\Controllers\User\CustomerController::class, 'index'])->name('all-customers');
    Route::post('/customer/save', [App\Http\Controllers\User\CustomerController::class, 'save']);
    Route::post('/customer/update', [App\Http\Controllers\User\CustomerController::class, 'update']);
    Route::post('/customer/password/change', [App\Http\Controllers\User\CustomerController::class, 'password']);
    Route::get('/customer/toggle-history/{id}', [App\Http\Controllers\User\CustomerController::class, 'toggleHistory']);

    Route::get('/customer/session/list', [App\Http\Controllers\Customer\SessionController::class, 'all']);
    Route::post('/customer/session/remove', [App\Http\Controllers\Customer\SessionController::class, 'remove']);
    Route::post('/customer/session/logout', [App\Http\Controllers\Customer\SessionController::class, 'logout']);

    Route::get('/customer/settings/{id}', [App\Http\Controllers\Api\Account\SettingsController::class, 'view']);
    Route::post('/customer/settings/change', [App\Http\Controllers\Api\Account\SettingsController::class, 'change']);

    Route::get('/messages', [App\Http\Controllers\Contact\MessageController::class, 'index']);

    Route::get('/car/everything', [App\Http\Controllers\Car\CarController::class, 'everything']);
    Route::get('/car/speed-limit/get/{id}', [App\Http\Controllers\Car\SpeedController::class, 'show']);
    Route::post('/car/speed-limit/update', [App\Http\Controllers\Car\SpeedController::class, 'update']);

    Route::post('/zone/save', [App\Http\Controllers\Enterprise\ZoneController::class, 'store']);
    Route::post('/zone/delete', [App\Http\Controllers\Enterprise\ZoneController::class, 'delete']);

    Route::get('/share/user/search', [App\Http\Controllers\Enterprise\ShareController::class, 'search']);
    Route::get('/share/shared/users', [App\Http\Controllers\Enterprise\ShareController::class, 'shared']);
    Route::post('/share/provide/access', [App\Http\Controllers\Enterprise\ShareController::class, 'provide']);
    Route::post('/share/revoke/access', [App\Http\Controllers\Enterprise\ShareController::class, 'revoke']);

    Route::get('/leads', [App\Http\Controllers\Promotion\CampaignController::class, 'leads']);
    Route::get('/lead/assignment', [App\Http\Controllers\Promotion\CampaignController::class, 'leadAssignment']);
    Route::post('/lead/assignment/save', [App\Http\Controllers\Promotion\CampaignController::class, 'saveAssignment']);
    Route::post('/lead/assignment/remove', [App\Http\Controllers\Promotion\CampaignController::class, 'removeAssignment']);

    Route::get('/activity/login/stats/{id}', [App\Http\Controllers\Admin\EngagementController::class, 'login']);
    Route::get('/activity/request/stats/{id}', [App\Http\Controllers\Admin\EngagementController::class, 'request']);

    Route::get('/engagement/report', [App\Http\Controllers\Admin\EngagementController::class, 'index']);
    Route::get('/engagement/export', [App\Http\Controllers\Admin\EngagementController::class, 'export']);
    Route::get('/engagement/smspack1-enabler', [App\Http\Controllers\Admin\EngagementController::class, 'smsPack1Enabler']);

    Route::get('/geofence/library', [App\Http\Controllers\Fence\AreaController::class, 'library']);
    Route::post('/geofence/update', [App\Http\Controllers\Fence\AreaController::class, 'update']);
    Route::post('/geofence/sync-subscriptions', [App\Http\Controllers\Fence\AreaController::class, 'syncSubscriptions']);
    Route::get('/geofence/fetch-subscriptions', [App\Http\Controllers\Fence\AreaController::class, 'fetchSubscriptions']);

    // Route::get('/fuel/seed-groups', [App\Http\Controllers\Service\FuelController::class, 'seedGroups']);
    Route::get('/fuel/fetch-groups', [App\Http\Controllers\Service\FuelController::class, 'fetchGroups']);

    Route::get('/rms/site/list', [App\Http\Controllers\RMS\SiteController::class, 'index']);
    Route::get('/rms/site/create', [App\Http\Controllers\RMS\SiteController::class, 'create']);
    Route::post('/rms/site/save', [App\Http\Controllers\RMS\SiteController::class, 'save']);
    Route::get('/rms/site/edit/{id}', [App\Http\Controllers\RMS\SiteController::class, 'edit']);
    Route::post('/rms/site/update', [App\Http\Controllers\RMS\SiteController::class, 'update']);
    Route::get('/rms/site/configure/{id}', [App\Http\Controllers\RMS\SiteController::class, 'configure']);

    Route::post('/rms/site/device/bind', [App\Http\Controllers\RMS\SiteController::class, 'bind']);
    Route::post('/rms/site/device/unbind', [App\Http\Controllers\RMS\SiteController::class, 'unbind']);

    Route::get('/rms/site/info', [App\Http\Controllers\RMS\SiteController::class, 'siteInfo']);
    Route::get('/rms/site/pin/fetch', [App\Http\Controllers\RMS\SiteController::class, 'fetchPinConfig']);
    Route::post('/rms/site/pin/save', [App\Http\Controllers\RMS\SiteController::class, 'savePinConfig']);
    Route::post('/rms/site/pin/update', [App\Http\Controllers\RMS\SiteController::class, 'updatePinConfig']);
    Route::post('/rms/site/pin/remove', [App\Http\Controllers\RMS\SiteController::class, 'removePinConfig']);
});


Route::post('/message/save', [App\Http\Controllers\Contact\MessageController::class, 'store'])->name('save-message')->middleware('cors');

Route::get('/fuel/latest/{id}', [App\Http\Controllers\Service\FuelController::class, 'latest']);
Route::get('/fuel/latestv2', [App\Http\Controllers\Service\FuelController::class, 'latestv2']);
Route::get('/fuel/history/{id}/{day}', [App\Http\Controllers\Service\FuelController::class, 'history']);
Route::get('/fuel/historyv2', [App\Http\Controllers\Service\FuelController::class, 'historyv2']);
Route::get('/gas/latest/{id}', [App\Http\Controllers\Service\GasController::class, 'latest']);
Route::get('/gas/history/{id}/{day}', [App\Http\Controllers\Service\GasController::class, 'history']);

Route::post('/customers/add/api', [App\Http\Controllers\User\CustomerApiController::class, 'add']); //int-ops
Route::post('/customers/delete/api', [App\Http\Controllers\User\CustomerApiController::class, 'delete']); //int-ops
Route::post('/customers/sendCredential/api', [App\Http\Controllers\User\CustomerApiController::class, 'sendCredential']); //int-ops
Route::post('/bind-services/api', [App\Http\Controllers\Service\ServiceApiController::class, 'bindWithComId']); //int-op

Route::get('/customer/vehicles/{id}', [App\Http\Controllers\Customer\PositionController::class, 'show']);
Route::get('/customer/vehicles/positions/{id}', [App\Http\Controllers\Customer\PositionController::class, 'devices']);

Route::get('/user/car/names/{userId}', [App\Http\Controllers\Customer\DeviceController::class, 'cars']);


Route::group(['middleware' => ['auth']], function () {
    Route::get('/customers/api', [App\Http\Controllers\User\CustomerApiController::class, 'index']);
    Route::get('/customer/types/api', [App\Http\Controllers\User\CustomerApiController::class, 'types']);
    Route::get('/customer/info/{id}', [App\Http\Controllers\Customer\ManageController::class, 'info']);
    Route::get('/customer/modules', [App\Http\Controllers\User\CustomerController::class, 'modules']);
    Route::get('/manage/customer/{id}', [App\Http\Controllers\User\CustomerController::class, 'manage'])->name('manage.customer');
    Route::get('/service/view', [App\Http\Controllers\Customer\ServiceController::class, 'show'])->name('service-view');

    Route::get('/service/log/{car}/{service}', [App\Http\Controllers\Service\ServiceLogController::class, 'history']);
    Route::get('/service/report/{car_id}', [App\Http\Controllers\Service\ServiceLogController::class, 'report']);

    // AJAX API
    Route::get('/user/account/info/{id}', [App\Http\Controllers\Customer\AccountController::class, 'info']);
    Route::post('/user/account/toggle', [App\Http\Controllers\Customer\AccountController::class, 'toggle']);
    Route::get('/user/car/list/{id}', [App\Http\Controllers\Car\CarController::class, 'all']);
    Route::get('/user/car/last-location', [App\Http\Controllers\Car\CarController::class, 'lastLocation']);

    Route::get('/car/details/{id}', [App\Http\Controllers\Car\CarController::class, 'show']);
    Route::post('/car/save', [App\Http\Controllers\Car\CarController::class, 'save']);
    Route::post('/car/update', [App\Http\Controllers\Car\CarController::class, 'update']);

    Route::get('/car/state/{id}', [App\Http\Controllers\Car\DeviceController::class, 'state']);
    Route::get('/car/packages', [App\Http\Controllers\Car\CarController::class, 'packages']);
    Route::get('/car/services/{id}', [App\Http\Controllers\Car\CarController::class, 'services']);
    Route::get('/car/toggle-status/{id}', [App\Http\Controllers\Car\CarController::class, 'toggleStatus']);

    Route::post('/car/bind/device', [App\Http\Controllers\Car\DeviceController::class, 'bind']);
    Route::post('/car/unbind/device', [App\Http\Controllers\Car\DeviceController::class, 'unbind']);
    Route::get('/service/data/status/{cid}/{sid}', [App\Http\Controllers\Car\DeviceController::class, 'status']);

    Route::post('/bind/token', [App\Http\Controllers\Api\User\NotificationController::class, 'bind']);
    Route::post('/check/subscription', [App\Http\Controllers\Api\User\NotificationController::class, 'checkSubscription']);
    // END

    Route::get('/mileage/records/{carId}/{days}', [App\Http\Controllers\Service\MileageController::class, 'records']);

    Route::get('/geofence/manage', [App\Http\Controllers\Fence\AreaController::class, 'index'])->name('area-fence');
    Route::post('/geofence/save', [App\Http\Controllers\Fence\AreaController::class, 'save']);
    Route::post('/geofence/subscribe', [App\Http\Controllers\Fence\AreaController::class, 'subscribe']);
    Route::post('/geofence/unsubscribe', [App\Http\Controllers\Fence\AreaController::class, 'unsubscribe']);
    Route::get('/geofence/fetch', [App\Http\Controllers\Fence\AreaController::class, 'fetch']);
    Route::get('/geofence/templates', [App\Http\Controllers\Fence\AreaController::class, 'templates']);
    Route::post('/geofence/attach/template', [App\Http\Controllers\Fence\AreaController::class, 'attachTemplate']);
    Route::post('/geofence/remove', [App\Http\Controllers\Fence\AreaController::class, 'remove']);
    Route::get('/geofence', [App\Http\Controllers\Fence\FenceController::class, 'index']);

    Route::get('/get/fence/log', [App\Http\Controllers\Fence\FenceLogController::class, 'index']);
    Route::get('/district/list', [App\Http\Controllers\Fence\DistrictController::class, 'index']);
    Route::get('/thana/list/{district}', [App\Http\Controllers\Fence\ThanaController::class, 'index']);
    Route::get('/fence/list/{thana}', [App\Http\Controllers\Fence\FenceController::class, 'items']);
    Route::post('/fence/toggle', [App\Http\Controllers\Fence\FenceController::class, 'toggle']);

    Route::get('/refuel/feed/log/{id}/{type?}', [App\Http\Controllers\Calibration\RefuelFeedController::class, 'all']);
    Route::get('/customer/data/{id}', [App\Http\Controllers\User\CustomerApiController::class, 'info']);
    Route::get('/customer/access/of/user', [App\Http\Controllers\Account\AccessController::class, 'customer']);
    Route::get('/message/access/of/user', [App\Http\Controllers\Account\AccessController::class, 'messageAccess']);

    Route::get('/change/password', [App\Http\Controllers\Auth\PasswordChangeController::class, 'change']);
    Route::post('/change/password', [App\Http\Controllers\Auth\PasswordChangeController::class, 'reset']);

    Route::get('/device/status/{id}', [App\Http\Controllers\Api\Device\EngineController::class, 'status']);
    Route::post('/lock/status/toggle', [App\Http\Controllers\Api\Device\EngineController::class, 'toggle']);

    Route::get('/event/list/{id}', [App\Http\Controllers\Car\EventController::class, 'index']);
    Route::get('/car/last/position/{deviceId}', [App\Http\Controllers\Customer\PositionHistoryController::class, 'getLastPosition']);

    Route::get('/zone/list/{id}', [App\Http\Controllers\Enterprise\ZoneController::class, 'index']);

    Route::get('/performance', [App\Http\Controllers\Device\PerformanceController::class, 'index']);
    Route::get('/performance/stats', [App\Http\Controllers\Device\PerformanceController::class, 'stats']);
    Route::get('/performance/items', [App\Http\Controllers\Device\PerformanceController::class, 'items']);

    Route::get('/lastpulse', [App\Http\Controllers\Device\LastPulseController::class, 'index']);
    Route::get('/lastpulse/stats', [App\Http\Controllers\Device\LastPulseController::class, 'stats']);
    Route::get('/lastpulse/items', [App\Http\Controllers\Device\LastPulseController::class, 'items']);
    Route::post('/lastpulse/update', [App\Http\Controllers\Device\LastPulseController::class, 'update']);

    Route::get('/complains', [App\Http\Controllers\ServiceMonitor\ComplainController::class, 'index']);
    Route::post('/save/complain', [App\Http\Controllers\ServiceMonitor\ComplainController::class, 'save']);
    Route::get('/complain/list', [App\Http\Controllers\ServiceMonitor\ComplainController::class, 'all']);
    Route::get('/complain/export', [App\Http\Controllers\ServiceMonitor\ComplainController::class, 'export']);
    Route::get('/complain/search', [App\Http\Controllers\ServiceMonitor\ComplainController::class, 'search']);
    Route::post('/complain/add/comment', [App\Http\Controllers\ServiceMonitor\ComplainController::class, 'change']);
});


Route::get('/tracking/report', [\App\Http\Controllers\Report\TrackingController::class, 'report']);
Route::get('/report/positions', [\App\Http\Controllers\Report\PositionController::class, 'show']);
Route::get('/report/positions/fetch', [\App\Http\Controllers\Report\PositionController::class, 'latest']);

Route::get('/tracking/history/{id}', [\App\Http\Controllers\Customer\PositionHistoryController::class, 'show']);
Route::get('/tracking/records/fetch', [\App\Http\Controllers\Customer\PositionHistoryController::class, 'history']);

// web hook routes

Route::post('/bkash/webhook', [\App\Http\Controllers\Admin\BkashWebhookController::class, 'PayloadReceiver']);
Route::get('/bkash/ipndata', [\App\Http\Controllers\Admin\BkashWebhookController::class, 'BkashWebhookView'])->name('bkash-webhook-view');




