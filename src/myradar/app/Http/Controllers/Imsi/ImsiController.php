<?php

namespace App\Http\Controllers\Imsi;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Imsi;
use Illuminate\Http\Request;
use Session;

class ImsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $imsi = Imsi::paginate(25);

        return view('imsi.index', compact('imsi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('imsi.create');
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

        $imsi = $requestData['imsi'];
        $phone = $requestData['phone'];

        $imsi_exist = Imsi::where('imsi', $imsi)->first();
        $phone_exist = Imsi::where('phone', $phone)->first();

         if(!is_null($phone_exist) && !is_null($imsi_exist))
         {

           $errors['phone'][] = "Phone number already binded with imsi";
           $errors['imsi'][] = "Imsi already binded with  phone";
           return redirect('/imsi/create')->withErrors($errors)->withInput();
         }
        else if(!is_null($imsi_exist)){
          $errors['imsi'][] = "Imsi already binded with  phone";
          return redirect('/imsi/create')->withErrors($errors)->withInput();
        }
        else if(!is_null($phone_exist))
         {
           $errors['phone'][] = "Phone number already binded with imsi";
           return redirect('/imsi/create')->withErrors($errors)->withInput();
         }
        else{
          Imsi::create($requestData);
          \Session::flash('imsi_flash', 'Imsi added!');
          return redirect('imsi');
        }

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
        $imsi = Imsi::findOrFail($id);

        return view('imsi.show', compact('imsi'));
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
        $imsi = Imsi::findOrFail($id);

        return view('imsi.edit', compact('imsi'));
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
        $imsi = $requestData['imsi'];
        $phone = $requestData['phone'];

        $imsi = Imsi::findOrFail($id);

         if($imsi->phone!=$phone){
         $phone_exist = Imsi::where('phone', $phone)->first();

         if(!is_null($phone_exist))
          {
          $errors['phone'][] = "Phone already binded with imsi";
          return redirect()->back()->withErrors($errors)->withInput();
          }

        }

        if($imsi->imsi!=$imsi){
        $imsi_exist = Imsi::where('imsi', $imsi)->first();

        if(!is_null($imsi_exist))
         {
         $errors['imsi'][] = "Imsi already binded with  phone";
         return redirect()->back()->withErrors($errors)->withInput();
         }

       }

        $imsi->update($requestData);
        \Session::flash('imsi_flash', 'Imsi updated!');

        return redirect('imsi');
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
        Imsi::destroy($id);

        \Session::flash('imsi_flash', 'Imsi deleted!');

        return redirect('imsi');
    }
}
