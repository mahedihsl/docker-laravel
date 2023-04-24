<?php

use Illuminate\Support\Facades\Route;
use App\Models\bkash;

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

Route::get('/', function () {
    $query = bkash::where('is_successful', false)->get();

    dd($query);
})->name('welcome');

Route::get('/home', function() {
    //$lang = $request->get('lang', config('app.locale'));

        return view('revamp.index');
});
