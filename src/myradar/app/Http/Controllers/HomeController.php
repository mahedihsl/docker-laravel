<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Entities\User;
use App\Service\Microservice\SupervisorMicroservice;
use Exception;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function welcome(Request $request)
    {
        $lang = $request->get('lang', config('app.locale'));
        \App::setLocale($lang);
        return view('revamp.index');
    }
    
    public function welcomeDev(Request $request)
    {
        $lang = $request->get('lang', config('app.locale'));
        \App::setLocale($lang);
        return view('revamp.index_dev');
    }

    public function fuelMeter(Request $request)
    {
        $lang = $request->get('lang', config('app.locale'));
        \App::setLocale($lang);
        return view('revamp.fuel-meter');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->getWebUser();
        if($user->type==User::$TYPE_CUSTOMER && $user->customer_type==User::$CUSTOMER_ENTERPRISE)
         {
           return view('home.enterprise');

         }
        switch ($user->type) {
            case User::$TYPE_ADMIN:
                return view('home.admin');
            case User::$TYPE_AGENT:
                return view('home.agent');
            case User::$TYPE_GOVT:
                return view('home.govt');
            case User::$TYPE_OPERATION:
                return view('home.operation');
            case User::$TYPE_CALIBRATION:
                return view('home.calibration');
            case User::$TYPE_CUSTOMER:
                return view('home.customer')->with([
                    'id'=>Auth::user()->id
                ]);
        }
    }

    public function privacy(Request $request)
    {
        return view('misc.privacy');
    }

    public function runningServer(Request $request)
    {
        try {
            $service = new SupervisorMicroservice();
            return response()->json($service->runningServer());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
