<?php

use Illuminate\Support\Facades\Route;
use App\Models\bkash;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\Promotion\CampaignController;
use App\Http\Controllers\Report\PositionController;
use App\Http\Controllers\Customer\ServiceController;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Finance\BillingController as FinanceBillingController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\User\CustomerController;
use App\Http\Controllers\Customer\SessionController;
use App\Http\Controllers\Enterprise\SettingsController;
use App\Http\Controllers\Contact\MessageController;
use App\Http\Controllers\Car\CarController;
use App\Http\Controllers\Car\SpeedController;
use App\Http\Controllers\Test\MileageTestController;
use App\Http\Controllers\Test\GasFilterController;
use App\Http\Controllers\Test\BillInsertController;
use App\Http\Controllers\Test\DatabaseTestController;
use App\Http\Controllers\Test\DemoController;
use App\Http\Controllers\Test\MicroServiceController;
use App\Http\Controllers\Test\SpeedLimitController;
use App\Http\Controllers\Test\FuelMeterController;
use App\Http\Controllers\Test\NotificationController;
use App\Http\Controllers\Test\SocketController;
use App\Http\Controllers\Promotion\NoticeController;
use App\Http\Controllers\Admin\ActivationController;
use App\Http\Controllers\Test\GeofenceController;
use App\Http\Controllers\Test\PushNotificationController;
use App\Http\Controllers\Test\EngineStatusController;
use App\Http\Controllers\Test\JT808Controller;
use App\Http\Controllers\Test\BkashController;
use App\Http\Controllers\Test\GP33Controller;
use App\Http\Controllers\Test\ConcoxController;
use App\Http\Controllers\Test\ExcelController;
use App\Http\Controllers\Customer\DeviceController;
use App\Http\Controllers\Calibration\RefuelFeedController;
use App\Http\Controllers\Payment\CheckoutIFrameController;
use App\Http\Controllers\Api\Device\HistoryAPIController;
use App\Http\Controllers\Car\EventController;
use App\Http\Controllers\Enterprise\GeneratorController;
use App\Http\Controllers\Enterprise\DriverController;
use App\Http\Controllers\Enterprise\AssignmentController;
use App\Http\Controllers\Enterprise\EmployeeController;
use App\Http\Controllers\Enterprise\DrivingController;
use App\Http\Controllers\Enterprise\DutyController;
use App\Http\Controllers\Enterprise\MileageController;
use App\Http\Controllers\Enterprise\TailController;
use App\Http\Controllers\Enterprise\TextTrackerController;
use App\Http\Controllers\Enterprise\MapController;
use App\Http\Controllers\Enterprise\VehicleController;
use App\Http\Controllers\Car\TrackingController;
use App\Http\Controllers\Api\GeoFence\FenceController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Bus\RouteController;
use App\Http\Controllers\Promotion\PromotionController;
use App\Http\Controllers\Enterprise\ZoneController;
use App\Http\Controllers\Enterprise\ShareController;
use App\Http\Controllers\Admin\EngagementController;
use App\Http\Controllers\Fence\AreaController;
use App\Http\Controllers\Service\FuelController;
use App\Http\Controllers\RMS\SiteController;
use App\Http\Controllers\Service\ServiceApiController;
use App\Http\Controllers\ServiceMonitor\ServiceMonitorController;
use App\Http\Controllers\Calibration\FuelCalibrationController;
use App\Http\Controllers\Input\FuelCalibrationInputController;
use App\Http\Controllers\Calibration\GasCalibrationController;
use App\Http\Controllers\Calibration\MetaDataController;
use App\Http\Controllers\Service\GasController;
use App\Http\Controllers\User\CustomerApiController;
use App\Http\Controllers\Customer\ManageController;
use App\Http\Controllers\Service\ServiceLogController;
use App\Http\Controllers\Customer\AccountController;
use App\Http\Controllers\Fence\FenceLogController;
use App\Http\Controllers\Fence\DistrictController;
use App\Http\Controllers\Fence\ThanaController;
use App\Http\Controllers\Account\AccessController;
use App\Http\Controllers\Auth\PasswordChangeController;
use App\Http\Controllers\Api\Device\EngineController;
use App\Http\Controllers\Customer\PositionHistoryController;
use App\Http\Controllers\Device\PerformanceController;
use App\Http\Controllers\Device\LastPulseController;
use App\Http\Controllers\ServiceMonitor\ComplainController;
use App\Http\Controllers\Payment\BkashCheckoutURLController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/bkash', function () {
    $query = bkash::where('is_successful', false)->get();

    dd($query);
})->name('welcome');

