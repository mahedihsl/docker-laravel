<?php

namespace App\Http\Controllers\Api\RadarRecharge;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Microservice\ServiceException;
use App\Service\Microservice\RadarRechargeMicroservice;

class RadarController extends Controller
{
    private $radarService;

    public function __construct()
    {
        $this->radarService = new RadarRechargeMicroservice();
    }

    public function signup(Request $request)
    {
        try {
            return response()->json($this->radarService->signup($request->all()));
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
    
    public function test(Request $request)
    {
        try {
            $headers = ['Authorization' => 'Bearer ' . $request->bearerToken()];
            // return $headers;
            return response()->json($this->radarService->test($request->all(), $headers));
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
    
    public function validateCard(Request $request)
    {
        try {
            $headers = ['Authorization' => 'Bearer ' . $request->bearerToken()];
            return response()->json($this->radarService->validate($request->all(), $headers));
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
    
    public function rechargeCard(Request $request)
    {
        try {
            $headers = ['Authorization' => 'Bearer ' . $request->bearerToken()];
            return response()->json($this->radarService->recharge($request->all(), $headers));
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
    
    public function confirmWrite(Request $request)
    {
        try {
            $headers = ['Authorization' => 'Bearer ' . $request->bearerToken()];
            return response()->json($this->radarService->confirm($request->all(), $headers));
        } catch (ServiceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
