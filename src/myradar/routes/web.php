<?php

use Illuminate\Support\Facades\Route;
use App\Models\bkash;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\Promotion\CampaignController;
use App\Http\Controllers\Report\PositionController;
use App\Http\Controllers\Customer\ServiceController;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\User\CustomerController;
use App\Http\Controllers\Customer\SessionController;
use App\Http\Controllers\Enterprise\SettingsController;
use App\Http\Controllers\Contact\MessageController;
use App\Http\Controllers\Car\CarController;
use App\Http\Controllers\Car\SpeedController;

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

// Route::group(['middleware' => ['auth']], function() {
//     Route::get('/testmileage', 'Test\MileageTestController@show');
//     Route::get('/gasfilter', 'Test\GasFilterController@show');
//     Route::get('/insertbill', 'Test\BillInsertController@populate');
//   });
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

//   Route::get('/privacy-policy', 'HomeController@privacy');
//   Route::get('/terms-of-service', 'HomeController@privacy');

//   Route::post('/emergency/restore', 'Test\DatabaseTestController@restore');
//   Route::post('/emergency/restore2', 'Test\DatabaseTestController@restore2');
//   Route::post('/emergency/restore3', 'Test\DatabaseTestController@restore3');
//   Route::post('/emergency/patch', 'Test\DatabaseTestController@patch');
//   Route::get('/emergency/demo-patch', 'Test\DatabaseTestController@demoPatch');
//   Route::get('/test/demo-user', 'Test\DatabaseTestController@demoUser');
//   Route::get('/test/demo/vessel', 'Test\DemoController@vessel');
//   Route::get('/test/demo/password-reset', 'Test\DemoController@resetPassword');
//   Route::get('/test/microservice/geofence', 'Test\MicroServiceController@testGeofence');
//   Route::get('/test/microservice/session', 'Test\MicroServiceController@session');
//   Route::get('/test/microservice/device', 'Test\MicroServiceController@deviceConfig');
//   Route::get('/test/microservice/speed', 'Test\MicroServiceController@speed');
//   Route::get('/test/microservice/mileage', 'Test\MicroServiceController@mileage');
//   Route::get('/test/microservice/sms', 'Test\MicroServiceController@testSms');
//   Route::get('/test/microservice/engine', 'Test\MicroServiceController@testEngineNotification');
//   // Route::get('/test/microservice/supervisor', 'Test\MicroServiceController@trimDatabase');
//   Route::get('/test/speed/diagnose', 'Test\SpeedLimitController@diagnose');
//   Route::get('/test/fuel-events', 'Test\FuelMeterController@test');
//   Route::get('/test/mileage-push', 'Test\NotificationController@testMileagePush');
//   Route::post('/test/websocket', 'Test\SocketController@send');
//   Route::get('/test/redis', 'Test\DatabaseTestController@redis');
//   Route::get('/test/noti', 'Test\NotificationController@noti');
//   Route::get('/test/bill-notice', 'Promotion\NoticeController@test');
//   Route::get('/test/activation-cleanup', 'Admin\ActivationController@cleanup');
//   // Route::get('/test/sms', 'Test\NotificationController@sms');
//   // Route::get('/test/last-pos', 'Test\DatabaseTestController@lastPost');

//   Route::get('/online-payment/checkout', 'Payment\GatewayController@show');
//   Route::post('/online-payment/success', 'Payment\GatewayController@success');
//   Route::post('/online-payment/fail', 'Payment\GatewayController@fail');
//   Route::post('/online-payment/cancel', 'Payment\GatewayController@cancel');

//   Route::get('/test/geofence/read-cache', 'Test\GeofenceController@testCacheRead');
//   Route::get('/test/geofence/write-cache', 'Test\GeofenceController@testCacheWrite');
//   Route::get('/test/bill', 'Test\BillInsertController@test');
//   Route::get('/test/remove', 'Test\DatabaseTestController@remove');
//   Route::get('/test/throttle', 'Test\DatabaseTestController@throttle');
//   Route::get('/test/notice', 'Promotion\NoticeController@lastMonthDue');
//   Route::any('/test/speed-noti', 'Test\SpeedLimitController@noti');
//   Route::any('/test/push-noti', 'Test\PushNotificationController@test');
//   Route::any('/test/engine-noti', 'Test\EngineStatusController@noti');

