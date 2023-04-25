<?php

namespace App\Http\Controllers\Recharge;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Recharge;
use App\Entities\Imsi;
use App\Entities\Device;
use App\Entities\User;
use Illuminate\Http\Request;
use Session;
use App\Exceptions\Handler;
use Exception;
use Carbon\Carbon;

class RechargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 15;

        if (!empty($keyword)) {
            $recharge = Recharge::orderBy('created_at', 'desc')->paginate($perPage);
        } else {
            $recharge = Recharge::orderBy('created_at', 'desc')->paginate($perPage);
        }

        return view('recharge.index', compact('recharge'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('recharge.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $phone = $request->get('phone');

        $imsi_phone = Imsi::where('phone', $phone)->first();
        if (is_null($imsi_phone)) {
            $errors['phone'][] = "Please Map Phone number with Imsi";

            return view('recharge.create')->withErrors($errors);
        }

        $Device = Device::where('imsi', '=', $imsi_phone->imsi)->first();

        if (is_null($Device)) {
            $errors['phone'][] = "Imsi binded with this phone not mapped with Device";

            return view('recharge.create')->withErrors($errors);
        }

        $requestData['device_id'] = $Device->id;
        $requestData['consumed'] = 0;
        $requestData['remained'] = $requestData['volume'];


        if (Recharge::create($requestData)) {
            //update device balance
            $data['balance']['recharged_at'] = Carbon::createFromFormat('Y-d-m', $requestData['recharged_at'])->timestamp;
            $data['balance']['validity'] = Carbon::createFromFormat('Y-d-m', $requestData['validity'])->timestamp;
            $data['balance']['volume'] = $requestData['volume'];
            $data['balance']['consumed'] =0;
            $data['balance']['remained'] =  $requestData['volume'];

            $Device->update($data);

            \Session::flash('flash_message', 'Recharge added!');
        } else {
            Session::flash('flash_message', 'Recharge add failed!');
        }

        return redirect('recharge');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $recharge = Recharge::findOrFail($id);

        return view('recharge.show', compact('recharge'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $recharge = Recharge::findOrFail($id);

        return view('recharge.edit', compact('recharge'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $requestData = $request->all();
        $recharge = Recharge::findOrFail($id);
        //
        // $imsi = Imsi::where('phone',$recharge->phone)->first();
        //
        // $Device = Device::where('imsi','=',$imsi->imsi)->first();
        //
        $recharge->update($requestData);

        Session::flash('flash_message', 'Recharge updated!');
        return redirect('recharge');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Recharge::destroy($id);

        Session::flash('flash_message', 'Recharge deleted!');

        return redirect('recharge');
    }
}