// Route::get('/home', function() {
//   $lang = $request->get('lang', config('app.locale'));
//   return view('revamp.index');
// });


// //routes for testing purposes

Route::middleware(['auth'])->group(function () {
  Route::get('/testmileage', [MileageTestController::class, 'show']);
  Route::get('/gasfilter', [GasFilterController::class, 'show']);
  Route::get('/insertbill', [BillInsertController::class, 'populate']);
});

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/landing-dev', [HomeController::class,'welcomeDev']);
Route::get('/fuel-meter', [HomeController::class,'fuelMeter'])->name('fuel-meter');
  
Route::get('/archive', function() {
      return view('landing.welcome');
  });
  
  Route::post('/test', [CustomLoginController::class,'login'])->name('test');

  Auth::routes();

  Route::get('/enroll', [CampaignController::class,'bikroy']);
  Route::get('/eheater', [CampaignController::class,'eheater']);
  Route::post('/enroll/save', [CampaignController::class,'enroll']);

  //Route::post('/login', [CustomLoginController::class,'login']);
  Route::get('/logout', [CustomLoginController::class,'logout']);
  Route::get('/forgetPassword', [CustomLoginController::class,'getUserName']);
  Route::get('/password/setNewPassword', [CustomLoginController::class,'setNewPassword'])->name('setNewPassword');
  Route::post('/password/newPassword', [CustomLoginController::class,'newPassword']);
  
  Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', [HomeController::class,'index'])->name('home');
    Route::get('/car/tracking', [PositionController::class,'show'])->name('car-tracking');;
    Route::get('/car/positions/{deviceId}/{start}/{finish}/{skip}', 'Customer\PositionHistoryController@getPositions');
  });

  Route::get('/privacy-policy', [HomeController::class, 'privacy']);
  Route::get('/terms-of-service', [HomeController::class, 'privacy']);
  
  Route::post('/emergency/restore', [DatabaseTestController::class, 'restore']);
  Route::post('/emergency/restore2', [DatabaseTestController::class, 'restore2']);
  Route::post('/emergency/restore3', [DatabaseTestController::class, 'restore3']);
  Route::post('/emergency/patch', [DatabaseTestController::class, 'patch']);
  Route::get('/emergency/demo-patch', [DatabaseTestController::class, 'demoPatch']);
  Route::get('/test/demo-user', [DatabaseTestController::class, 'demoUser']);
  Route::get('/test/demo/vessel', [DemoController::class, 'vessel']);
  Route::get('/test/demo/password-reset', [DemoController::class, 'resetPassword']);
  Route::get('/test/microservice/geofence', [MicroServiceController::class, 'testGeofence']);
  Route::get('/test/microservice/session', [MicroServiceController::class, 'session']);
  Route::get('/test/microservice/device', [MicroServiceController::class, 'deviceConfig']);
  Route::get('/test/microservice/speed', [MicroServiceController::class, 'speed']);
  Route::get('/test/microservice/mileage', [MicroServiceController::class, 'mileage']);
  Route::get('/test/microservice/sms', [MicroServiceController::class, 'testSms']);
  Route::get('/test/microservice/engine', [MicroServiceController::class, 'testEngineNotification']);
  // Route::get('/test/microservice/supervisor', [MicroServiceController::class, 'trimDatabase']);
  Route::get('/test/speed/diagnose', [SpeedLimitController::class, 'diagnose']);
  Route::get('/test/fuel-events', [FuelMeterController::class, 'test']);
  Route::get('/test/mileage-push', [NotificationController::class, 'testMileagePush']);
  Route::post('/test/websocket', [SocketController::class, 'send']);
  Route::get('/test/redis', [DatabaseTestController::class, 'redis']);
  Route::get('/test/noti', [NotificationController::class, 'noti']);
  Route::get('/test/bill-notice', [NoticeController::class, 'test']);
  Route::get('/test/activation-cleanup', [ActivationController::class, 'cleanup']);
  // Route::get('/test/sms', [NotificationController::class, 'sms']);
  // Route::get('/test/last-pos', [DatabaseTestController::class, 'lastPost']);
  Route::get('/online-payment/checkout', [GatewayController::class, 'show']);
  Route::post('/online-payment/success', [GatewayController::class, 'success']);
  Route::post('/online-payment/fail', [GatewayController::class, 'fail']);
  Route::post('/online-payment/cancel', [GatewayController::class, 'cancel']);
  
  Route::get('/test/geofence/read-cache', [GeofenceController::class, 'testCacheRead']);
  Route::get('/test/geofence/write-cache', [GeofenceController::class, 'testCacheWrite']);
  Route::get('/test/bill', [BillInsertController::class, 'test']);
  Route::get('/test/remove', [DatabaseTestController::class, 'remove']);
  Route::get('/test/throttle', [DatabaseTestController::class, 'throttle']);
  Route::get('/test/notice', [NoticeController::class, 'lastMonthDue']);
  Route::any('/test/speed-noti', [SpeedLimitController::class, 'noti']);
  Route::any('/test/push-noti', [PushNotificationController::class, 'test']);
  Route::any('/test/engine-noti', [EngineStatusController::class, 'noti']);
  
  Route::get('/test/jt808/lock', [JT808Controller::class, 'lock']);
  Route::get('/test/jt808/unlock', [JT808Controller::class, 'unlock']);
  Route::get('/test/jt808/status', [JT808Controller::class, 'status']);
  
  Route::get('/test/bkash', [BkashController::class, 'test']);
  Route::post('/test/bkash', [BkashController::class, 'test']);
  
  Route::post('/test/gp33/lock', [GP33Controller::class, 'test']);
  Route::post('/test/concox/lock', [ConcoxController::class, 'lock']);
  Route::post('/test/concox/unlock', [ConcoxController::class, 'unlock']);
  Route::get('/test/concox/status', [ConcoxController::class, 'status']);
  
  Route::post('/test/excel-import', [ExcelController::class, 'testImport']);
  Route::any('/concox/test', [ConcoxController::class, 'receive']);

