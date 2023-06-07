<?php

namespace App\Http\Controllers\Promotion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Enroll;
use App\Service\Microservice\PromotionMicroservice;

class CampaignController extends Controller
{
    private $promotionService;

    public function __construct()
    {
        $this->promotionService = new PromotionMicroservice();
    }

    public function bikroy(Request $request)
    {
        return view('promotion.bikroy')->with([
            'status' => 0,
        ]);
    }

    public function eheater(Request $request)
    {
        return view('promotion.eheater')->with([
            'status' => 0,
        ]);
    }

    public function enroll(Request $request)
    {
        try {
            $this->promotionService->saveCouponLead($request->all());
            return response()->json('আপনার রেজিস্ট্রেশন সম্পন্ন হয়েছে, আপনাকে একটি ডিসকাউন্ট কোড সহ শীঘ্রই এসএমএস করে জানানো হবে');
        } catch (\Exception $th) {
            return response()->error($th->getMessage());
        }
    }

    public function demoLead(Request $request)
    {
        try {
            $result = $this->promotionService->saveDemoLead($request->all());
            return response()->json($result);
        } catch (\Exception $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function leads(Request $request)
    {
        $type = '';
        $agent = '';
        $query = Enroll::orderBy('created_at', 'desc');
        if ($request->type) {
            $query = $query->where('type', $request->type);
            $type = $request->type;
        }
        if ($request->agent) {
            $query = $query->where('meta.agent.name', $request->agent);
            $agent = $request->agent;
        }
        return view('promotion.leads')->with([
            'leads' => $query->paginate(),
            'type' => $type,
            'agent' => $agent,
        ]);
    }

    public function leadAssignment(Request $request)
    {
        try {
            $couponAgents = $this->promotionService->filterAssignments(['type' => 'lucky_coupon_lead']);
            $demoAgents = $this->promotionService->filterAssignments(['type' => 'demo_user_lead']);
            return view('promotion.lead-assignment')->with([
                'couponAgents' => $couponAgents,
                'demoAgents' => $demoAgents,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function saveAssignment(Request $request)
    {
        try {
            $this->promotionService->saveAssignment($request->all());
            return redirect('/lead/assignment');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function removeAssignment(Request $request)
    {
        try {
            $this->promotionService->removeAssignment($request->all());
            return redirect('/lead/assignment');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
