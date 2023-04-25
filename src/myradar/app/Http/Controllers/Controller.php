<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getWebUser()
    {
        return Auth::user();
    }

    public function getApiUser()
    {
        return Auth::guard('api')->user();
    }

    protected function redirectToHome($message = null, $type = 1)
    {
        if ( ! is_null($message)) {
            session()->flash('msg', $message);
            session()->flash('type', $type);
        }

        return redirect()->route('home');
    }

    protected function flash($message, $type)
    {
        session()->flash('msg', $message);
        session()->flash('type', $type);
    }
}