//   Route::get('/test/jt808/lock', 'Test\JT808Controller@lock');
//   Route::get('/test/jt808/unlock', 'Test\JT808Controller@unlock');
//   Route::get('/test/jt808/status', 'Test\JT808Controller@status');

//   Route::get('/test/bkash', 'Test\BkashController@test');
//   Route::post('/test/bkash', 'Test\BkashController@test');

//   Route::post('/test/gp33/lock', 'Test\GP33Controller@test');
//   Route::post('/test/concox/lock', 'Test\ConcoxController@lock');
//   Route::post('/test/concox/unlock', 'Test\ConcoxController@unlock');
//   Route::get('/test/concox/status', 'Test\ConcoxController@status');

//   Route::post('/test/excel-import', 'Test\ExcelController@testImport');
//   Route::any('/concox/test', 'Test\ConcoxController@receive');

//    //Bkash Checkout URL
Route::get('/p', [App\Http\Controllers\Payment\BkashCheckoutURLController::class,'new'])->name('url');
    Route::get('/p/{uId}', [App\Http\Controllers\Payment\BkashCheckoutURLController::class,'amount'])->name('url-amount');
    Route::post('/bkash/pay',[App\Http\Controllers\Payment\BkashCheckoutURLController::class,'payment'])->name('url-pay');
    Route::post('/bkash/create',[App\Http\Controllers\Payment\BkashCheckoutURLController::class,'createPayment'])->name('url-create')->middleware(['checkout_url_jwt']);
    Route::get('/bkash/callback',[App\Http\Controllers\Payment\BkashCheckoutURLController::class,'callback'])->name('url-callback')->middleware(['checkout_url_jwt']);


//   // Private Customer
//   Route::group(['middleware' => ['auth', 'role:4', 'customer:1']], function() {

//       /**
//        * APIs for car tracking
//        */
//       Route::get('/user/device/ids/{userId}', 'Customer\DeviceController@devices');

//       Route::get('/refuel/log', 'Calibration\RefuelFeedController@customer')->name('refuel-feed');
       Route::get('/refuel/log', [App\Http\Controllers\Calibration\RefuelFeedController::class],'customer')->name('refuel-feed');
//       Route::post('/refuel/feed/save', 'Calibration\RefuelFeedController@store');

//       Route::get('/checkout-iframe/success', 'Payment\CheckoutIFrameController@success');
//       Route::get('/checkout-iframe/fail', 'Payment\CheckoutIFrameController@fail');

//       Route::get('/checkout-iframe/amount', 'Payment\CheckoutIFrameController@amount');
//       Route::get('/checkout-iframe/grant', 'Payment\CheckoutIFrameController@grant');
//       Route::get('/checkout-iframe/refresh', 'Payment\CheckoutIFrameController@refresh');
//       Route::post('/checkout-iframe/pay', 'Payment\CheckoutIFrameController@pay');
//       Route::post('/checkout-iframe/create', 'Payment\CheckoutIFrameController@create')->middleware(['checkout_iframe_jwt']);
//       Route::post('/checkout-iframe/execute', 'Payment\CheckoutIFrameController@execute')->middleware(['checkout_iframe_jwt']);
//       Route::get('/checkout-iframe/query', 'Payment\CheckoutIFrameController@query')->middleware(['checkout_iframe_jwt']);
//       Route::get('/checkout-iframe/search', 'Payment\CheckoutIFrameController@search')->middleware(['checkout_iframe_jwt']);
//       Route::get('/checkout-iframe/refund', 'Payment\CheckoutIFrameController@refund')->middleware(['checkout_iframe_jwt']);

//   });

//   Route::get('/concox/lock/test', 'Device\ConcoxController@test');

//   // TODO: remove these with backwawrd check
//   // Private Customer API
//   // Route::group(['middleware' => ['querylog']], function() {
//       Route::post('/api/fuelHistories', 'Api\Device\HistoryAPIController@fuel_histories');
//       Route::post('/api/gasHistories', 'Api\Device\HistoryAPIController@gas_histories');
//       Route::post('/api/getFuelGasLevel', 'Api\Device\HistoryAPIController@getFuelGasLevel');
//       Route::get('/api/event/recent/{id}','Car\EventController@recent');
//   // });

