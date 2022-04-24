<?php

namespace App\Http\Controllers;

use App\Models\Patientuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PincodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function pinregister(Request $request)
    {
        session_start();


        return view('setting.pincode', [
            'moduletitle' => "การตั้งค่ารหัส PIN",
            'pincode1' => $request->pincode1,
            'pincodeconfirm' => "FALSE",

        ]);
    }

    public function pinconfirm(Request $request)
    {
        session_start();

        if ($request->pincode1 == $request->pincode2) {
            $pincodeconfirm = "TRUE";
        } else {
            $pincodeconfirm = "FALSE";
        }


        return view('setting.pincode', [
            'moduletitle' => "การตั้งค่ารหัส PIN",
            'pincode1' => $request->pincode1,
            'pincodeconfirm' => $pincodeconfirm,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $settingemr = Patientuser::find($id);
        $settingemr->pincode =  $request->get('pincode2');
        $settingemr->save();

        return redirect()->route('pincode')->with('session-alert','กำหนด PIN code สำเร็จ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
