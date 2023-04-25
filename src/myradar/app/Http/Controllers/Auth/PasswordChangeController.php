<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePassword;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    public function __construct()
    {
        # code...
    }

    public function change(Request $request)
    {
        return view('auth.reset');
    }

    public function reset(ChangePassword $request)
    {
        if (Hash::check($request->get('current'), $request->user()->password)) {
            $request->user()->fill([ 'password' => bcrypt($request->get('new')) ])->save();

            $this->flash($request->success(), 1);
            return redirect()->route('home');
        }

        $this->flash($request->failed(), 0);
        return redirect()->back();
    }
}