//   // Enterprise
//   Route::group(['middleware' => ['auth', 'role:4', 'customer:2']], function() {
//       Route::get('/enterprise/demo-modules', function() {
//           return view('enterprise.modules');
//       });

//       Route::get('/generators', 'Enterprise\GeneratorController@index')->name('generators');
//       Route::get('/generator/list', 'Enterprise\GeneratorController@all');

//       Route::get('/enterprise/car/list/{id}', 'Enterprise\CarController@all');

//       Route::get('/driver/manage', 'Enterprise\DriverController@manage')->name('drivers');
//       Route::get('/driver/list/{id}', 'Enterprise\DriverController@index');
//       Route::post('/driver/save', 'Enterprise\DriverController@save');
//       Route::post('/driver/update', 'Enterprise\DriverController@update');
//       Route::post('/driver/delete', 'Enterprise\DriverController@delete');

//       Route::post('/driver/assign', 'Enterprise\AssignmentController@save');
//       Route::post('/driver/assignmentList/{id}', 'Enterprise\AssignmentController@all');

//       Route::get('/employee/manage', 'Enterprise\EmployeeController@manage')->name('employees');
//       Route::get('/employee/list/{id}', 'Enterprise\EmployeeController@index');
//       Route::post('/employee/save', 'Enterprise\EmployeeController@save');
//       Route::post('/employee/update', 'Enterprise\EmployeeController@update');
//       Route::post('/employee/delete', 'Enterprise\EmployeeController@delete');

//       Route::get('/driving/hour', 'Enterprise\DrivingController@show')->name('driving-hour');
//       Route::get('/driving/hour/sum/{id}', 'Enterprise\DrivingController@sum');
//       Route::get('/driving/hour/report/{id}', 'Enterprise\DrivingController@report');
//       Route::get('/driving/hour/export','Enterprise\DrivingController@export');

//       Route::get('/duty/hour', 'Enterprise\DutyController@show')->name('duty-hour');
//       Route::get('/duty/hour/sum/{id}', 'Enterprise\DutyController@sum');
//       Route::get('/duty/hour/report/{id}', 'Enterprise\DutyController@report');
//       Route::get('/duty/hour/export', 'Enterprise\DutyController@export_v2');

//       Route::get('/mileage/report', 'Enterprise\MileageController@show')->name('mileage-report');
//       Route::get('/mileage/sum/{id}', 'Enterprise\MileageController@sum');
//       Route::get('/mileage/report/{id}', 'Enterprise\MileageController@report');
//       Route::get('/mileage/export', 'Enterprise\MileageController@export');

//       Route::get('/tail/report', 'Enterprise\TailController@show')->name('tail-report');

//       Route::get('/text/tracker', 'Enterprise\TextTrackerController@show')->name('text-tracker');

//       Route::get('/map/search', 'Enterprise\MapController@show')->name('map-search');
//       Route::get('/zone/car/list/{id}', 'Enterprise\MapController@cars');
//       Route::get('/car/current/assignment/{id}', 'Enterprise\AssignmentController@current');

//       Route::get('/text/tracker', 'Enterprise\TextTrackerController@show')->name('text-tracker');
//       Route::get('/text/text-tracker/location/list/{carId}','Enterprise\TextTrackerController@locations' );
//       Route::get('/text/text-tracker/car/list/{userId}','Enterprise\VehicleController@all')->name('text-tracker-car-list');
//       Route::get('/text/text-tracker/thana/list/{district}','Enterprise\TextTrackerController@thanalist');
//       Route::get('/text/driver/assignment/info/{driverId}','Enterprise\TextTrackerController@assignmentInfo');

//       Route::get('/enterprise/car/tracking', 'Car\TrackingController@show');
//       Route::get('/enterprise/car/route/{id}', 'Enterprise\TrackingController@route');

//       Route::get('/enterprise/settings', 'Enterprise\SettingsController@show')->name('enterprise-settings');
//       Route::get('/enterprise/settings/{userId}/{carId}', 'Enterprise\SettingsController@view');
//       Route::post('/enterprise/settings/change', 'Enterprise\SettingsController@change');