//    //Bkash Checkout URL
Route::get('/p', [BkashCheckoutURLController::class, 'new'])->name('url');
Route::get('/p/{uId}', [BkashCheckoutURLController::class, 'amount'])->name('url-amount');
Route::post('/bkash/pay', [BkashCheckoutURLController::class, 'payment'])->name('url-pay');
Route::post('/bkash/create', [BkashCheckoutURLController::class, 'createPayment'])->name('url-create')->middleware(['checkout_url_jwt']);
Route::get('/bkash/callback', [BkashCheckoutURLController::class, 'callback'])->name('url-callback')->middleware(['checkout_url_jwt']);
//   // Private Customer
Route::group(['middleware' => ['auth', 'role:4', 'customer:1']], function () {
  /**
   * APIs for car tracking
   */
  Route::get('/user/device/ids/{userId}', [DeviceController::class, 'devices']);

  Route::get('/refuel/log', [RefuelFeedController::class, 'customer'])->name('refuel-feed');
  Route::post('/refuel/feed/save', [RefuelFeedController::class, 'store']);

  Route::get('/checkout-iframe/success', [CheckoutIFrameController::class, 'success']);
  Route::get('/checkout-iframe/fail', [CheckoutIFrameController::class, 'fail']);

  Route::get('/checkout-iframe/amount', [CheckoutIFrameController::class, 'amount']);
  Route::get('/checkout-iframe/grant', [CheckoutIFrameController::class, 'grant']);
  Route::get('/checkout-iframe/refresh', [CheckoutIFrameController::class, 'refresh']);
  Route::post('/checkout-iframe/pay', [CheckoutIFrameController::class, 'pay']);
  Route::post('/checkout-iframe/create', [CheckoutIFrameController::class, 'create'])->middleware(['checkout_iframe_jwt']);
  Route::post('/checkout-iframe/execute', [CheckoutIFrameController::class, 'execute'])->middleware(['checkout_iframe_jwt']);
  Route::get('/checkout-iframe/query', [CheckoutIFrameController::class, 'query'])->middleware(['checkout_iframe_jwt']);
  Route::get('/checkout-iframe/search', [CheckoutIFrameController::class, 'search'])->middleware(['checkout_iframe_jwt']);
  Route::get('/checkout-iframe/refund', [CheckoutIFrameController::class, 'refund'])->middleware(['checkout_iframe_jwt']);
});

Route::get('/concox/lock/test', [ConcoxController::class, 'test']);

