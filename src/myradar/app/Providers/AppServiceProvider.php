<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Jenssegers\Mongodb\Eloquent\Builder;
use Prettus\Repository\Providers\RepositoryServiceProvider;
use Validator;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Providers\ObserverServiceProvider;
use App\Providers\RepositoryServiceProvider as newRepositoryServiceProvider;
use App\Providers\ResponseMacroServiceProvider ;
use Illuminate\Support\Facades\View;



class LaravelLoggerProxy
{
    public function log($msg)
    {
    }
}


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //URL::forceScheme('https');

        Validator::extend('bd_phone', function ($attribute, $value, $parameters, $validator) {
            return preg_match('^(?:\+?88)?01[15-9]\d{8}$^', $value) && strlen($value) >= 10;
        });

        Validator::replacer('bd_phone', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute is invalid phone number');
        });

        //user's current passwrd
        Validator::extend('current_password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, Auth::user()->password);
        });

        Validator::replacer('current_password', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'Password is wrong');
        });



        View::share('hasHttps', env('APP_ENV')=='production');



    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Builder::macro('getName', function () {
        //     return 'mongodb';
        //     // return $this->getModel()->getConnectionName();
        // });

        if ($this->app->environment('local', 'testing')) {
           // $this->app->register(DuskServiceProvider::class);
        }
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(newRepositoryServiceProvider::class);
        $this->app->register(ObserverServiceProvider::class);
        $this->app->register(ResponseMacroServiceProvider::class);
        $this->app->bind('App\Service\Calibration\CalibrationService', 'App\Service\Calibration\CalibrationServiceImpl');

        $this->app->bind('package', function () {
            return new \App\Service\PackageService;
        });
    }
}