//       Route::get('enterprise/fence/list/{id}', 'Api\GeoFence\FenceController@enterpriseIndex');
//       Route::post('/fence/save', 'Api\GeoFence\FenceController@save');
//       Route::post('/fence/delete', 'Api\GeoFence\FenceController@delete');
//   });

//   // Admin
   Route::group(['middleware' => ['auth', 'role:1']], function() {
//       Route::get('/users', 'User\UserController@index');
//       Route::get('/user/details/{id}', 'User\UserController@show');
//       Route::get('/user/create', 'User\UserController@create');
//       Route::post('/user/save', 'User\UserController@save');
//       Route::get('/user/edit/{id}', 'User\UserController@edit');
//       Route::post('/user/update', 'User\UserController@update');
//       Route::get('/user/activate/{id}', 'User\UserController@activate');
//       Route::get('/user/deactivate/{id}', 'User\UserController@deactivate');

      Route::get('/billing/report',[BillingController::class,'index']);
      Route::get('/billing/export', [BillingController::class,'export']);
      Route::get('/billing/drilldown', [BillingController::class,'drilldown']);

//       Route::get('/activation/report', 'Admin\ActivationController@index')->name('activation.report');
//       Route::post('/activation/export', 'Admin\ActivationController@export');
//       Route::post('/activation/batch/disable', 'Admin\ActivationController@batchDisable');

//       Route::get('/devices', 'Device\DeviceController@index')->name('devices');
//       Route::get('/device/newid', 'Device\DeviceController@generateId');

//       Route::get('/device/bind/history', 'Device\DeviceController@bindHistory')->name('bind.history');
//       Route::get('/device/bind/export', 'Device\DeviceController@bindExport');

//       Route::post('/device/create', 'Device\DeviceController@save');
//       Route::get('/devices/recent/{skip}', 'Device\DeviceController@recent');
//       Route::get('/devices/print/recent', 'Device\DeviceController@print');
//       Route::get('/devices/export','Device\DeviceController@export');
//       Route::post('/device/update/version', 'Device\DeviceController@updateVersion');

//       Route::get('/bus/routes', 'Bus\RouteController@index');
//       Route::get('/bus/company/names', 'Bus\RouteController@companies');
//       Route::get('/bus/list/{id}', 'Bus\RouteController@buses');
//       Route::post('/bus/route/save', 'Bus\RouteController@save');
//       Route::post('/bus/route/delete', 'Bus\RouteController@delete');

//       Route::get('/payment/message','Payment\PaymentController@sendAll');
//       Route::get('/payment/method/sms','Payment\PaymentController@sendMethodAll');

//       Route::get('/promotion','Promotion\PromotionController@index');
//       Route::post('/save/scheme','Promotion\PromotionController@save');
       Route::get('/customer/ids',[CustomerController::class,'getIds']);

//       Route::get('/due/notice', 'Promotion\NoticeController@dueNotice')->name('due-notice');
//       Route::post('/clear/due/notice', 'Promotion\NoticeController@clear');
//       Route::post('/send/single/notice', 'Promotion\NoticeController@sendSingleNotice');
//       Route::post('/send/due/notice', 'Promotion\NoticeController@sendDueNotice');

//       Route::get('/export/due/notice/{via}', 'Promotion\NoticeController@exportDueNotice');
   });

//   //int ops
//   Route::group(['middleware' => ['auth', 'role:3']], function() {
//       Route::post('/service/api/get_service_diagnosis', 'Service\ServiceApiController@get_service_diagnosis');

//       Route::get('/service-monitor', 'ServiceMonitor\ServiceMonitorController@show');
//       Route::get('/user/devices/{id}', 'Device\DeviceController@allOfUser');

//       Route::post('/device/update/phone', 'Device\DeviceController@changePhone');

//       Route::get('/services/api', 'Service\ServiceApiController@index');
//       Route::post('/services/api/update', 'Service\ServiceApiController@update');

//       Route::get('/fuel/calibration/log/{id}', 'Calibration\FuelCalibrationController@index');
//       Route::get('/user/fuel/calibration/log/{id}', 'Input\FuelCalibrationInputController@userData');
//       Route::post('/fuel/calibration/save', 'Calibration\FuelCalibrationController@store');
//       Route::post('/fuel/calibration/delete', 'Calibration\FuelCalibrationController@remove');