// TODO: remove these with backward check
// Private Customer API
// Route::group(['middleware' => ['querylog']], function() {
Route::post('/api/fuelHistories', [HistoryAPIController::class, 'fuel_histories']);
Route::post('/api/gasHistories', [HistoryAPIController::class, 'gas_histories']);
Route::post('/api/getFuelGasLevel', [HistoryAPIController::class, 'getFuelGasLevel']);
Route::get('/api/event/recent/{id}', [EventController::class, 'recent']);
// });

  // Enterprise
Route::group(['middleware' => ['auth', 'role:4', 'customer:2']], function () {
  Route::get('/enterprise/demo-modules', function () {
      return view('enterprise.modules');
  });
});

  Route::group(['middleware' => ['auth', 'role:4', 'customer:2']], function () {
  Route::get('/generators', [GeneratorController::class, 'index'])->name('generators');
  Route::get('/generator/list', [GeneratorController::class, 'all']);

  Route::get('/enterprise/car/list/{id}', [CarController::class, 'all']);

  Route::get('/driver/manage', [DriverController::class, 'manage'])->name('drivers');
  Route::get('/driver/list/{id}', [DriverController::class, 'index']);
  Route::post('/driver/save', [DriverController::class, 'save']);
  Route::post('/driver/update', [DriverController::class, 'update']);
  Route::post('/driver/delete', [DriverController::class, 'delete']);

  Route::post('/driver/assign', [AssignmentController::class, 'save']);
  Route::post('/driver/assignmentList/{id}', [AssignmentController::class, 'all']);

  Route::get('/employee/manage', [EmployeeController::class, 'manage'])->name('employees');
  Route::get('/employee/list/{id}', [EmployeeController::class, 'index']);
  Route::post('/employee/save', [EmployeeController::class, 'save']);
  Route::post('/employee/update', [EmployeeController::class, 'update']);
  Route::post('/employee/delete', [EmployeeController::class, 'delete']);

  Route::get('/driving/hour', [DrivingController::class, 'show'])->name('driving-hour');
  Route::get('/driving/hour/sum/{id}', [DrivingController::class, 'sum']);
  Route::get('/driving/hour/report/{id}', [DrivingController::class, 'report']);
  Route::get('/driving/hour/export', [DrivingController::class, 'export']);

  Route::get('/duty/hour', [DutyController::class, 'show'])->name('duty-hour');
  Route::get('/duty/hour/sum/{id}', [DutyController::class, 'sum']);
  Route::get('/duty/hour/report/{id}', [DutyController::class, 'report']);
  Route::get('/duty/hour/export', [DutyController::class, 'export_v2']);

  Route::get('/mileage/report', [MileageController::class, 'show'])->name('mileage-report');
  Route::get('/mileage/sum/{id}', [MileageController::class, 'sum']);
  Route::get('/mileage/report/{id}', [MileageController::class, 'report']);
  Route::get('/mileage/export', [MileageController::class, 'export']);
  Route::get('/tail/report', [TailController::class, 'show'])->name('tail-report');
  Route::get('/text/tracker', [TextTrackerController::class, 'show'])->name('text-tracker');
  
  Route::get('/map/search', [MapController::class, 'show'])->name('map-search');
  Route::get('/zone/car/list/{id}', [MapController::class, 'cars']);
  Route::get('/car/current/assignment/{id}', [AssignmentController::class, 'current']);
  
  Route::get('/text/tracker', [TextTrackerController::class, 'show'])->name('text-tracker');
  Route::get('/text/text-tracker/location/list/{carId}', [TextTrackerController::class, 'locations']);
  Route::get('/text/text-tracker/car/list/{userId}', [VehicleController::class, 'all'])->name('text-tracker-car-list');
  Route::get('/text/text-tracker/thana/list/{district}', [TextTrackerController::class, 'thanalist']);
  Route::get('/text/driver/assignment/info/{driverId}', [TextTrackerController::class, 'assignmentInfo']);
  
  Route::get('/enterprise/car/tracking', [TrackingController::class, 'show']);
  Route::get('/enterprise/car/route/{id}', [TrackingController::class, 'route']);
  
  Route::get('/enterprise/settings', [SettingsController::class, 'show'])->name('enterprise-settings');
  Route::get('/enterprise/settings/{userId}/{carId}', [SettingsController::class, 'view']);
  Route::post('/enterprise/settings/change', [SettingsController::class, 'change']);
  
  Route::get('enterprise/fence/list/{id}', [FenceController::class, 'enterpriseIndex']);
  Route::post('/fence/save', [FenceController::class, 'save']);
  Route::post('/fence/delete', [FenceController::class, 'delete']);

  });

