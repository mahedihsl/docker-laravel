const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .js('resources/assets/js/position/history.js', 'public/js/position/')
   .js('resources/assets/js/position/live.js', 'public/js/position/')
   .js('resources/assets/js/fence/index.js', 'public/js/fence/')
   .js('resources/assets/js/fence/polygon.js', 'public/js/fence/')
   .js('resources/assets/js/customer/index/index.js', 'public/js/customer/')
   .js('resources/assets/js/customer/manage/manage.js', 'public/js/customer/')
   .js('resources/assets/js/customer/service.js', 'public/js/customer/')
   .js('resources/assets/js/customer/refuel.js', 'public/js/customer/')
   .js('resources/assets/js/customer/promotion/index.js', 'public/js/customer/promotion/')
   .js('resources/assets/js/car/index.js', 'public/js/car/')
   .js('resources/assets/js/device/index.js', 'public/js/device/')
   .js('resources/assets/js/device/performance/performance.js', 'public/js/device/')
   .js('resources/assets/js/device/lastPulse/last_pulse.js', 'public/js/device/')
   .js('resources/assets/js/enterprise/driver.js', 'public/js/enterprise/')
   .js('resources/assets/js/enterprise/employee.js', 'public/js/enterprise/')
   .js('resources/assets/js/enterprise/driving/driving.js', 'public/js/enterprise/')
   .js('resources/assets/js/enterprise/duty/duty.js', 'public/js/enterprise/')
   .js('resources/assets/js/enterprise/mileage/mileage.js', 'public/js/enterprise/')
   .js('resources/assets/js/enterprise/tracker/tracker.js', 'public/js/enterprise/')
   .js('resources/assets/js/enterprise/tail/tail.js', 'public/js/enterprise/')
   .js('resources/assets/js/enterprise/settings/settings', 'public/js/enterprise/')
   .js('resources/assets/js/enterprise/generator/generator', 'public/js/enterprise/')
   .js('resources/assets/js/enterprise/map.js', 'public/js/enterprise/')
   .js('resources/assets/js/bus/index.js', 'public/js/bus/')
   .js('resources/assets/js/rms/configure.js', 'public/js/rms/')
   .js('resources/assets/js/tracker/tracker.js', 'public/js/customer/')
   .js('resources/assets/js/service/complain/index.js', 'public/js/service/complain/')
   .version();