//       Route::get('/gas/calibration/log/{id}', 'Calibration\GasCalibrationController@index');
//       Route::get('/gas/calibration/min/{id}', 'Calibration\GasCalibrationController@getGasMin');
//       Route::get('/gas/calibration/min/save/{carId}/{gasMin}','Calibration\GasCalibrationController@setGasMin');
//       Route::post('/gas/calibration/save', 'Calibration\GasCalibrationController@store');
//       Route::post('/gas/calibration/delete', 'Calibration\GasCalibrationController@remove');
//       Route::get('/gas/refuel/input/{id}', 'Calibration\GasCalibrationController@refuelInput');

//       Route::get('/car/meta-data/find/{id}', 'Calibration\MetaDataController@show');
//       Route::get('/car/meta-data/find/price/tune/{id}', 'Calibration\MetaDataController@showpricetune');
//       Route::post('/car/meta-data/update', 'Calibration\MetaDataController@update');
//       Route::post('/car/meta-data/tune/update', 'Calibration\MetaDataController@updatepricetune');

      //car
       Route::get('/vehicles', [CarController::class,'index']);
       Route::get('/vehicles/search', [CarController::class,'search']);
       Route::get('/vehicles/export', [CarController::class,'export']);

//       Route::get('unhealthy/device', 'Device\PerformanceController@unhealthy');
//   });

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
  Route::get('/bkash/allbill', [App\Http\Controllers\Payment\BkashCheckoutURLController::class,'allBkashBill'])->name('bkash-pgw-bill');

  // promotion
  Route::post('/promotion/notification',[App\Http\Controllers\Promotion\PromotionController::class,'notification']);
  Route::get('/promotion/schemelist',[App\Http\Controllers\Promotion\PromotionController::class,'show']);
  Route::get('/promo/code/list',[App\Http\Controllers\Promotion\PromotionController::class,'show']);
  Route::get('/generate/promo',[App\Http\Controllers\Promotion\PromotionController::class,'generate']);
  Route::post('/save/promo',[App\Http\Controllers\Promotion\PromotionController::class,'save']);
  
  // billing
  Route::get('/billing',[BillingController::class,'index'])->name('billing');
  Route::get('/bill/entry', [BillingController::class,'entry']);
  Route::post('/importExcel', [BillingController::class,'importExcel']);

 // customer
  Route::get('/find/customer/{phone}', [CustomerController::class,'gindByPhone']);
  Route::get('/customers', 'User\CustomerController@index')->name('all-customers');
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
//       Route::post('/zone/delete', 'Enterprise\ZoneController@delete');

//       Route::get('/share/user/search', 'Enterprise\ShareController@search');
//       Route::get('/share/shared/users', 'Enterprise\ShareController@shared');
//       Route::post('/share/provide/access', 'Enterprise\ShareController@provide');
//       Route::post('/share/revoke/access', 'Enterprise\ShareController@revoke');

      Route::get('/leads', [CampaignController::class,'leads']);
      Route::get('/lead/assignment', 'Promotion\CampaignController@leadAssignment');
//       Route::post('/lead/assignment/save', 'Promotion\CampaignController@saveAssignment');
//       Route::post('/lead/assignment/remove', 'Promotion\CampaignController@removeAssignment');

//       Route::get('/activity/login/stats/{id}', 'Admin\EngagementController@login');
//       Route::get('/activity/request/stats/{id}', 'Admin\EngagementController@request');

//       Route::get('/engagement/report', 'Admin\EngagementController@index');
//       Route::get('/engagement/export', 'Admin\EngagementController@export');
//       Route::get('/engagement/smspack1-enabler', 'Admin\EngagementController@smsPack1Enabler');

//       Route::get('/geofence/library', 'Fence\AreaController@library');
//       Route::post('/geofence/update', 'Fence\AreaController@update');
//       Route::post('/geofence/sync-subscriptions', 'Fence\AreaController@syncSubscriptions');
//       Route::get('/geofence/fetch-subscriptions', 'Fence\AreaController@fetchSubscriptions');