//   // Admin
   Route::group(['middleware' => ['auth', 'role:1']], function() {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/details/{id}', [UserController::class, 'show']);
    Route::get('/user/create', [UserController::class, 'create']);
    Route::post('/user/save', [UserController::class, 'save']);
    Route::get('/user/edit/{id}', [UserController::class, 'edit']);
    Route::post('/user/update', [UserController::class, 'update']);
    Route::get('/user/activate/{id}', [UserController::class, 'activate']);
    Route::get('/user/deactivate/{id}', [UserController::class, 'deactivate']);

      Route::get('/billing/report',[BillingController::class,'index']);
      Route::get('/billing/export', [BillingController::class,'export']);
      Route::get('/billing/drilldown', [BillingController::class,'drilldown']);
      Route::get('/activation/report', [ActivationController::class, 'index'])->name('activation.report');
      Route::post('/activation/export', [ActivationController::class, 'export']);
      Route::post('/activation/batch/disable', [ActivationController::class, 'batchDisable']);
      
      Route::get('/devices', [DeviceController::class, 'index'])->name('devices');
      Route::get('/device/newid', [DeviceController::class, 'generateId']);
      
      Route::get('/device/bind/history', [DeviceController::class, 'bindHistory'])->name('bind.history');
      Route::get('/device/bind/export', [DeviceController::class, 'bindExport']);
      
      Route::post('/device/create', [DeviceController::class, 'save']);
      Route::get('/devices/recent/{skip}', [DeviceController::class, 'recent']);
      Route::get('/devices/print/recent', [DeviceController::class, 'print']);
      Route::get('/devices/export', [DeviceController::class, 'export']);
      Route::post('/device/update/version', [DeviceController::class, 'updateVersion']);
      
      Route::get('/bus/routes', [RouteController::class, 'index']);
      Route::get('/bus/company/names', [RouteController::class, 'companies']);
      Route::get('/bus/list/{id}', [RouteController::class, 'buses']);
      Route::post('/bus/route/save', [RouteController::class, 'save']);
      Route::post('/bus/route/delete', [RouteController::class, 'delete']);
      
      Route::get('/payment/message', [PaymentController::class, 'sendAll']);
      Route::get('/payment/method/sms', [PaymentController::class, 'sendMethodAll']);
      
      Route::get('/promotion', [PromotionController::class, 'index']);
      Route::post('/save/scheme', [PromotionController::class, 'save']);
      Route::get('/customer/ids',[CustomerController::class,'getIds']);

      Route::get('/due/notice', [NoticeController::class, 'dueNotice'])->name('due-notice');
      Route::post('/clear/due/notice', [NoticeController::class, 'clear']);
      Route::post('/send/single/notice', [NoticeController::class, 'sendSingleNotice']);
      Route::post('/send/due/notice', [NoticeController::class, 'sendDueNotice']);
      
      Route::get('/export/due/notice/{via}', [NoticeController::class, 'exportDueNotice']);
   });

  //int ops

Route::middleware(['auth', 'role:3'])->group(function () {
  Route::post('/service/api/get_service_diagnosis', [ServiceApiController::class, 'get_service_diagnosis']);

  Route::get('/service-monitor', [ServiceMonitorController::class, 'show']);
  Route::get('/user/devices/{id}', [DeviceController::class, 'allOfUser']);

  Route::post('/device/update/phone', [DeviceController::class, 'changePhone']);

  Route::get('/services/api', [ServiceApiController::class, 'index']);
  Route::post('/services/api/update', [ServiceApiController::class, 'update']);

  Route::get('/fuel/calibration/log/{id}', [FuelCalibrationController::class, 'index']);
  Route::get('/user/fuel/calibration/log/{id}', [FuelCalibrationInputController::class, 'userData']);
  Route::post('/fuel/calibration/save', [FuelCalibrationController::class, 'store']);
  Route::post('/fuel/calibration/delete', [FuelCalibrationController::class, 'remove']);

  Route::get('/gas/calibration/log/{id}', [GasCalibrationController::class, 'index']);
  Route::get('/gas/calibration/min/{id}', [GasCalibrationController::class, 'getGasMin']);
  Route::get('/gas/calibration/min/save/{carId}/{gasMin}', [GasCalibrationController::class, 'setGasMin']);
  Route::post('/gas/calibration/save', [GasCalibrationController::class, 'store']);
  Route::post('/gas/calibration/delete', [GasCalibrationController::class, 'remove']);
  Route::get('/gas/refuel/input/{id}', [GasCalibrationController::class, 'refuelInput']);

  Route::get('/car/meta-data/find/{id}', [MetaDataController::class, 'show']);
  Route::get('/car/meta-data/find/price/tune/{id}', [MetaDataController::class, 'showpricetune']);
  Route::post('/car/meta-data/update', [MetaDataController::class, 'update']);
  Route::post('/car/meta-data/tune/update', [MetaDataController::class, 'updatepricetune']);

  // Car
  Route::get('/vehicles', [CarController::class, 'index']);
  Route::get('/vehicles/search', [CarController::class, 'search']);
  Route::get('/vehicles/export', [CarController::class, 'export']);

  // Route::get('unhealthy/device', 'Device\PerformanceController@unhealthy');
});

