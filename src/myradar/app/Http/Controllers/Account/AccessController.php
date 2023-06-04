<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccessController extends Controller
{
    public function customer(Request $request)
    {
        $user = $this->getWebUser();

        return response()->json([
            'analytics' => [
                'status' => true, // $user->isAdmin() || $user->isOperation()
                'meta' => null,
            ],
            'account'   => [
                'status' => $user->isAdmin() || $user->isAgent(),
                'meta' => null,
            ],
            'vehicles'  => [
                'status' => true,
                'meta' => [
                    'create' => $user->isAdmin() || $user->isAgent(),
                    'tech' => $user->isAdmin() || $user->isOperation(),
                    'admin' => $user->isAdmin(),
                ]
            ],
            'payment'   => [
                'status' => $user->isAdmin() || $user->isAgent(),
                'meta' => null,
            ],
            'settings'  => [
                'status' => $user->isAdmin() || $user->isAgent(),
                'meta' => null,
            ],
            'promotion' => [
                'status' => $user->isAdmin() || $user->isAgent(),
                'meta' => null,
            ],
            'rms-manager' => [
                'status' => true,
                'meta' => null,
            ],
        ],200);
    }

    public function messageAccess(Request $request)
    {
      $user = $this->getWebUser();
      return response()->json([
        'bulkMessage'   => [
            'status' => $user->isAdmin(),
            'meta' => null,
        ],
      ]);
    }
}