//       // Route::get('/fuel/seed-groups', 'Service\FuelController@seedGroups');
//       Route::get('/fuel/fetch-groups', 'Service\FuelController@fetchGroups');

//       Route::get('/rms/site/list', 'RMS\SiteController@index');
//       Route::get('/rms/site/create', 'RMS\SiteController@create');
//       Route::post('/rms/site/save', 'RMS\SiteController@save');
//       Route::get('/rms/site/edit/{id}', 'RMS\SiteController@edit');
//       Route::post('/rms/site/update', 'RMS\SiteController@update');
//       Route::get('/rms/site/configure/{id}', 'RMS\SiteController@configure');

//       Route::post('/rms/site/device/bind', 'RMS\SiteController@bind');
//       Route::post('/rms/site/device/unbind', 'RMS\SiteController@unbind');

//       Route::get('/rms/site/info', 'RMS\SiteController@siteInfo');
//       Route::get('/rms/site/pin/fetch', 'RMS\SiteController@fetchPinConfig');
//       Route::post('/rms/site/pin/save', 'RMS\SiteController@savePinConfig');
//       Route::post('/rms/site/pin/update', 'RMS\SiteController@updatePinConfig');
//       Route::post('/rms/site/pin/remove', 'RMS\SiteController@removePinConfig');
  });

  Route::post('/message/save', 'Contact\MessageController@store')->name('save-message')->middleware('cors');

//   Route::get('/fuel/latest/{id}', 'Service\FuelController@latest');
//   Route::get('/fuel/latestv2', 'Service\FuelController@latestv2');
//   Route::get('/fuel/history/{id}/{day}', 'Service\FuelController@history');
//   Route::get('/fuel/historyv2', 'Service\FuelController@historyv2');
//   Route::get('/gas/latest/{id}', 'Service\GasController@latest');
//   Route::get('/gas/history/{id}/{day}', 'Service\GasController@history');

//   Route::post('/customers/add/api', 'User\CustomerApiController@add');//int-ops
//   Route::post('/customers/delete/api', 'User\CustomerApiController@delete');//int-ops
//   Route::post('/customers/sendCredential/api', 'User\CustomerApiController@sendCredential');//int-ops
//   Route::post('/bind-services/api', 'Service\ServiceApiController@bindWithComId');//int-op

   Route::get('/customer/vehicles/{id}', [PositionController::class,'show']);
   Route::get('/customer/vehicles/positions/{id}', [PositionController::class,'devices']);

//   Route::get('/user/car/names/{userId}', 'Customer\DeviceController@cars');

//   Route::group(['middleware' => ['auth']], function () {
//       Route::get('/customers/api', 'User\CustomerApiController@index');
//       Route::get('/customer/types/api', 'User\CustomerApiController@types');
//       Route::get('/customer/info/{id}', 'Customer\ManageController@info');
      
  Route::get('/customer/modules', [CustomerController::class,'modules']);
  Route::get('/manage/customer/{id}', [CustomerController::class,'manage'])->name('manage.customer');
//       Route::get('/service/view', 'Customer\ServiceController@show')->name('service-view');
  Route::get('/service/view', [ServiceController::class,'show'])->name('service-view');

//       Route::get('/service/log/{car}/{service}', 'Service\ServiceLogController@history');
//       Route::get('/service/report/{car_id}', 'Service\ServiceLogController@report');

//       // AJAX API
//       Route::get('/user/account/info/{id}', 'Customer\AccountController@info');
//       Route::post('/user/account/toggle', 'Customer\AccountController@toggle');
      Route::get('/user/car/list/{id}', [CarController::class,'all']);
      Route::get('/user/car/last-location',[CarController::class,'lastLocation']);

      Route::get('/car/details/{id}', [CarController::class,'show']);
      Route::post('/car/save', [CarController::class,'save']);
      Route::post('/car/update', [CarController::class,'update']);

//       Route::get('/car/state/{id}', 'Car\DeviceController@state');

      Route::get('/car/packages', [CarController::class,'packages']);
      Route::get('/car/services/{id}', [CarController::class,'services']);
      Route::get('/car/toggle-status/{id}', [CarController::class,'toggleStatus']);