//   // customer care

Route::group(['middleware' => ['auth', 'role:2']], function() {
  // payments
  Route::get('/payment/paymentlist/{userId}',[PaymentController::class,'index']);
  Route::get('/payment/message/{userId}',[PaymentController::class,'getMsgContent']);
  Route::get('/payment/total-due/{userId}',[PaymentController::class,'totalDue']);
  Route::post('/payment/sms/send', [PaymentController::class,'send']);      
  Route::get('/payment/method/sms/{userId}',[PaymentController::class,'sendMethod']);
  Route::post('/save/payment', [PaymentController::class,'save']);
  Route::get('/get/payments/{userId}',[PaymentController::class,'getPayments']);
  Route::get('/bkash/allbill', [BkashCheckoutURLController::class,'allBkashBill'])->name('bkash-pgw-bill');

  // promotion
  
Route::post('/promotion/notification', [PromotionController::class, 'notification']);
Route::get('/promotion/schemelist', [PromotionController::class, 'show']);
Route::get('/promo/code/list', [PromotionController::class, 'show']);
Route::get('/generate/promo', [PromotionController::class, 'generate']);
Route::post('/save/promo', [PromotionController::class, 'save']);
  
  // billing
  Route::get('/billing',[BillingController::class,'index'])->name('billing');
  Route::get('/bill/entry', [FinanceBillingController::class,'entry']);
  Route::post('/importExcel', [BillingController::class,'importExcel']);

 // customer
  Route::get('/find/customer/{phone}', [CustomerController::class,'gindByPhone']);
  Route::get('/customers', [CustomerController::class,'index'])->name('all-customers');
  Route::post('/customer/save', [CustomerController::class,'save']);
  Route::post('/customer/update', [CustomerController::class,'update']);
  Route::post('/customer/password/change', [CustomerController::class,'password']);
  Route::get('/customer/toggle-history/{id}', [CustomerController::class,'toggleHistory']);
  
  //session
  Route::get('/customer/session/list', [SessionController::class,'all']);
  Route::post('/customer/session/remove', [SessionController::class,'remove']);
  Route::post('/customer/session/logout', [SessionController::class,'logout']);

  //setting
  Route::get('/customer/settings/{id}', [SettingsController::class,'view']);
  Route::post('/customer/settings/change', [SettingsController::class,'change']);

 //message
  Route::get('/messages', [MessageController::class,'index']);

  //car
  Route::get('/car/everything', [CarController::class,'everything']);

  //speed
  Route::get('/car/speed-limit/get/{id}', [SpeedController::class,'show']);
  Route::post('/car/speed-limit/update', [SpeedController::class,'update']);

  Route::post('/zone/save', 'Enterprise\ZoneController@store');
  Route::post('/zone/delete', [ZoneController::class, 'delete']);

  Route::get('/share/user/search', [ShareController::class, 'search']);
  Route::get('/share/shared/users', [ShareController::class, 'shared']);
  Route::post('/share/provide/access', [ShareController::class, 'provide']);
  Route::post('/share/revoke/access', [ShareController::class, 'revoke']);

      Route::get('/leads', [CampaignController::class,'leads']);
      Route::get('/lead/assignment', 'Promotion\CampaignController@leadAssignment');
      Route::post('/lead/assignment/save', [CampaignController::class, 'saveAssignment']);
      Route::post('/lead/assignment/remove', [CampaignController::class, 'removeAssignment']);
      
      Route::get('/activity/login/stats/{id}', [EngagementController::class, 'login']);
      Route::get('/activity/request/stats/{id}', [EngagementController::class, 'request']);
      
      Route::get('/engagement/report', [EngagementController::class, 'index']);
      Route::get('/engagement/export', [EngagementController::class, 'export']);
      Route::get('/engagement/smspack1-enabler', [EngagementController::class, 'smsPack1Enabler']);
      
      Route::get('/geofence/library', [AreaController::class, 'library']);
      Route::post('/geofence/update', [AreaController::class, 'update']);
      Route::post('/geofence/sync-subscriptions', [AreaController::class, 'syncSubscriptions']);
      Route::get('/geofence/fetch-subscriptions', [AreaController::class, 'fetchSubscriptions']);
      
      Route::get('/fuel/fetch-groups', [FuelController::class, 'fetchGroups']);
      
      Route::get('/rms/site/list', [SiteController::class, 'index']);
      Route::get('/rms/site/create', [SiteController::class, 'create']);
      Route::post('/rms/site/save', [SiteController::class, 'save']);
      Route::get('/rms/site/edit/{id}', [SiteController::class, 'edit']);
      Route::post('/rms/site/update', [SiteController::class, 'update']);
      Route::get('/rms/site/configure/{id}', [SiteController::class, 'configure']);
      
      Route::post('/rms/site/device/bind', [SiteController::class, 'bind']);
      Route::post('/rms/site/device/unbind', [SiteController::class, 'unbind']);
      
      Route::get('/rms/site/info', [SiteController::class, 'siteInfo']);
      Route::get('/rms/site/pin/fetch', [SiteController::class, 'fetchPinConfig']);
      Route::post('/rms/site/pin/save', [SiteController::class, 'savePinConfig']);
      Route::post('/rms/site/pin/update', [SiteController::class, 'updatePinConfig']);
      Route::post('/rms/site/pin/remove', [SiteController::class, 'removePinConfig']);
  });

  Route::post('/message/save', 'Contact\MessageController@store')->name('save-message')->middleware('cors');

  Route::get('/fuel/latest/{id}', [FuelController::class, 'latest']);
  Route::get('/fuel/latestv2', [FuelController::class, 'latestv2']);
  Route::get('/fuel/history/{id}/{day}', [FuelController::class, 'history']);
  Route::get('/fuel/historyv2', [FuelController::class, 'historyv2']);
  Route::get('/gas/latest/{id}', [GasController::class, 'latest']);
  Route::get('/gas/history/{id}/{day}', [GasController::class, 'history']);
  
  Route::post('/customers/add/api', [CustomerApiController::class, 'add']);
  Route::post('/customers/delete/api', [CustomerApiController::class, 'delete']);
  Route::post('/customers/sendCredential/api', [CustomerApiController::class, 'sendCredential']);
  Route::post('/bind-services/api', [ServiceApiController::class, 'bindWithComId']);

   Route::get('/customer/vehicles/{id}', [PositionController::class,'show']);
   Route::get('/customer/vehicles/positions/{id}', [PositionController::class,'devices']);


   Route::get('/user/car/names/{userId}', [DeviceController::class, 'cars']);

   Route::group(['middleware' => ['auth']], function () {
       Route::get('/customers/api', [CustomerApiController::class, 'index']);
       Route::get('/customer/types/api', [CustomerApiController::class, 'types']);
       Route::get('/customer/info/{id}', [ManageController::class, 'info']);

  Route::get('/customer/modules', [CustomerController::class,'modules']);
  Route::get('/manage/customer/{id}', [CustomerController::class,'manage'])->name('manage.customer');
//       Route::get('/service/view', 'Customer\ServiceController@show')->name('service-view');
  Route::get('/service/view', [ServiceController::class,'show'])->name('service-view');

  Route::get('/service/log/{car}/{service}', [ServiceLogController::class, 'history']);
  Route::get('/service/report/{car_id}', [ServiceLogController::class, 'report']);
  
  // AJAX API
  Route::get('/user/account/info/{id}', [AccountController::class, 'info']);
  Route::post('/user/account/toggle', [AccountController::class, 'toggle']);
      Route::get('/user/car/list/{id}', [CarController::class,'all']);
      Route::get('/user/car/last-location',[CarController::class,'lastLocation']);

      Route::get('/car/details/{id}', [CarController::class,'show']);
      Route::post('/car/save', [CarController::class,'save']);
      Route::post('/car/update', [CarController::class,'update']);

//       Route::get('/car/state/{id}', 'Car\DeviceController@state');

      Route::get('/car/packages', [CarController::class,'packages']);
      Route::get('/car/services/{id}', [CarController::class,'services']);
      Route::get('/car/toggle-status/{id}', [CarController::class,'toggleStatus']);
      Route::post('/car/bind/device', [DeviceController::class, 'bind']);
      Route::post('/car/unbind/device', [DeviceController::class, 'unbind']);
      Route::get('/service/data/status/{cid}/{sid}', [DeviceController::class, 'status']);
      
      Route::post('/bind/token', [NotificationController::class, 'bind']);
      Route::post('/check/subscription', [NotificationController::class, 'checkSubscription']);
      
      Route::get('/mileage/records/{carId}/{days}', [MileageController::class, 'records']);
      
      Route::get('/geofence/manage', [AreaController::class, 'index'])->name('area-fence');
     Route::get('/geofence/manage', [AreaController::class,'index'])->name('area-fence');

     Route::post('/geofence/save', [AreaController::class, 'save']);
     Route::post('/geofence/subscribe', [AreaController::class, 'subscribe']);
     Route::post('/geofence/unsubscribe', [AreaController::class, 'unsubscribe']);
     Route::get('/geofence/fetch', [AreaController::class, 'fetch']);
     Route::get('/geofence/templates', [AreaController::class, 'templates']);
     Route::post('/geofence/attach/template', [AreaController::class, 'attachTemplate']);
     Route::post('/geofence/remove', [AreaController::class, 'remove']);
     Route::get('/geofence', [FenceController::class, 'index']);
     
     Route::get('/get/fence/log', [FenceLogController::class, 'index']);
     Route::get('/district/list', [DistrictController::class, 'index']);
     Route::get('/thana/list/{district}', [ThanaController::class, 'index']);
     Route::get('/fence/list/{thana}', [FenceController::class, 'items']);
     Route::post('/fence/toggle', [FenceController::class, 'toggle']);
     
     Route::get('/refuel/feed/log/{id}/{type?}', [RefuelFeedController::class, 'all']);
     Route::get('/customer/data/{id}', [CustomerApiController::class, 'info']);
     Route::get('/customer/access/of/user', [AccessController::class, 'customer']);
     Route::get('/message/access/of/user', [AccessController::class, 'messageAccess']);
     
     Route::get('/change/password', [PasswordChangeController::class, 'change']);
     Route::post('/change/password', [PasswordChangeController::class, 'reset']);
     
     Route::get('/device/status/{id}', [EngineController::class, 'status']);
     Route::post('/lock/status/toggle', [EngineController::class, 'toggle']);
     
     Route::get('/event/list/{id}', [EventController::class, 'index']);
     Route::get('/car/last/position/{deviceId}', [PositionHistoryController::class, 'getLastPosition']);
     
     Route::get('/zone/list/{id}', [ZoneController::class, 'index']);
     
     Route::get('/performance', [PerformanceController::class, 'index']);
     Route::get('/performance/stats', [PerformanceController::class, 'stats']);
     Route::get('/performance/items', [PerformanceController::class, 'items']);
     
     Route::get('/lastpulse', [LastPulseController::class, 'index']);
     Route::get('/lastpulse/stats', [LastPulseController::class, 'stats']);
     Route::get('/lastpulse/items', [LastPulseController::class, 'items']);
     Route::post('/lastpulse/update', [LastPulseController::class, 'update']);

     Route::get('/complains', [ComplainController::class, 'index']);
     Route::post('/save/complain', [ComplainController::class, 'save']);
     Route::get('/complain/list', [ComplainController::class, 'all']);
     Route::get('/complain/export', [ComplainController::class, 'export']);
     Route::get('/complain/search', [ComplainController::class, 'search']);
     Route::post('/complain/add/comment', [ComplainController::class, 'change']);

   });

   Route::get('/tracking/report', [TrackingController::class, 'report']);
   Route::get('/report/positions', [PositionController::class,'show']);
   Route::get('/report/positions/fetch',[PositionController::class,'latest']);
   Route::get('/report/positions/fetch',[PositionController::class,'latest']);

   Route::get('/tracking/history/{id}', [PositionHistoryController::class, 'show']);
   Route::get('/tracking/records/fetch', [PositionHistoryController::class, 'history']);
   
   Route::get('/home', [HomeController::class, 'index'])->name('home');
   Route::get('/home', [HomeController::class, 'index'])->name('home');