//       Route::post('/car/bind/device', 'Car\DeviceController@bind');
//       Route::post('/car/unbind/device', 'Car\DeviceController@unbind');
//       Route::get('/service/data/status/{cid}/{sid}', 'Car\DeviceController@status');

//       Route::post('/bind/token', 'Api\User\NotificationController@bind');
//       Route::post('/check/subscription','Api\User\NotificationController@checkSubscription');
//       // END

//       Route::get('/mileage/records/{carId}/{days}', 'Service\MileageController@records');

     // Route::get('/geofence/manage', 'Fence\AreaController@index')->name('area-fence');
     Route::get('/geofence/manage', [App\Http\Controllers\Fence\AreaController::class,'index'])->name('area-fence');


//       Route::post('/geofence/save', 'Fence\AreaController@save');
//       Route::post('/geofence/subscribe', 'Fence\AreaController@subscribe');
//       Route::post('/geofence/unsubscribe', 'Fence\AreaController@unsubscribe');
//       Route::get('/geofence/fetch', 'Fence\AreaController@fetch');
//       Route::get('/geofence/templates', 'Fence\AreaController@templates');
//       Route::post('/geofence/attach/template', 'Fence\AreaController@attachTemplate');
//       Route::post('/geofence/remove', 'Fence\AreaController@remove');
//       Route::get('/geofence', 'Fence\FenceController@index');

//       Route::get('/get/fence/log', 'Fence\FenceLogController@index');
//       Route::get('/district/list', 'Fence\DistrictController@index');
//       Route::get('/thana/list/{district}', 'Fence\ThanaController@index');
//       Route::get('/fence/list/{thana}', 'Fence\FenceController@items');
//       Route::post('/fence/toggle', 'Fence\FenceController@toggle');

//       Route::get('/refuel/feed/log/{id}/{type?}', 'Calibration\RefuelFeedController@all');
//       Route::get('/customer/data/{id}', 'User\CustomerApiController@info');
//       Route::get('/customer/access/of/user', 'Account\AccessController@customer');
//       Route::get('/message/access/of/user', 'Account\AccessController@messageAccess');

//       Route::get('/change/password', 'Auth\PasswordChangeController@change');
//       Route::post('/change/password', 'Auth\PasswordChangeController@reset');

//       Route::get('/device/status/{id}', 'Api\Device\EngineController@status');
//       Route::post('/lock/status/toggle', 'Api\Device\EngineController@toggle');

//       Route::get('/event/list/{id}', 'Car\EventController@index');
//       Route::get('/car/last/position/{deviceId}', 'Customer\PositionHistoryController@getLastPosition');

//       Route::get('/zone/list/{id}', 'Enterprise\ZoneController@index');

//       Route::get('/performance', 'Device\PerformanceController@index');
//       Route::get('/performance/stats', 'Device\PerformanceController@stats');
//       Route::get('/performance/items', 'Device\PerformanceController@items');

//       Route::get('/lastpulse', 'Device\LastPulseController@index');
//       Route::get('/lastpulse/stats', 'Device\LastPulseController@stats');
//       Route::get('/lastpulse/items', 'Device\LastPulseController@items');
//       Route::post('/lastpulse/update', 'Device\LastPulseController@update');

//       Route::get('/complains', 'ServiceMonitor\ComplainController@index');
//       Route::post('/save/complain', 'ServiceMonitor\ComplainController@save');
//       Route::get('/complain/list', 'ServiceMonitor\ComplainController@all');
//       Route::get('/complain/export', 'ServiceMonitor\ComplainController@export');
//       Route::get('/complain/search', 'ServiceMonitor\ComplainController@search');
//       Route::post('/complain/add/comment', 'ServiceMonitor\ComplainController@change');
//   });

//   Route::get('/tracking/report', 'Report\TrackingController@report');
   Route::get('/report/positions', [PositionController::class,'show']);
   Route::get('/report/positions/fetch',[PositionController::class,'latest']);
   Route::get('/report/positions/fetch',[PositionController::class,'latest']);

//   Route::get('/tracking/history/{id}', 'Customer\PositionHistoryController@show');
//   Route::get('/tracking/records/fetch', 'Customer\PositionHistoryController@history');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


 Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
